<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCommentRequest $request)
    {
        
        if(auth()->check()){
            $user = auth()->user();
                if ($user->role == 'admin') {
                    
                    $validatedData = $request->validated();
                    $comment = $user->comments()->create($validatedData);
                
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully store the comment',
                    'data' => $comment,
                ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'You do not have the permissions to fetch blogs.',
                    ], 403);
                }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to store the comment.',
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
                $comments = $blog->comments;
                
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetch all comments',
                    'data' => $comments,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Authentication required to fetch all comments.',
                ], 401);
            }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($blogId)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
