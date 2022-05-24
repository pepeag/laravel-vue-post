<?php

namespace App\Contracts\Dao;

interface AuthDaoInterface
{
  public function register($request);

  public function index();
}
