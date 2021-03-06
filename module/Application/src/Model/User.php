<?php

namespace Application\Model;

use Zend\Crypt\Password\Bcrypt;
use Zend\InputFilter\InputFilter;
use Zend\Filter\File\Rename;
use Zend\Filter\File\RenameUpload;
use Zend\Validator\File\UploadFile;
use Zend\InputFilter\FileInput;

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
      $this->id     = !empty($data['id']) ? $data['id'] : null;
      $this->email = $data['email'] ?? null;
      $this->username = $data['username'] ?? null;
      $this->fullname = $data['fullname'] ?? null;
      $this->gender = $data['gender'] ?? null;
      $this->skill = $data['skill'] ?? null;
      $this->avatar = $data['avatar'] ?? null;
      $this->phone = $data['phone'] ?? null;
      $this->description = $data['description'] ?? null;
      $this->password = $password;
      $this->birthday = $data['birthday'] ?? null;
      $this->created_at = $data['created_at'] ?? null;
      $this->updated_at = $data['updated_at'] ?? null;
      $this->deleted_at = $data['deleted_at'] ?? null;
     
      if (!empty($data['avatar'])) {
         if (is_array($data['avatar'])) {

            $newFileName = date('Y-m-d-h-i-s') . '-' . $data['avatar']['name'];

            // Rename file upload.
            $filter = new Rename(array(
               "target"    => IMAGE_PATH . $newFileName,
               "overwrite " => true,
            ));

            $filter->filter($data['avatar']);

            $this->avatar = $newFileName;
         } else {
            $this->avatar = $data['avatar'];
         }
      } else {
         $data['avatar'] = null;
      }
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
      $inputFilter = new InputFilter();
      $inputFilter->add([
         'name' => 'username',
         'required' => true,
         'filter' => [
            ['name' => 'StringTrim']
         ],
         'validators' => [
            [
               'name' => 'StringLength',
               'options' => [
                  'encoding' => 'UTF-8',
                  'max' => 15,
                  'min' => 5
               ]
            ],
            [
               'name' => 'Alnum',
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
            'required' => true,
            'filter' => [
               ['name' => 'StringTrim']
            ],
            'validators' => [
               [
                  'name' => 'StringLength',
                  'options' => [
                     'encoding' => 'UTF-8',
                     'max' => 15,
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
                     'max' => 15,
                     'min' => 5
                  ]
               ],
               [
                  "name" => "Regex",
                  "options" => [
                     "pattern" => "/[a-zA-Z0-9_]/"
                  ],
               ],
               [
                  "name" => "Regex",
                  "options" => [
                     "pattern" => "/[!@#$%^&]/"
                  ],
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
            [
               'name' => 'Regex',
               "options" => [
                  'pattern'  => '/^0[1-68]([-. ]?[0-9]{2}){4}$/'
               ],
            ]
         ],
      ]);

      $inputFilter->add([
         'name' => 'birthday',
         'required' => true,
         'validators' => [
            [
               'name' => 'Date',
            ]
         ],
      ]);

      $inputFilter->add([
         'name' => 'gender',
         'required' => true,
         'validators' => [
            [
               'name' => 'Digits',

            ],
            [
               'name' => 'Between',
               'options' => [
                  'min' => 0,
                  'max' => 1,
               ],
            ]
         ],
      ]);
      $inputFilter->add([
         'name' => 'avatar',
         'allow_empty' => true,
         'required' => true,
         'validators' => [
            [
               //Ph???i l?? file ???nh
               'name' => \Zend\Validator\File\IsImage::class,
            ],
            [
               'name' => \Zend\Validator\File\Extension::class,
               'options' => [
                  //Lo???i file ???????c upload
                  'extension' => ['jpg', 'png', 'gif', 'jpeg'],
                  'case' => false //kh??ng ph??n bi???t HOA/th?????ng
               ]
            ],

         ],
      ]);

      $this->inputFilter = $inputFilter;
      return $this->inputFilter;
   }
}
