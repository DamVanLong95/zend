<?php

namespace Application\Form;

use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        //Định nghĩa tên cho form
        parent::__construct('register');
        $this->setAttribute('class', 'p-4 bg-light');
        // $this->setAttribute('method', 'POST');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->addElements();
    }

    public function setAction($url)
    {
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
                'class' => 'form-control',
                'placeholder' => 'Nguyễn Văn A'
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
                'class' => 'form-control',
                'placeholder' => 'exam@gmail.com'
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
                'class' => 'form-control',
                'placeholder' => 'username'

            ],
            'options' => [
                'label' => 'Username',
            ],
        ]);

        // Add "password" field
        $this->add([
            'type'  => 'password',
            'name' => 'password',
            'attributes' => [
                'id' => 'password',
                'class' => 'form-control',
                'placeholder' => 'password',
                'min'  => '1945-01-01',
                'max'  => '2020-01-01',
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);

        // Add "birthday" field
        $this->add([
            'type'  => 'date',
            'name' => 'birthday',
            'attributes' => [
                'id' => 'birthday',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Birthday: ',
            ],
        ]);

        // Add "phone" field
        $this->add([
            'type'  => 'tel',
            'name' => 'phone',
            'attributes' => [
                'id' => 'phone',
                'class' => 'form-control',
                'placeholder' => 'Phone',
                'pattern'  => '^0[1-68]([-. ]?[0-9]{2}){4}$'
            ],
            'options' => [
                'label' => 'Phone number',
            ],
        ]);

        // Add "avatar" field
        $this->add([
            'type'  => 'file',
            'name' => 'avatar',
            'attributes' => [
                'id' => 'avatar',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Avatar',
            ],
        ]);

        // Add "gender" field
        $this->add([
            'type'  => 'radio',
            'name' => 'gender',
            'attributes' => [
                'id' => 'gender',
                'style' => 'margin-right:12px'
            ],
            'options' => array(
                'label' => 'What is your gender ?',
                'class' => 'control-label',
                'value_options' => array(
                    '0' => 'Female',
                    '1' => 'Male',
                ),
            ),
        ]);
        // Add "description" field
        $this->add([
            'type' => \Zend\Form\Element\Textarea::class,
            'name' => 'description',
            'attributes' => [
                'id' => 'description',
                'class' => 'form-control',
                'row' => 8,
                'style' => 'resize:none',
                'placeholder' => 'writting here'
            ],
            'options' => [
                'label' => 'Description',
                'label_attributes' => [
                    'class' => 'control-label'
                ]
            ],
        ]);

        // Add "skill" field
        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'skill',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'select'
            ],
            'options' => array(
                'label' => 'Skill ',
                'empty_option' => 'Please choose your skill',
                'value_options' => array(
                    '0' => 'PHP',
                    '1' => 'JAVA',
                    '2' => 'JAVASCRIPT',
                    '3' => 'C++',
                ),
            )
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
