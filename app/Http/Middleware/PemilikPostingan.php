<?php

namespace App\Http\Middleware;

use App\Models\post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PemilikPostingan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_author = post::findOrFail($request->id);
        $user = Auth::user();

        if($id_author->author != $user->id){
            return response()->json([
                "message" => "kamu bukan pemilik news"
            ]);
        }
        return $next($request);
    }
}
