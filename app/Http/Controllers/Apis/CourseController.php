<?php

namespace App\Http\Controllers\Apis;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ApiResponseClass as ResponseClass;

class CourseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/courses",
     *      tags={"Front Api Courses"},
     *     summary="get all courses",
     * @OA\Parameter(
     *         name="select",
     *         in="query",
     *         description="select",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function index(Request $request)
    {
        $courses = Course::query();
        $courses->select($request->query('select', '*'));
        $courses->whereHas('subscriptions', function ($query) {
            $query->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>', now())
                ->where('student_id', auth('api')->id());
        });
        $courses = $courses->get();
        return ResponseClass::sendResponse(['courses' => $courses], '', 200);
    }

    /**
     * @OA\Get(
     *     path="/api/courses/{course_id}",
     *      tags={"Front Api Courses"},
     *     summary="show course execution Unsubscribed students can see this",
     *     @OA\Parameter(
     *         name="course_id",
     *         in="path",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *       @OA\Response(response=200, description="OK"),
     *       @OA\Response(response=404, description="Resource Not Found")
     *    )
     */
    public function show($course_id)
    {
        $course = Course::findOrFail($course_id);
        $subscriptions = $course->subscriptions()->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>', now())
            ->where('student_id', auth('api')->id())->exists();

        if (!$subscriptions) {
            return ResponseClass::sendResponse([], 'Not Found', 404);
        }

        $course->user;
        $lessons = $course->lessons()->with('tags')->where('active', 1)->get();
        return ResponseClass::sendResponse(['course' => $course, 'lessons' => $lessons], '', 200);
    }

    /**
     * @OA\Get(
     *     path="/api/stream/{course_id}/{lesson_id}",
     *      tags={"Front Api Courses"},
     *     summary="show course execution Unsubscribed students can see this",
     *     @OA\Parameter(
     *         name="course_id",
     *         in="path",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="lesson_id",
     *         in="path",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *       @OA\Response(response=200, description="OK"),
     *       @OA\Response(response=404, description="Resource Not Found")
     *    )
     */
    public function stream(Request $request, $course_id, $lesson_id)
    {
        $course = Course::findOrFail($course_id);
        $lesson = Lesson::findOrFail($lesson_id);
        if (
            !$lesson->attached
            && $lesson->course_id === $course->id
        ) {
            return ResponseClass::sendResponse([], 'Not Found', 404);
        }
        $filePath = storage_path('app/' . $lesson->attached->path);
        $allowedMimeTypes = ['application/pdf', 'video/mp4', 'video/webm'];
        if (!in_array(mime_content_type($filePath), $allowedMimeTypes) || !$this->checkStudentAuthoriz($course, $lesson)) {
            return ResponseClass::sendResponse([], 'Unauthorized access', 403);
        }
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

        // Check if at least half of the file has been downloaded
        $downloadedBytes = $end - $start + 1;
        $halfFileSize = $fileSize / 2;

        // if ($downloadedBytes >= $halfFileSize) {
        //     increment_student_view_count($lesson);
        // }

        // Set headers for partial content delivery
        $headers = [
            'Content-Type'        => mime_content_type($filePath),
            'Content-Length'      => $downloadedBytes,
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

    private function checkStudentAuthoriz($course, $lesson)
    {
        $hasSubscription  = $course->subscriptions()->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>', now())
            ->where('student_id', auth('api')->id())->exists();
        if (
            $hasSubscription
            && $lesson->active == 1 && $lesson->course_id === $course->id
        ) {
            return true;
        }
        return false;
    }
}
