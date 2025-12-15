<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function store(Request $request){
    $validated = $request->validate([
        'title'=>'required|string|max:50'
    ]);
    $post = Post::create($validated);
    return response()->json($post, 201);
   }
}
