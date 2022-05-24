<?php

namespace App\Dao;

use App\Models\Post;
use App\Contracts\Dao\PostDaoInterface;

class PostDao implements PostDaoInterface
{
  private $model;

  public function __construct(Post $model)
  {
    $this->model = $model;
  }

  public function index()
  {
    $data = $this->model->when(request('search'), function ($query) {
      $query->where('title', 'like', '%' . request('search') . '%');
      $query->orWhere('description', 'like', '%' . request('search') . '%');
    })->orderBy('id', 'desc')->paginate(3);

    return $data;
  }

  public function store(array $data)
  {
    $post = $this->model->create([
      'title' => $data['title'],
      'description' => $data['description'],
    ]);

    return $post;
  }

  public function show($id)
  {
    return $this->model->find($id);
  }

  public function update(array $data, $post)
  {
    $post->title = $data['title'];
    $post->description = $data['description'];
    $post->save();

    return $post;
  }

  public function delete($id)
  {
    $post =$this->model->find($id);
    if ($post) {
        $post->delete();
    }
    return $post;
  }
}
