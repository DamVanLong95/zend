<?php

namespace Application\Model;

use Zend\Crypt\Password\Bcrypt;
use Zend\InputFilter\InputFilter;
use Zend\I18n\Validator\PhoneNumber;


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
      print_r($data);die;
      $bcrypt = new Bcrypt();
      $password = isset($data['password']) ? $bcrypt->create($data['password']) : null;
      $this->email = $data['email'] ?? null;
      $this->username = $data['username'] ?? null;
      $this->fullname = $data['fullname'] ?? null;
      $this->gender = $data['gender'];
      $this->skill = $data['skill'];
      $this->avatar = $data['avatar'];
      $this->phone = $data['phone'];
      $this->description = $data['description'];
      $this->password = $password;
      $this->birthday = $data['birthday'];
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
      return $this->skill;
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
            'filter' => [
               ['name' => 'StringTrim']
            ],
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
                  'name' => 'EmailAddress',
                  'options' => [
                     'messages' => [
                        \Zend\Validator\EmailAddress::INVALID_FORMAT => 'email invalid format'
                     ]
                  ]
               ],
            ],
         ]);

         $inputFilter->add(
            [
               'name' => 'fullname',
               'filters' => [
                  [
                     'name' => 'StringToUpper'
                  ],
                  [
                     'name' => 'StringTrim'
                  ]
               ],
               'validators' => [
                  [
                     'name' => 'StringLength',
                     'options' => [
                        'encoding' => 'UTF-8',
                        'max' => 30,
                        'min' => 5
                     ]
                  ],
               ],

            ]
         );

         $phoneValidator = new PhoneNumber;
         $phoneValidator->setCountry('it');
         // $inputFilter->add(
         //    array('name' => 'phone', 'required' => true, 'validators' => array($phoneValidator))
         // );


         $inputFilter->add([
            'name' => 'avatar',
            'validators' => [
               [
                  'name' => \Zend\Validator\File\Extension::class,
                  'options' => [
                     //Loại file được upload
                     'extension' => ['jpg', 'png', 'gif', 'jpeg'],
                     'case' => false //không phân biệt HOA/thường
                  ]
               ],
               [
                  //Phải là file ảnh
                  'name' => \Zend\Validator\File\IsImage::class,
               ],
            ],
         ]);

         $this->inputFilter = $inputFilter;
      }
      return $this->inputFilter;
   }
}
