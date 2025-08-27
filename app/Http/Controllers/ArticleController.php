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
        $article = Article::with('user')->latest()->get();

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
            'content' => ['required', 'string', 'max:1000']
        ]);

        $article = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $request->user()->id
        ]);

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
        $article = Article::with('user', 'comments')->findOrFail($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article non trouvé',
            ]);
        }

        return response()->json($article);
    }

    /**
     * PUT /api/article/{id}
     * Update the specified article in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
        ]);

        if ($request->user()->id !== $article->user_id) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à modifier cet article',
            ], 403);
        }

        $article->update($data);

        return response()->json([
            'message' => 'Article mis à jour',
            'article' => $article
        ], 201);
    }

    /**
     * DELETE /api/article/{id}
     * Remove the specified article from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        $articleName = $article->title;

        if ($request->user()->id !== $article->user_id)
        {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à supprimer cet article',
            ], 403);
        }

        $article->delete();

        return response()->json([
            'message' => 'L\'article ' .$articleName. ' à été supprimé',
        ]);
    }
}
