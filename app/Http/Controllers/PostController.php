<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $posts = Post::paginate(10);
            return PostResource::collection($posts);
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $post = new Post();
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            if ($post->save()) {
                return new PostResource($post);
            }
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return new PostResource($post);
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->body = $request->body;
            if ($post->save()) {
                return new PostResource($post);
            }
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            if ($post->delete()) {
                return new PostResource($post);
            }
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }
}
