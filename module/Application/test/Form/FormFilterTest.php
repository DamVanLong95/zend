<?php

namespace FormTest\Form;

use PHPUnit\Framework\TestCase;
use Application\Form\RegisterForm;
use Application\Model\User;
use org\bovigo\vfs\content\LargeFileContent;
use org\bovigo\vfs\vfsStream;

class FormFilterTest extends TestCase
{
    private $root;

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

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }

    public function getPasswordData(): array
    {
        return [
            ['1234', false, [
                'stringLengthTooShort' => 'The input is less than 5 characters long',
                'regexNotMatch' => "The input does not match against pattern '/[!@#$%^&]/'"
            ]],
            ['12345', false, ['regexNotMatch' => "The input does not match against pattern '/[!@#$%^&]/'"]],
            ['12345acdgA!@', true, []],
        ];
    }

    /**
     *  @dataProvider getPhoneData
     */
    public function testPhoneNumberValidator($phone, bool $expected, $messgesError)
    {
        $user = new User();
        $filter = $user->getInputFilter();
        $filter->setData(['phone' => $phone]);
        $validator = $filter->get('phone');

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }

    public function getPhoneData()
    {
        return [
            ['0393184264', true, []],
            ['0393', false, ['regexNotMatch' => "The input does not match against pattern '/^0[1-68]([-. ]?[0-9]{2}){4}$/'"]],
            ['039318426442343', false, ['regexNotMatch' => "The input does not match against pattern '/^0[1-68]([-. ]?[0-9]{2}){4}$/'"]],
            ['dsfsd324', false, [
                'notDigits' => 'The input must contain only digits',
                'regexNotMatch' => "The input does not match against pattern '/^0[1-68]([-. ]?[0-9]{2}){4}$/'",
            ]]
        ];
    }

    /**
     *  @dataProvider getBirthDayData
     */
    public function testBirthDayValidator($birthday, bool $expected, $messgesError)
    {
        $user = new User();
        $filter = $user->getInputFilter();
        $filter->setData(['birthday' => $birthday]);
        $validator = $filter->get('birthday');

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }

    public function getBirthDayData()
    {
        return [
            ['10', false, ['dateInvalidDate' => 'The input does not appear to be a valid date']],
            ['10/10/2021', false, ['dateInvalidDate' => 'The input does not appear to be a valid date']],
            ['date', false, ['dateInvalidDate' => 'The input does not appear to be a valid date']],
            ['2021 November', false, ['dateInvalidDate' => 'The input does not appear to be a valid date']],
            ['2021-10-10', true, []],
        ];
    }

    /**
     *  @dataProvider getGenderData
     */
    public function testGenderValidator($gender, bool $expected, $messgesError)
    {
        $user = new User();
        $filter = $user->getInputFilter();
        $filter->setData(['gender' => $gender]);
        $validator = $filter->get('gender');

        $this->assertEquals($expected, $validator->isValid());
        $this->assertEquals($messgesError, $validator->getMessages());
    }

    public function getGenderData()
    {
        return [
            ['1', true, []],
            ['0', true, []],
            ['5', false, ['notBetween' => "The input is not between '0' and '1', inclusively"]],
            ['fsdfs', false, [
                'notDigits' => 'The input must contain only digits',
                'valueNotNumeric' => "The min ('0') and max ('1') values are numeric, but the input is not"
            ]]
        ];
    }
}
