<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsDetailResource;
use App\Http\Resources\NewsResource;
use App\Models\post;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
    }

    public function store(Request $request )
    {
        $validated = $request->validate([
            'title' => 'required',
            'news_content' => 'required|max:500',
            
        ]);

        if($request->file){
            $validated = $request->validate([
                'file' => 'mimes:png,jpg,jpeg|max:100000'
            ]);

            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('images', $request->file, $fileName. '.'. $extension);

            $request['image'] = $fileName . '.'. $extension;
            $request['author'] = Auth::user()->id;
            $post = post::create($request->all());
        }

        
        $request['author'] = Auth::user()->id;
        $post = post::create($request->all());

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
