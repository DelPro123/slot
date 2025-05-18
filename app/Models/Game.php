<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Game extends Model
{
    public function up()
        {
            Schema::create('games', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('image'); // store image URL or path
                $table->timestamps();
            });
        }
    public function groupItems()
        {
            return $this->hasMany(GameGroupItem::class);
        }

}
