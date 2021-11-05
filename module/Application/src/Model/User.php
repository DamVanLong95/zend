<?php  

namespace Application\Model;  

class User { 
   protected $id; 
   protected $username; 
   protected $fullname; 
   protected $email;
   protected $password;

   public function exchangeArray(array $data)
   {

       $this->email = $data['email'];
       $this->username= $data['username'];
       $this->fullname= $data['fullname'];   
       $this->id= $data['id'];   
       $this->password= $data['password'];   

   }
   public function getArrayCopy()
   {
       return [
               'email' => $this->email, 
               'username' => $this->username,
               'fullname' => $this->fullname,
               'password' => $this->password,
               'id' => $this->id 
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