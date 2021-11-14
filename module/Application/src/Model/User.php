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
   public $created_at;
   public $updated_at;
   public $deleted_at;

   public $inputFilter;



   public function exchangeArray(array $data)
   {
      $bcrypt = new Bcrypt();
      $password = isset($data['password']) ? $bcrypt->create($data['password']) : null;
      $this->id = $data['id'];
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
      $this->created_at = $data['created_at'] ?? null;
      $this->updated_at = $data['updated_at'] ?? null;
      $this->deleted_at = $data['deleted_at'] ?? null;
   }


   // Add the following method:
   public function getArrayCopy()
   {
      return [
         'id'     => $this->id,
         'fullname' => $this->fullname,
         'password'  => $this->password,
         'email'  => $this->email,
         'avatar'  => $this->avatar,
         'gender'  => $this->gender,
         'birthday'  => $this->birthday,
         'skill'  => $this->skill,
         'password'  => $this->password,
         'phone'  => $this->phone,
         'username'  => $this->username,
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

   public function getCreatedAt()
   {
      return $this->created_at;
   }

   public function getUpdatedAt()
   {
      return $this->updated_at;
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
                  // 'options' => [
                  //    'messages' => [
                  //       \Zend\Validator\EmailAddress::INVALID_FORMAT => 'email invalid format'
                  //    ]
                  // ]
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

         $inputFilter->add(
            [
               'name' => 'password',
               'filters' => [
                  ['name' => 'StringToLower'],
                  ['name' => 'StringTrim'],
               ],
               'validators' => [
                  [
                     'name' => 'StringLength',
                     'options' => [
                        'max' => 30,
                        'min' => 5
                     ]
                  ],
                  [
                     'name' => 'Regex',
                     'options' => [
                        'pattern' => '[a-zA-Z0-9_-]'
                     ]

                  ],
                  [
                     'name' => 'Regex',
                     'options' => [
                        'pattern' => '[!@#$%^&]'
                     ]
                  ],
               ],

            ]
         );

         $inputFilter->add([
            'name' => 'phone',
            'required' => true,
            'validators' => [
               [
                  'name' => 'Digits',
               ],
            ],
         ]);


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
