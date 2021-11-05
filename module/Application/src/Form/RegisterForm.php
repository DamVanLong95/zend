<?php

namespace Application\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
         //Định nghĩa tên cho form
         parent::__construct('register');
         // Set POST method for this form
         $this->setAttribute('method', 'post');
         $this->setAttribute('class', 'p-4 bg-light');

         $this->addElements();

       
        
    }

    public function setAction($url) {
        $this->setAttribute('action', $url);
        return $this;
    }

    private function addElements()
    {
         // Add "fullname" field
         $this->add([
            'type'  => 'text',
            'name' => 'fullname',
            'attributes' => [
                'id' => 'fullname',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Full name',
            ],
        ]);

        // Add "email" field
        $this->add([
            'type'  => 'email',
            'name' => 'email',
            'attributes' => [
                'id' => 'email',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Email address',
            ],
        ]);

        // Add "username" field
        $this->add([
            'type'  => 'text',
            'name' => 'username',
            'attributes' => [
                'id' => 'username',
                'class' => 'form-control'

            ],
            'options' => [
                'label' => 'Username',
            ],
        ]);

        // Add "body" field
        $this->add([
            'type'  => 'password',
            'name' => 'password',
            'attributes' => [
                'id' => 'password',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);
      

        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'attributes' => [
                'class' => 'btn btn-warning',
                'value' => 'Submit',
            ],
        ]);
    }
}