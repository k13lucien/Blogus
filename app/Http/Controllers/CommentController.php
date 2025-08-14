<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * GET /api/comment
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = Comment::with('article', 'user')->latest()->get();

        return response()->json($comments);
    }

    /**
     * POST /api/comment
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:255'],
            'article_id' => ['required', 'integer', 'exists:articles,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $comment = Comment::create($data);

        return response()->json([
            'message' => 'Commentaire créé',
            'comment' => $comment,
        ]);
    }

    /**
     * GET /api/comment{id}
     * Display the specified comment.
     */
    public function show(string $id)
    {
        $comment = Comment::with('article', 'user')->findOrFail($id);

        if (!$comment)
        {
            return response()->json([
                'message' => 'Commentaire non trouvé',
            ]);
        }

        return response()->json($comment);
    }


    /**
     * PUT /api/comment
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);

        $data = $request->validate([
            'content' => ['required', 'string', 'max:255'],
            'article_id' => ['required', 'integer', 'exists:articles,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $comment->update($data);

        return response()->json([
            'message' => 'Commentaire mis à jour',
            'comment' => $comment,
        ]);
    }

    /**
     * DELETE /api/comment
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        return response()->json([
            'message' => 'Commentaire supprimé',
        ]);
    }
}
