<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'image',
    ];


    public function admin() {
        return $this->belongsTo(User::class);
    }
}
