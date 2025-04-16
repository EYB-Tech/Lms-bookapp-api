<?php

namespace App\Http\Controllers\Apis;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\ApiResponseClass as ResponseClass;

class TagController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tags",
     *      tags={"Front Api Tags"},
     *     summary="get all tags",
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function index()
    {
        $tags = Tag::all();
        return ResponseClass::sendResponse(['tags' => $tags], '', 200);
    }
}
