<?php

namespace FormTest\Form;

use PHPUnit\Framework\TestCase;
use Application\Form\RegisterForm;
use Application\Model\User;

class FormFilterTest extends TestCase
{

    /**
     * @dataProvider getFullNameData
     */
    public function testFullnameValidator($fullname, bool $expected, $messgesError)
    {
        $user = new User();
        $filter = $user->getInputFilter();
        $filter->setData(['fullname' => $fullname]);
        $validator = $filter->get('fullname');

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }

    public function getFullNameData(): array
    {
        return [
            ['long', false, ['stringLengthTooShort' => "The input is less than 5 characters long"]],
            ['longdv', true, []],
            ['1234', false, ['stringLengthTooShort' => "The input is less than 5 characters long"]],
            ['12345', true, []],
            ['^9bhy&', false, [
                'notAlnum' => 'The input contains characters which are non alphabetic and no digits',
            ]],
            ['123456789012345678901234567890123456789012345678900', false, [
                'stringLengthTooLong' => 'The input is more than 15 characters long'
            ]],
        ];
    }

    /**
     *  @dataProvider getFullNameData
     */
    public function testUserNameValidator($username, bool $expected, $messgesError)
    {
        $user = new User();
        $filter = $user->getInputFilter();
        $filter->setData(['username' => $username]);
        $validator = $filter->get('username');

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }


    /**
     *  @dataProvider getEmailData
     */
    public function testEmailValidator($email, bool $expected, $messgesError)
    {
        $user = new User();
        $filter = $user->getInputFilter();
        $filter->setData(['email' => $email]);
        $validator = $filter->get('email');

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }

    public function getEmailData(): array
    {
        return [
            ['longdv', false, ['emailAddressInvalidFormat' => 'The input is not a valid email address. Use the basic format local-part@hostname']],
            ['longdv@gmail.com', true, []],
            ['longdv95@gmail.com.vn', true, []],
            ['longdv@', false, ['emailAddressInvalidFormat' => 'The input is not a valid email address. Use the basic format local-part@hostname']],
            ['1123@1123', false, [
                'emailAddressInvalidHostname' => "'1123' is not a valid hostname for the email address",
                'hostnameInvalidHostname' => "The input does not match the expected structure for a DNS hostname",
                'hostnameLocalNameNotAllowed' => "The input appears to be a local network name but local network names are not allowed",
            ]],
        ];
    }

    /**
     *  @dataProvider getPasswordData
     */
    public function testPasswordValidator($password, bool $expected, $messgesError): void
    {
        $user = new User();
        $filter = $user->getInputFilter();
        $filter->setData(['password' => $password]);
        $validator = $filter->get('password');
        // var_dump($validator->getMessages());;

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }

    public function getPasswordData(): array
    {
        return [
            ['1234', false, ['stringLengthTooShort' => 'The input is less than 5 characters long',]],
            ['12345', true, []],
            ['12345abc', true, []],
            ['12345acdARF', true, []],
            ['12345acdgA!@', true, []],
        ];
    }
}
