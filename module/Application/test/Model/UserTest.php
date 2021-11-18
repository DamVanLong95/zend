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
            'fullname'  => 'some title',
            'email'  => 'longdv@gmail.com',
            'phone' => '0393184258',
            'gender' => 1,
            'birthday' => 'longdv@gmail.com',
            'avatar' => null,
            'password' => '1234!',
            'skill' => 6,
            'description' => 'description',
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
        $this->assertNull($user->avatar, '"avatar" should default to null');
        $this->assertNull($user->skill, '"skill" should default to null');
        $this->assertNull($user->birthday, '"birthday" should default to null');
        $this->assertNull($user->gender, '"gender" should default to null');
        $this->assertNull($user->phone, '"phone" should default to null');
    }
   
}