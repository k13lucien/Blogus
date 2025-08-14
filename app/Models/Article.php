<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    /**
     * Un commentaire appartient à un auteur unique
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un article peut compter plusieurs commentaires
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
