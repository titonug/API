<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Http\Request;

class EloquentPostRepository implements PostRepository
{

    public function getPosts()
    {
        $post = Post::select('id','title','body')->paginate(10);
        return $post;
    }

    public function getPostsById($id)
    {
       return Post::select('id','title','body')->whereId($id)->first();
    }

    public function createPost(Request $request)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return $post;
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::whereId($id)->first();
        if ($post != null) {
            $post->update([
                $post->title => $request->title,
                $post->body => $request->body,
            ]);
            return $post;
        }
        return null;
    }
    
    public function delete($id)
    {
        $post = Post::whereId($id)->first();
        if ($post != null){
            $post->delete();
            return $post;
        }
        return null;
    }


    public function setAsFinish($id)
    {
        $post = Post::whereId($id)->first();
        if ($post != null){
            $post->status = true;
            $post->save();
            return $post;
        }
        return null;
    }

}

































// public function getPostWithComments($id){
//     return Post::select('title','body','description')
//         ->whereId($id)
//         ->with('comments')->first();
// }
