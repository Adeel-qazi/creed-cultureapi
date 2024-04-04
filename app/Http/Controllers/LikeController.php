<?php

namespace App\Http\Controllers;

use App\Http\Requests\HitLikeRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HitLikeRequest $request)
    {
        if(auth()->check()){
            $user = auth()->user();
                    
                    $validatedData = $request->validated();
                    $like = $user->likes()->create($validatedData);
                
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully hit the like',
                    'data' => $like,
                ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to hit the like.',
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($blogId)
    {
         if(auth()->check()){
                $blog = Blog::findOrFail($blogId);
                $likes = $blog->likes;

                $userLiked = auth()->check() ? $blog->likes->contains('user_id', auth()->id()) : false;
                
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetch all likes',
                    'data' => $likes,
                    'user_liked' => $userLiked,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Authentication required to fetch all likes.',
                ], 401);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
