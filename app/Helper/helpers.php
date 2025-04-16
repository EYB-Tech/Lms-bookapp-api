<?php

use App\Models\Upload;
use App\Models\Setting;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

if (!function_exists('mediaUploadImage')) {
    function mediaUploadImage($directoryPath, $newImage, $currentImage = null, $ex = '.webp')
    {
        $old_path = public_path($currentImage);
        if (File::exists($old_path)) {
            File::delete($old_path); // Deletes the image file
        }
        // create directory if not exists 
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // Create the directory with write permissions
        }

        $imageName = Str::random(20) . uniqid() . $ex;
        try {
            $image = Image::read($newImage);
        } catch (\Throwable $th) {
            $image = Image::read(@imagecreatefrompng($newImage));
        }
        $image->save(public_path($directoryPath . '/' . $imageName));

        // ->resize(300, 300, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        return $directoryPath . '/' . $imageName;
    }
}

if (!function_exists('mediaDeleteImage')) {
    function mediaDeleteImage($currentImage)
    {
        $old_path = public_path($currentImage);
        if (File::exists($old_path)) {
            File::delete($old_path); // Deletes the image file
        }
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = Upload::where('id', $id)->first()) != null) {
            return $asset->external_link == null ? getImage($asset->path) : $asset->external_link;
        }
        return URL::asset('media/photos/placeholder.jpg');
    }
}


if (!function_exists('getImage')) {
    function getImage($image)
    {
        if (File::exists($image)) {
            return URL::asset($image);
        } else {
            return URL::asset('media/photos/placeholder.jpg');
        }
    }
}

if (!function_exists('getAvatar')) {
    function getAvatar($image)
    {
        if (!$image) {
            return URL::asset('media/avatars/avatar10.jpg');
        }

        if (File::exists($image)) {
            return URL::asset($image);
        } else {
            return $image;
        }
    }
}

if (!function_exists('format_size')) {
    function format_size($sizeInBytes, $formatType = 'auto', $getFormat = true)
    {
        $formatGB = null;
        $formatMB = null;
        if ($getFormat) {
            $formatGB = ' GB';
            $formatMB = ' MB';
        }

        $sizeInMB = $sizeInBytes / (1024 * 1024); // Convert bytes to MB
        if ($formatType == 'auto') {
            if ($sizeInMB >= 1024) {
                return round($sizeInMB / 1024, 2) . $formatGB; // Convert MB to GB if >= 1024
            }
            return round($sizeInMB, 2) . $formatMB;
        }

        if ($formatType == 'GB') {
            return round($sizeInMB / 1024, 2) . $formatGB; // Convert MB to GB if >= 1024
        }

        if ($formatType == 'MB') {
            return round($sizeInMB, 2) . $formatMB;
        }
    }
}
if (!function_exists('all_active_language')) {
    function all_active_language()
    {
        $value = \Illuminate\Support\Facades\Cache::remember('all_active_language', 86400, function () {
            return App\Models\Language::where('status', 'Publish')->get();
        });
        return $value;
    }
}

if (!function_exists('get_lang_dir')) {
    function get_lang_dir()
    {
        $slug = app()->getLocale();
        $value = \Illuminate\Support\Facades\Cache::remember($slug, 86400, function () use ($slug) {
            return App\Models\Language::where('slug', $slug)->first()?->direction ?? "ltr";
        });
        return $value;
    }
}

if (!function_exists('get_lang_system')) {
    function get_lang_system()
    {
        $value = \Illuminate\Support\Facades\Cache::remember('default_lang', 86400, function () {
            return App\Models\Language::where('default', 1)->first();
        });
        return $value;
    }
}
if (!function_exists('default_lang')) {
    function default_lang()
    {
        return app()->getLocale();
    }
}
/**
 * Static Options
 */
if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        // $option_name = $key;
        // $value = \Illuminate\Support\Facades\Cache::remember($option_name, 86400, function () use ($option_name) {
        //     return Setting::where('option_name', $option_name)->first();
        // });

        // return $value->option_value ?? $default;


        $settings = \Illuminate\Support\Facades\Cache::remember('business_settings', 86400, function () {
            return Setting::all();
        });
        $option_name = $key;
        if ($lang == false) {
            $setting = $settings->where('option_name', $option_name)->first();
        } else {
            $setting = $settings->where('option_name', $option_name)->where('lang', $lang)->first();
            $setting = !$setting ? $settings->where('option_name', $option_name)->first() : $setting;
        }
        return ($setting == null || $setting->option_value == '') ? $default : $setting->option_value;
    }
}

