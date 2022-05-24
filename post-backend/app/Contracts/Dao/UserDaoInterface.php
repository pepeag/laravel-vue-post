<?php

namespace App\Contracts\Dao;

interface UserDaoInterface
{
  public function index();

  public function show($id);

  public function update($request, $id); 

  public function delete($id);
}
