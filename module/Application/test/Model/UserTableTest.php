<?php

namespace ApplicationTest\Model;

use Application\Model\UserTable;
use Application\Model\User;
use PHPUnit\Framework\TestCase;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

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
        $inputData = [
           "username"  =>"LedZeppelin",
           "email"     =>"longdamdgmail.com",
           "fullname" =>"redZeppelin",
           "password" =>"123",
        ];
        $user = new User();
        $user->exchangeArray($inputData);
        $inputData ['password'] = $user->getPassword();
        $this->tableGateway->insert($inputData)->shouldBeCalled();
        $this->userTable->saveUser($user);
    }
}
