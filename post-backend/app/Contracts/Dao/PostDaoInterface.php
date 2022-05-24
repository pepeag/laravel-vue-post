<?php
namespace App\Contracts\Dao;

interface PostDaoInterface{
  public function index();

  public function store(array $data);

  public function show($id);

  public function update(array $data, $post);

  public function delete($id);
}