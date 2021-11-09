<?php

namespace Application\Model;
use Zend\Crypt\Password\Bcrypt;

class User
{
   public $id;
   public $username;
   public $fullname;
   public $email;
   public $password;

   public function exchangeArray(array $data)
   {
      $bcrypt = new Bcrypt();

      $password = isset($data['password']) ? $bcrypt->create($data['password']) : null;
      $this->email = $data['email'] ?? null;
      $this->username = $data['username'] ?? null;
      $this->fullname = $data['fullname'] ?? null;
      $this->password = $password;
   }
   
   public function getArrayCopy()
   {
      return [
         'email' => $this->email,
         'username' => $this->username,
         'fullname' => $this->fullname,
         'password' => $this->password,
      ];
   }

   public function getId()
   {
      return $this->id;
   }

   public function getFullName()
   {
      return $this->fullname;
   }

   public function getEmail()
   {
      return $this->email;
   }

   public function getUserName()
   {
      return $this->username;
   }

   public function getPassword()
   {
      return $this->password;
   }
}
