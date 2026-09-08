<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = ['key', 'label', 'title', 'body', 'meta'];

    protected $casts = ['meta' => 'array'];
}
