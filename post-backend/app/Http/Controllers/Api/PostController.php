<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Import\PostsImport;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsCollection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::when(request('search'), function ($query) {
            $query->where('title', 'like', '%' . request('search') . '%');
            $query->orWhere('description', 'like', '%' . request('search') . '%');
        })->orderBy('id', 'desc')->paginate(3);

        $response = [
            'status' => true,
            'message' => "All posts",
            'data' => (new PostsCollection($data))->response()->getData()
          ];
          return response()->json($response);

        return send_response('All Posts', new PostsCollection($data));
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
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "description" => "required"
        ]);

        if ($validator->fails()) {
            return send_error('Validation Error', $validator->errors(), 422);
        }

        try {
            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return send_response('Post Create Successfully', new PostResource($post));
        } catch (\Exception $e) {
            return send_error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return send_response('Success', PostResource::make($post));
        } else {
            return send_error('Post Data Not Found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return send_error('Validation Error', $validator->errors(), 422);
        }
        try {
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();

            return send_response('Post Update Successfully', new PostResource($post));
        } catch (\Exception $e) {
            return send_error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);
            if ($post) {
                $post->delete();
            }
            return send_response('Post Delete Success', []);
        } catch (\Exception $e) {
            return send_error('Something went wrong', $e->getCode());
        }
    }

    public function import(Request $request)
    {
        Post::truncate();

    if($request->hasFile('file')){
        $data = $request->file('file');
        Excel::import(new PostsImport, $data);
        return response()->json([
            "success" => true,
            "data" =>$data,
            "message" => "post csv import successfully.",
        ]);
    }else{
        return response()->json([
            "message" => "error"

        ]) ;  }


    }
}
