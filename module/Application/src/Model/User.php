<?php

namespace Application\Model;

use Zend\Crypt\Password\Bcrypt;
use Zend\InputFilter\InputFilter;


class User
{
   public $id;
   public $username;
   public $fullname;
   public $email;
   public $birthday;
   public $gender;
   public $skill;
   public $avatar;
   public $phone;
   public $password;
   public $description;
   protected $inputFilter;



   public function exchangeArray(array $data)
   {
      $bcrypt = new Bcrypt();
      $password = isset($data['password']) ? $bcrypt->create($data['password']) : null;
      $this->email = $data['email'] ?? null;
      $this->username = $data['username'] ?? null;
      $this->fullname = $data['fullname'] ?? null;
      $this->gender = $data['gender'];
      $this->country = $data['skill'];
      $this->avatar = $data['avatar'];
      $this->phone = $data['phone'];
      $this->description = $data['description'];
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

   public function getGender()
   {
      return $this->gender;
   }

   public function getBirthDay()
   {
      return $this->birthday;
   }

   public function getDescription()
   {
      return $this->description;
   }

   public function getSkill()
   {
      return $this->country;
   }

   public function getPhone()
   {
      return $this->phone;
   }

   public function getAvatar()
   {
      return $this->avatar;
   }

   public function getPassword()
   {
      return $this->password;
   }

   public function getInputFilter()
   {
      if (!$this->inputFilter) {
         $inputFilter = new InputFilter();
         $inputFilter->add([
            'name' => 'username',
            'required' => true,
            'validators' => [
               [
                  'name' => 'NotEmpty',
               ],
            ],
         ]);

         $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filter' => [
               ['name' => 'StringToLower'],
               ['name' => 'StringTrim']
            ],
            'validators' => [
               [
                  'name' => 'NotEmpty',
               ],
               [
                  'name' => 'EmailAddress',
                  'options' => [
                     'messages' => [
                        \Zend\Validator\EmailAddress::INVALID_FORMAT => 'email khong dung dinh dang'
                     ]
                  ]
               ],
            ],
         ]);

         $this->inputFilter = $inputFilter;
      }
      return $this->inputFilter;
   }
}
