<?php

namespace App\Http\Controllers;

use App\Models\image;
use App\Models\Post;
use App\Models\Profile;
use App\UploadFileTrait;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use UploadFileTrait;
    public function store(Request $request){
        $validated = $request->validate([
            'image'=>'required|image|mimes:png,jpg',
            'imageable_id'=>'required|integer',
            'imageable_type'=>'required|in:profile,post'
        ]);
        $model = match($validated['imageable_type']){
            'profile'=>Profile::class,
            'post'=>Post::class
        };
        $imageable = $model::findOrFail($validated['imageable_id']);
        if($request->hasFile('image')){
            $path = $this->upload($request->file('image'),'my photo','public');
            $validated['image']=$path;
        }
        $image = $imageable->images()->create($validated);
        return response()->json(['message'=>'Image Added successfully','image'=>$image], 201);
    }
}
