<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Game extends Model
{
   protected $fillable = ['provider','name', 'image_url'];

}
