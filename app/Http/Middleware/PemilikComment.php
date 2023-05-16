<?php

namespace App\Http\Middleware;

use App\Models\Comments;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $commentator_id = Comments::findOrFail($request->id);
        $user = Auth::user();
        if($commentator_id->user_id !== $user->id){
            return response()->json([
                "message" => "Data gak sama"
            ]);
        }
        return $next($request);
    }
}
