<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

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

        // Add "password" field
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

        // Add "sex" field
        $this->add([
            'type' => 'radio',
            'name' => 'gender',
            'options' => array(
                'label' => 'What is your gender ?',
                'value_options' => array(
                    '0' => 'Female',
                    '1' => 'Male',
                ),
                'label_attributes' => array(
                    'class' => 'gender-label',
                ),
            ),
        ]);

        // Add "birthday" field
        $this->add([
            'type' => 'date',
            'name' => 'birthday',
            'options' => array(
                'label' => 'Birthday '
            ),
            'attributes' => array(
                'min' => '2012-01-01',
                'max' => '2020-01-01',
                'step' => '1', // days; default step interval is 1 day
            )
        ]);

        $this->add([
            'name' => 'phone',
            'type' => 'number',
            'options' => array(
                'label' => 'Phone '
            ),
            'attributes' => [
                'id' => 'phone',
                'class' => 'form-control'
            ],
        ]);
       
        $this->add([
            'name' => 'country',
            'type' => 'text',
            'options' => array(
                'label' => 'Country '
            ),
            'attributes' => [
                'id' => 'phone',
                'class' => 'form-control'
            ],
        ]);
        $this->add([
            'name' => 'avatar',
            'type' => 'file',
            'options' => array(
                'label' => 'Avatar'
            ),
            'attributes' => [
                'id' => 'city',
                'class' => 'form-control'
            ],
        ]);
        $element = new Element\Textarea('description');
        $element->setLabel('Enter a description');
        $this->add($element);

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