if (!function_exists('update_setting')) {
    function update_setting($key, $value, $lang = null)
    {
        if (!Setting::where('option_name', $key)->where('lang', $lang)->first()) {
            Setting::create([
                'option_name' => $key,
                'option_value' => $value,
                'lang' => $lang,
            ]);
            return true;
        } else {
            Setting::where('option_name', $key)->where('lang', $lang)->update([
                // 'option_name' => $key,
                'option_value' => $value,
            ]);
            \Illuminate\Support\Facades\Cache::forget($key);
            return true;
        }
        return false;
    }
}

if (!function_exists('delete_setting')) {
    function delete_setting($key)
    {
        \Illuminate\Support\Facades\Cache::forget($key);
        return (bool) Setting::where('option_name', $key)->delete();
    }
}

/**
 * Env File Setting
 */
if (!function_exists('setEnvValue')) {
    function setEnvValue(array $values)
    {
        $path = base_path('.env');

        if (count($values) > 0 && file_exists($path)) {
            foreach ($values as $key => $val) {
                $fileContent = file_get_contents($path);

                // Escape double quotes in the value
                $val = addslashes(trim($val));

                // Enclose the value in double quotes
                $quotedValue = "\"{$val}\"";

                // Check if the key already exists in the .env file
                if (preg_match("/^{$key}=.*/m", $fileContent)) {
                    // Update existing variable
                    $fileContent = preg_replace(
                        "/^{$key}=.*/m",
                        "{$key}={$quotedValue}",
                        $fileContent
                    );
                } else {
                    // Append new variable
                    $fileContent .= "\r\n{$key}={$quotedValue}";
                }

                // Write updated content back to .env
                file_put_contents($path, $fileContent);
            }
        }
    }
}
if (!function_exists('formatted_duration')) {
    function formatted_duration($duration)
    {
        if ($duration === 0) {
            __('Not specified');
        }
        if ($duration >= 60) {
            $hours = floor($duration / 60);
            $minutes = $duration % 60;
            return $minutes > 0
                ? "{$hours} " . __('hour') . " {$minutes} " . __('min')
                : "{$hours} " . __('hour');
        }

        return "{$duration} " . __('min');
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd M Y - h:i A')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('format_price')) {
    function format_price($price)
    {
        return number_format($price, 2) . ' ' . get_setting('site_currncy');
    }
}
if (!function_exists('system_currncy')) {
    function system_currncy()
    {
        return get_setting('site_currncy');
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check() && Auth::user()->type == 'Admin') {
            return true;
        }
        return false;
    }
}

if (!function_exists('isStudent')) {
    function isStudent()
    {
        if (Auth::check() && Auth::user()->type == 'Student') {
            return true;
        }
        return false;
    }
}

if (!function_exists('minutes_increment_view')) {
    function minutes_increment_view()
    {
        return get_setting('minutes_increment_view', 5);
    }
}

if (!function_exists('increment_student_view_count')) {
    function increment_student_view_count($lesson)
    {
        $student = Auth::user(); // Assuming authenticated user is the student
        $now = now(); // Current timestamp

        // Check if the student has already viewed the lesson
        $lessonStudent = $lesson->students()->where('lesson_student.student_id', $student->id)->first();
        if ($lessonStudent) {
            // Check if the last update was more than one minute ago
            $lastViewTime = $lessonStudent->pivot->updated_at;
            if ($lastViewTime->diffInMinutes($now) >= get_setting('update_lesson_view_time', minutes_increment_view())) {
                // Increment the view count
                $lesson->students()->updateExistingPivot($student->id, [
                    'views' => $lessonStudent->pivot->views + 1,
                    'updated_at' => $now,
                ]);
            }
        } else {
            // Create a new record with a view count of 1
            $lesson->students()->attach($student->id, [
                'views' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}



if (!function_exists('locales')) {
    function locales()
    {
        if (Language::first()) {
            $slugs = Language::pluck('slug')->toArray();
        } else {
            $slugs = ['en', 'ar'];
        }
        return $slugs;
    }
}

if (!function_exists('builder_widgets')) {
    function builder_widgets()
    {
        return ['who-we-are', 'why-choose-us', 'services', 'advertising-banner'];
    }
}
