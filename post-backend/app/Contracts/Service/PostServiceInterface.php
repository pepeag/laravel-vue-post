<?php

namespace App\Contracts\Service;

interface PostServiceInterface{
  public function index();

  public function store(array $data);

  public function show($id);

  public function update(array $data, $post);

  public function delete($id);

  public function import($request);
}