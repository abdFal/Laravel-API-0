<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('pemilik_comment')->only('edit', 'destroy');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment_content' => 'required'
        ]);

        $request['user_id'] = Auth::user()->id;
        $comment = Comments::create($request->all());

        return new CommentResource($comment);
    }
    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'comment_content' => 'required',
        ]);

        $comment = Comments::findOrFail($id);
        $comment->update($request->all());
        
        return new CommentResource($comment);
    }

    public function destroy($id)
    {
        $comment = Comments::findOrFail($id);
        $comment->delete();

        return response()->json([
            'message' => 'udah delete komennya'
        ]);
    }
}
