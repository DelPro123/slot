<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;


class GameController extends Controller
{
    public function index()
    {
        return response()->json(Game::select('name', 'image_url')->get());
    }
}
