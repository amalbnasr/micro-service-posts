<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function store(Request $request){

        return Post::create([
            'title'=>$request->input('title'),
            'description'=>$request->input('description'),
        ]);

    }


    public function index(){
        $posts=Post::all();
        foreach($posts as $post){
            $post->comments=Http::get("http://localhost:8001/api/posts/{$post->id}/comments")->json();
        }
        return $posts;
    }


    public function comment(Request $request , $id){

        $post=Post::find($id);
        $comments=$post->comments;
        array_push($comments,['text'=>$request->input('text')]);
        $post->comments=$comments;
        $post->save();

    }



}
