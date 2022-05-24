<?php

namespace App\Contracts\Service;

interface UserServiceInterface
{
  public function index();
  
  public function show($id);

  public function update($request, $id);

  public function delete($id);
}
