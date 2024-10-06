<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'relevance_id', 'content', 'approval_status', 'approval_date', 'creation_date', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function relevance()
    {
        return $this->belongsTo(RelevanceDocument::class, 'relevance_id');
    }
}
