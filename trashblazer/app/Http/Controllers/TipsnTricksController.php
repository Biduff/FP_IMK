<?php

namespace App\Http\Controllers;

use App\Models\TipsnTricks;
use Illuminate\Http\Request;

class TipsnTricksController extends Controller
{
    public function index()
    {
        $tipsntricks = TipsnTricks::all();
        return view('tipsntricks', compact('tipsntricks'));
    }

    public function show($id)
    {
        $tipntrick = TipsnTricks::findOrFail($id);
        return view('detail', compact('tipntrick'));
    }
}