<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question_text', 'options', 'correct_answer', 'marks'];

    protected $casts = [
        'options' => 'array', 
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
