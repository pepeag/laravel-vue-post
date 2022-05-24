<?php

namespace App\Service;

use App\Contracts\Dao\AuthDaoInterface;
use App\Contracts\Service\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
  private $authDao;

  public function __construct(AuthDaoInterface $authDao)
  {
    $this->authDao = $authDao;
  }

  public function register($request)
  {
    return $this->authDao->register($request);
  }

  public function index()
  {
    return $this->authDao->index();
  }
}