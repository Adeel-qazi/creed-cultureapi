<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role == 'admin') {

                $blogs = Blog::orderBy('id', 'DESC')->get();

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetch All blogs',
                    'data' => $blogs,
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
                'message' => 'Authentication required to fetch blogs.',
            ], 401);
        }
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
    public function store(StoreBlogRequest $request)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role == 'admin') {
                $validatedData = $request->validated();
                if(!empty($request->hasFile('image'))){
                    $image = $request->file('image');
                    $imageName = time().".".$image->getClientOriginalExtension();
                    $image->move(public_path("uploads/blogs/"),$imageName);

                    $validatedData['image'] = "uploads/blogs/". $imageName;
                   }

                $blog = $user->blogs()->create($validatedData);

                return response()->json([
                    'status' => true,
                    'message' => 'Blog created successfully',
                    'data' => $blog,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permissions to create a blog.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to create  create a blog.',
            ], 401);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        try {
            return response()->json(['success' => true, 'message' => 'Successfully fetched the single data', 'data' => $blog], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Failed to fetch the data', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {

        $validatedData = $request->validated();

        if (auth()->check()) {
            $user = auth()->user();

            if ($user && $user->role == 'admin') {

                if(!empty($request->hasFile('image'))){
                    if (!empty($blog->image) && file_exists(public_path('storage/' . $blog->image))) unlink(public_path($blog->image));
                    $image = $request->file('image');
                    $imageName = time().".".$image->getClientOriginalExtension();
                    $image->move(public_path("uploads/blogs/"),$imageName);
                    $validatedData['image'] = "uploads/blogs/". $imageName;
                   }
                $blog->update($validatedData);
                return response()->json([
                    'status' => true,
                    'message' => 'Blog updated successfully',
                    'data' => $blog,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permissions to update blog.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to update blog.',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role == 'admin') {

                $deletedBlog = $blog;

                $blog->delete();
                return response()->json(['success' => true, 'message' => 'Successfully the blog has been deleted ', 'data' => $deletedBlog], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permissions to delete the blog.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to delete the blog.',
            ], 401);
        }
    }
}
