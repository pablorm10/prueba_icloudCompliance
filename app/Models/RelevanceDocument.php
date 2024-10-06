<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelevanceDocument extends Model
{
    use HasFactory;

    protected $table = 'relevance_documents';

    public function documents()
    {
        return $this->hasMany(Document::class, 'relevance_id');
    }
}
