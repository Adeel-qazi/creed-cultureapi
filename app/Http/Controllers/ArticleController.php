<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role == 'admin') {

                $articles = Article::orderBy('id', 'DESC')->get();

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetch All articles',
                    'data' => $articles,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permissions to fetch articles.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to fetch articles.',
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
    public function store(StoreArticleRequest $request)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role == 'admin') {
                $validatedData = $request->validated();
                if(!empty($request->hasFile('image'))){
                    $image = $request->file('image');
                    $imageName = time().".".$image->getClientOriginalExtension();
                    $image->move(public_path("uploads/articles/"),$imageName);
                    $validatedData['image'] = "uploads/articles/" . $imageName;
                   }

                $article = $user->articles()->create($validatedData);

                return response()->json([
                    'status' => true,
                    'message' => 'Article created successfully',
                    'data' => $article,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permissions to create an article.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to create  create an article.',
            ], 401);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        try {
            return response()->json(['success' => true, 'message' => 'Successfully fetched the single data', 'data' => $article], 200);
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
    public function update(UpdateArticleRequest $request, Article $article)
    {

        $validatedData = $request->validated();

        if (auth()->check()) {
            $user = auth()->user();

            if ($user && $user->role == 'admin') {

                if(!empty($request->hasFile('image'))){
                    $image = $request->file('image');
                    $imageName = time().".".$image->getClientOriginalExtension();
                    $image->move(public_path("uploads/blogs/"),$imageName);
                    $validatedData['image'] = "uploads/articles/" . $imageName;;
                   }
                $article->update($validatedData);
                return response()->json([
                    'status' => true,
                    'message' => 'Article updated successfully',
                    'data' => $article,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permissions to update an article.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to update an article.',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role == 'admin') {

                $deletedArticle = $article;

                $article->delete();
                return response()->json(['success' => true, 'message' => 'Successfully the article has been deleted ', 'data' => $deletedArticle], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You do not have the permissions to delete the article.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required to delete the article.',
            ], 401);
        }
    }
}
