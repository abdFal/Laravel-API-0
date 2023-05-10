<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsDetailResource;
use App\Http\Resources\NewsResource;
use App\Models\post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        $posts = post::all();
        // return response()->json(['data' => $posts]);
        return NewsResource::collection($posts); // using resource
    }

    public function show($id)
    {
        $news = post::with('writer:id,username')->findOrFail($id);
        return new NewsDetailResource($news);
    }
    public function show2($id)
    {
        $news = post::findOrFail($id);
        return new NewsDetailResource($news);
    }
}
