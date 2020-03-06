<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcher;

class RegisteredUserEvent extends EventDispatcher
{
  public const NAME = 'user.register';

  /**
   * @var User
   */
  private $registeredUser;

  /**
   * @param User $registeredUser
   */
  public function __construct(User $registeredUser)
  {
    parent::__construct();
    $this->registeredUser = $registeredUser;
  }

  /**
   * @return User
   */
  public function getRegisteredUser(): User
  {
    return $this->registeredUser;
  }
}