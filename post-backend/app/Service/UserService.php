<?php

namespace App\Service;

use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Service\UserServiceInterface;

class UserService implements UserServiceInterface
{
  private $userDao;

  public function __construct(UserDaoInterface $userDao)
  {
    $this->userDao = $userDao;
  }

  public function index()
  {
    return $this->userDao->index();
  }

  public function show($id)
  {
    return $this->userDao->show($id);
  }

  public function update($request, $id)
  {
    return $this->userDao->update($request, $id);
  }

  public function delete($id)
  {
    return $this->userDao->delete($id);
  }
}
