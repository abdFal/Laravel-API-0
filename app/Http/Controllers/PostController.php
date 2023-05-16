<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsDetailResource;
use App\Http\Resources\NewsResource;
use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'edit', 'delete');
        $this->middleware('pemilik_news')->only('edit', 'delete');
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

    public function store(Request $request )
    {
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required|max:500'
        ]);

        $post=post::create([
            'title' => $request->input('title'),
            'news_content' => $request->input('news_content'),
            'author' => Auth::user()->id,
        ]);

        return new NewsDetailResource($post->loadMissing('writer'));
    }

    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);

        $post = post::findOrFail($id);
        $post->update($request->all());
        
        return new NewsDetailResource($post->loadMissing('writer'));
    }

    public function delete($id)
    {
        $post = post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'udah delete'
        ]);
    }
}
