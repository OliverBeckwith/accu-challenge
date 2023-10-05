<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotName extends Model
{
    protected $table = 'bot_names';
    protected $primaryKey = 'category';
    public $incrementing = false;
    protected $fillable = ['category', 'bot_name'];
}
