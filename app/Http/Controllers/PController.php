<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Repository\EloquentPostRepository;
use Illuminate\Support\Facades\Log;
use App\Utils\Response;
use Exception;

class PController extends Controller
{
    use Response;
    protected $eloquentPost;

    public function __construct(EloquentPostRepository $eloquentPost)
    {
        $this->eloquentPost = $eloquentPost;
    }

    public function posts()
    {
        try {
            $posts = $this->eloquentPost->getPosts();

            if (!$posts->isEmpty()) {
                Log::channel('mylog')->info('Hit API ' . env('APP_URL') . '?METHOD=GET', ['Result:Success']);
                return $this->responseDataCount($posts);
            }
            return $this->responseDataNotFound('Data yang diminta tidak tersedia');
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

    public function getPostsById($id)
    {
        try {
            $post = $this->eloquentPost->getPostsById($id);
            if (!empty($post)) {
                Log::channel('mylog')->info('Hit API ' . env('APP_URL') . '?METHOD=GET?'. $id, ['Result:Success']);
                return $this->responseData($post);
            }
            return $this->responseDataNotFound('Data yang diminta tidak tersedia');
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation($validator->errors());
        }

        try{
            $post = $this->eloquentPost->createPost($request);
            if (!empty($post)) {
                Log::channel('mylog')->info('Hit API ' . env('APP_URL') . '?METHOD=POST?', ['Result:Success']);
                return $this->responseData($post, "Data berhasil ditambahkan");
            }
            return $this->responseError();
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
        
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseValidation($validator->errors());
        }

        try {
            $post = $this->eloquentPost->updatePost($request, $id);

            if ($post != null) {
                Log::channel('mylog')->info('Hit API ' . env('APP_URL') . '?METHOD=PUT?'. $id, ['Result:Success']);
                return $this->responseData($post, "Data di ubah");
            }
            return $this->responseError('Post tidak ditemukan', 404);
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

    public function delete($id)
    {
        try{
            $post = $this->eloquentPost->delete($id);
            if ($post != null) {
                Log::channel('mylog')->info('Hit API ' . env('APP_URL') . '?METHOD=DELETE?'. $id, ['Result:Success']);
                return $this->responseData($post, "Berhasil dihapus");
            }
            return $this->responseError('Post tidak ditemukan', 404);
        } catch (Exception $exception) {
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }
    }

}


































// public function getPostWithComments($post_id){
//     $post = $this->eloquentPost->getPostWithComments($post_id);
//     if ($task != null){
//         return $this->responseData($post);
//     }
//     return $this->responseError('task tidak ditemukan', 404);
//  }