<?php

namespace FormTest\Form;

use PHPUnit\Framework\TestCase;
use Application\Form\RegisterForm;
use Application\Model\User;

class FormFilterTest extends TestCase
{
    public function testUserNameValidator() {
        $user = new User();
        $form = new RegisterForm();
        $form->setData(['username' => 'foobar']);   

        $form->bind($user);
        $form->setInputFilter($user->getInputFilter());
        // $validator = $user->get('username');
        // print_r($validator->isValid());
        // $this->assertTrue($validator->isValid());
        
    }

}
