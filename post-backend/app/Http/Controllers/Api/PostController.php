<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsCollection;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Service\PostServiceInterface;

class PostController extends Controller
{
    private $postService;
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->postService->index();
        $data = (new PostsCollection($data))->response()->getData();
        $response = [
            'status' => true,
            'message' => "All posts",
            'data' => $data
        ];
        return response()->json($response);

        // return send_response('All Posts', new PostsCollection($data));
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
            $post = $this->postService->store($request->all());

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
        $post = $this->postService->show($id);
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

            $post = $this->postService->update($request->all(), $post);

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
            $this->postService->delete($id);
            return send_response('Post Delete Success', []);
        } catch (\Exception $e) {
            return send_error('Something went wrong', $e->getCode());
        }
    }

    public function import(Request $request)
    {
        $data = $this->postService->import($request);
        return response()->json([
            "success" => true,
            "data" => $data,
            "message" => "Post Csv Import Successfully.",
        ]);
    }
}
