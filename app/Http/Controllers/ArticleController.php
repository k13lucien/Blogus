<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * GET /api/article
     * Display a listing of the resource.
     */
    public function index()
    {
        $article = Article::latest()->get();

        return response()->json($article);
    }

    /**
     * POST /api/article
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ]);

        $article = Article::create($data);

        return response()->json([
            'message' => 'Article créé',
            'article' => $article
        ], 201);
    }

    /**
     * GET /api/article/{id}
     * Display the specified article.
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article non trouvé',
            ]);
        }

        return response()->json($article);
    }

    /**
     * PUT /api/article
     * Update the specified article in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ]);

        $article->update($data);

        return response()->json([
            'message' => 'Article mise à jour',
            'article' => $article
        ], 201);
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $articleName = $article->title;

        $article->delete();

        return response()->json([
            'message' => 'L\'article ' .$articleName. ' à été supprimé',
        ]);
    }
}
