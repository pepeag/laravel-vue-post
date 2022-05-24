<?php

namespace App\Contracts\Service;

interface AuthServiceInterface
{
  public function register($request);

  public function index();
}
