<?php

namespace App\Http\Controllers\Admin;

use App\Models\Upload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:uploads_read'])->only(['index']);
        $this->middleware(['permission:uploads_create'])->only(['create', 'store']);
        $this->middleware(['permission:uploads_update'])->only(['edit', 'update']);
        $this->middleware(['permission:uploads_delete'])->only(['destroy']);
        ini_set('memory_limit', '10240M');
        ini_set('max_execution_time', 600);
    }

    public function index(Request $request)
    {
        // Get the status and search query from the request
        $type = $request->input('type', ''); // Default is 'all'
        $search = $request->input('search', '');   // Default is empty string
        $uploads = Upload::query();
        $uploadsQuery = Upload::query();
        // Apply filter based on type
        if ($type != '') {
            $uploads->where('type', $type);
        }
        // Apply search filter if a search term is provided
        if (!empty($search)) {
            $uploads->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('extension', 'LIKE', '%' . $search . '%');
            });
        }
        // Get the filtered uploads with pagination
        $uploads = $uploads->latest()->paginate(20);

        $uploadsQuery = $uploadsQuery->selectRaw('type, COUNT(*) as count, SUM(size) as total_size')
            ->groupBy('type')
            ->get();
        // Extract counts and total size
        $total_images = $uploadsQuery->where('type', 'image')->first()->count ?? 0;
        $total_applications = $uploadsQuery->where('type', 'application')->first()->count ?? 0;
        $totalSizeInBytes = $uploadsQuery->sum('total_size') ?? 0;

        // Return the view with the uploads and filters
        return view('admin.pages.uploads.index', compact(
            'uploads',
            'total_images',
            'total_applications',
            'totalSizeInBytes',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400',
        ]);

        if ($request->hasFile('file')) {
            // Get the file size
            $size = $request->file('file')->getSize();
            // Get the file type
            $type = explode('/', $request->file('file')->getMimeType())[0];
            // Get the file extension
            $extension = $request->file('file')->getClientOriginalExtension();

            $user = Auth::user();
            $userId = $user->id;
            if ($type == 'image') {
                // Generate a random name for the image
                $imageName = Str::random(20) . uniqid() . '.' . $extension;
                // Create the image using Intervention Image
                $img = Image::read($request->file('file')->getRealPath());
                // Define the directory path
                $directoryPath = public_path('images');

                // Ensure the directory exists
                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0755, true); // Create the directory with write permissions
                }

                // Define the full path where the image will be stored
                $path = $directoryPath . '/' . $imageName;

                // Save the image to the desired path
                $img->save($path);
                $path =  'images/' . $imageName;
            } else {
                // For non-image files, store them privately
                $path = $request->file('file')->store('private/uploads');
            }

            // Save file information in the database
            $upload = Upload::create([
                'title' => $request->file('file')->getClientOriginalName(),
                'path' => $path, // Correctly saved path
                'size' => $size,
                'type' => $type,
                'extension' => $extension,
                'user_id' => $userId,
                'external_link' => '', // Optional external link
            ]);
            \Illuminate\Support\Facades\Cache::forget('fetch_uploads_' . $type);
            // Return a response with the uploaded file ID and path
            return response()->json(['upload_id' => $upload->id, 'path' => Storage::url($path)]);
        }

        return response()->json(['message' => 'Not found'], 422);
    }

    public function fetch_uploads(Request $request)
    {
        $type = $request->query('type', 'image');

        $uploads = \Illuminate\Support\Facades\Cache::remember('fetch_uploads_' . $type, 86400, function () use ($type) {
            $uploads = Upload::query()->where('type', $type);
            $uploads = $uploads->latest()->get();
            return $uploads;
        });
        return response()->json(['uploads' => $uploads]);
    }

    public function edit(Upload $upload)
    {
        return view('admin.pages.uploads.edit', compact('upload'));
    }

    public function update(Request $request, Upload $upload)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Update the upload
        $upload->update([
            'title' => $request->input('title'),
        ]);
        Artisan::call('cache:clear');
        return redirect()->route('admin.uploads.index')->with('success', __('Updated successfully'));
    }

    public function streamFile(Request $request, Upload $upload)
    {
        $filePath = storage_path('app/' . $upload->path);

        // Open the file
        $fileSize = filesize($filePath);
        $file = fopen($filePath, 'rb');

        $start = 0;
        $end = $fileSize - 1;

        // Check for the Range header to support partial downloads
        if ($request->hasHeader('Range')) {
            $range = $request->header('Range');
            list(, $range) = explode('=', $range, 2);
            $range = explode('-', $range);
            $start = intval($range[0]);

            // Ensure the end byte is not larger than the file size
            $end = isset($range[1]) && is_numeric($range[1]) ? intval($range[1]) : $end;

            // Set the response status to 206 (Partial Content)
            $responseStatus = 206;
        } else {
            // No Range header, return the entire file
            $responseStatus = 200;
        }

        // Set headers for partial content delivery
        $headers = [
            'Content-Type'        => mime_content_type($filePath),
            'Content-Length'      => ($end - $start + 1),
            'Accept-Ranges'       => 'bytes',
            'Content-Range'       => "bytes $start-$end/$fileSize"
        ];

        // Stream the file in chunks
        $stream = function () use ($file, $start, $end) {
            fseek($file, $start);
            $chunkSize = 8192; // 8 KB chunks

            while (!feof($file) && ftell($file) <= $end) {
                echo fread($file, $chunkSize);
                flush();
            }

            fclose($file);
        };

        return response()->stream($stream, $responseStatus, $headers);
    }
    // public function streamFile(Upload $upload)
    // {
    //     // Check if the file exists
    //     if (!Storage::exists($upload->path)) {
    //         abort(404, 'File not found.');
    //     }

    //     // Stream the file
    //     return new StreamedResponse(function () use ($upload) {
    //         $stream = Storage::readStream($upload->path);
    //         while (!feof($stream)) {
    //             echo fread($stream, 1024 * 8); // Stream in 8KB chunks
    //             flush();
    //         }
    //         fclose($stream);
    //     }, 200, [
    //         'Content-Type' => Storage::mimeType($upload->path),
    //         'Content-Disposition' => 'inline; filename="' . basename($upload->path) . '"',
    //         'Cache-Control' => 'no-store', // Prevent caching
    //     ]);
    // }

    public function destroy(Upload $upload)
    {
        if ($upload->type === "image") {
            mediaDeleteImage($upload->path);
        } else {
            Storage::delete($upload->path);
        }

        $upload->delete();
        Artisan::call('cache:clear');
        session()->flash('success', __('Deleted successfully'));
        return redirect()->route('admin.uploads.index')->with('success', __('Deleted successfully'));
    }

    // public function upload(Request $request)
    // {
    //     $type = array(
    //         "jpg" => "image",
    //         "jpeg" => "image",
    //         "png" => "image",
    //         "svg" => "image",
    //         "webp" => "image",
    //         "gif" => "image",
    //         "mp4" => "video",
    //         "mpg" => "video",
    //         "mpeg" => "video",
    //         "webm" => "video",
    //         "ogg" => "video",
    //         "avi" => "video",
    //         "mov" => "video",
    //         "flv" => "video",
    //         "swf" => "video",
    //         "mkv" => "video",
    //         "wmv" => "video",
    //         "wma" => "audio",
    //         "aac" => "audio",
    //         "wav" => "audio",
    //         "mp3" => "audio",
    //         "zip" => "archive",
    //         "rar" => "archive",
    //         "7z" => "archive",
    //         "doc" => "document",
    //         "txt" => "document",
    //         "docx" => "document",
    //         "pdf" => "document",
    //         "csv" => "document",
    //         "xml" => "document",
    //         "ods" => "document",
    //         "xlr" => "document",
    //         "xls" => "document",
    //         "xlsx" => "document"
    //     );

    //     if ($request->hasFile('aiz_file')) {
    //         $upload = new Upload;
    //         $extension = strtolower($request->file('aiz_file')->getClientOriginalExtension());

    //         if (
    //             isset($type[$extension]) &&
    //             $type[$extension] == 'archive'
    //         ) {
    //             return '{}';
    //         }

    //         if (isset($type[$extension])) {
    //             $upload->file_original_name = null;
    //             $arr = explode('.', $request->file('aiz_file')->getClientOriginalName());
    //             for ($i = 0; $i < count($arr) - 1; $i++) {
    //                 if ($i == 0) {
    //                     $upload->file_original_name .= $arr[$i];
    //                 } else {
    //                     $upload->file_original_name .= "." . $arr[$i];
    //                 }
    //             }

    //             // if ($extension == 'svg') {
    //             //     $sanitizer = new Sanitizer();
    //             //     // Load the dirty svg
    //             //     $dirtySVG = file_get_contents($request->file('aiz_file'));

    //             //     // Pass it to the sanitizer and get it back clean
    //             //     $cleanSVG = $sanitizer->sanitize($dirtySVG);

    //             //     // Load the clean svg
    //             //     file_put_contents($request->file('aiz_file'), $cleanSVG);
    //             // }

    //             $path = $request->file('aiz_file')->store('uploads/all', 'local');
    //             $size = $request->file('aiz_file')->getSize();

    //             // Return MIME type ala mimetype extension
    //             $finfo = finfo_open(FILEINFO_MIME_TYPE);

    //             // Get the MIME type of the file
    //             $file_mime = finfo_file($finfo, base_path('public/') . $path);

    //             if ($type[$extension] == 'image') {
    //                 try {
    //                     $img = Image::make($request->file('aiz_file')->getRealPath())->encode();
    //                     $height = $img->height();
    //                     $width = $img->width();
    //                     if ($width > $height && $width > 1500) {
    //                         $img->resize(1500, null, function ($constraint) {
    //                             $constraint->aspectRatio();
    //                         });
    //                     } elseif ($height > 1500) {
    //                         $img->resize(null, 800, function ($constraint) {
    //                             $constraint->aspectRatio();
    //                         });
    //                     }
    //                     $img->save(base_path('public/') . $path);
    //                     clearstatcache();
    //                     $size = $img->filesize();
    //                 } catch (\Exception $e) {
    //                     //dd($e);
    //                 }
    //             }

    //             if (env('FILESYSTEM_DRIVER') != 'local') {

    //                 Storage::disk(env('FILESYSTEM_DRIVER'))->put(
    //                     $path,
    //                     file_get_contents(base_path('public/') . $path),
    //                     [
    //                         'visibility' => 'public',
    //                         'ContentType' =>  $extension == 'svg' ? 'image/svg+xml' : $file_mime
    //                     ]
    //                 );
    //                 // dd($storage);
    //                 if ($arr[0] != 'updates') {
    //                     unlink(base_path('public/') . $path);
    //                 }
    //             }

    //             $upload->extension = $extension;
    //             $upload->file_name = $path;
    //             $upload->user_id = Auth::user()->id;
    //             $upload->type = $type[$upload->extension];
    //             $upload->file_size = $size;
    //             $upload->save();
    //         }
    //         return '{}';
    //     }
    // }
}
