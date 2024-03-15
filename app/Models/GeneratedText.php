<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedText extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'user_id']; // Fillable fields

    // Define the relationship with the User model (assuming each generated text belongs to a user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
