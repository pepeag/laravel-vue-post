<?php

namespace App\Service;

use App\Import\PostsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Service\PostServiceInterface;

class PostService implements PostServiceInterface
{
  private $postDao;

  public function __construct(PostDaoInterface $postDao)
  {
    $this->postDao = $postDao;
  }
  public function index()
  {
    return $this->postDao->index();
  }

  public function store(array $data)
  {
    return $this->postDao->store($data);
  }

  public function show($id)
  {
    return $this->postDao->show($id);
  }

  public function update(array $data, $post)
  {
    return $this->postDao->update($data, $post);
  }

  public function delete($id)
  {
    return $this->postDao->delete($id);
  }

  public function import($request)
  {
    if ($request->hasFile('file')) {
      $data = $request->file('file');
      Excel::import(new PostsImport, $data);
    }
    
    return $data;
  }
}
