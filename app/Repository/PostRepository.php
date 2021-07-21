<?php
namespace App\Repository;

use App\Models\Post;
use Illuminate\Http\Request;

interface PostRepository
{
    public function createPost(Request $request);
    public function getPosts();
    public function getPostsById($id);
    public function updatePost(Request $request, $id);
    public function delete($id);
    public function setAsFinish($id);
    
}
