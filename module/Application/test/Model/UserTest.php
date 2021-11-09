<?php
namespace ApplicationTest\Model;

use Application\Model\User;
use PHPUnit\Framework\TestCase;
use Zend\Crypt\Password\Bcrypt;

class UserTest extends TestCase
{

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $user = new User();
        $bcrypt = new Bcrypt();

        $data  = [
            'username' => 'some artist',
            'password'     => 123,
            'fullname'  => 'some title',
            'email'  => 'longdv@gmail.com'
        ];

        $user->exchangeArray($data);

        $this->assertSame(
            $data['username'],
            $user->username,
            '"username" was not set correctly'
        );

        $this->assertTrue($bcrypt->verify($data['password'],$user->password));
       
        $this->assertSame(
            $data['fullname'],
            $user->fullname,
            '"fullname" was not set correctly'
        );

        $this->assertSame(
            $data['email'],
            $user->email,
            '"email" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $user = new User();

        $user->exchangeArray([]);
        $this->assertNull($user->fullname, '"fullname" should default to null');
        $this->assertNull($user->username, '"username" should default to null');
        $this->assertNull($user->password, '"password" should default to null');
        $this->assertNull($user->email, '"email" should default to null');
    }
   
}