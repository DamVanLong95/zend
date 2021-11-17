<?php

namespace ApplicationTest\Model;

use Application\Model\UserTable;
use Application\Model\User;
use PHPUnit\Framework\TestCase;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\ServiceManager\ServiceManager;
use Prophecy\Argument;

class UserTableTest extends TestCase
{
    protected function setUp()
    {
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->userTable = new UserTable($this->tableGateway->reveal());
    }

    public function testFetchAllReturnsAllUsers()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select()->willReturn($resultSet);

        $this->assertSame($resultSet, $this->userTable->fetchAll());
    }

    public function testSaveUserWillInsertNewUsersIfTheyDontAlreadyHaveAnId()
    {
        $this->tableGateway = $this->createMock(TableGatewayInterface::class);
        $this->userTable = new UserTable($this->tableGateway);
        $inputData = [
            "username"  => "damvanlong95",
            "email"     => "longdamdgmail.com",
            "fullname" => "dam van Long",
            "password" => "123",
            "gender" => 1,
            "skill" => 6, //C++
            "phone" => '0393184265',
            "description" => 'description',
            "birthday" => '2021-12-01',
            "avatar" => null,
        ];

        $user = new User();
        $user->exchangeArray($inputData);
        $inputData['password'] = $user->getPassword();
        $this->tableGateway->method('insert')->willReturn(true);
        $this->assertEquals(true, $this->userTable->saveUser($user));
    }

    public function testCanDeleteAnUserByItsId()
    {
        $this->tableGateway->delete(['id' => 129])->shouldBeCalled();
        $this->userTable->deleteUser(129);
    }

    public function testSaveUserWillUpdateExistingUsersIfTheyAlreadyHaveAnId()
    {
        $tableGateway = $this->createMock(TableGatewayInterface::class);
        $userTable = new UserTable($tableGateway);
        $inputData = [
            "id" => 5,
            "username"  => "LedZeppelin95Update",
            "email"     => "longdamdgmail.com",
            "fullname" => "redZeppelin",
            "password" => "123",
            "gender" => 1,
            "skill" => 6, //C++
            "phone" => '0393184265',
            "description" => 'description',
            "birthday" => '2021-12-01',
            "avatar" => null,
        ];
        $user = new User();
        $user->exchangeArray($inputData);

        // test object user already have set yet 
        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($user);
        $this->tableGateway
            ->select(['id' => 5])
            ->willReturn($resultSet->reveal());
        $tableGateway->method('update')->willReturn(true);
        $update = $tableGateway
            ->update(
                array_filter($inputData, function ($key) {
                    return in_array($key, ['username', 'email', 'fullname', 'password', 'gender', 'skill', 'phone', 'description', 'birthday', 'avatar']);
                }, ARRAY_FILTER_USE_KEY),
                ['id' => 5]
            );

        $this->assertEquals(true, $update);
    }
}
