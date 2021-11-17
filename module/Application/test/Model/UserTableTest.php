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
        $inputData = [
            "username"  => "damvanlong95",
            "email"     => "longdamd@gmail.com",
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
        // $user->exchangeArray($inputData);
        // $inputData['password'] = $user->getPassword();
        $this->tableGateway->insert($inputData)->shouldBeCalled();
        // $this->user->saveAlbum($user);
    }

    public function testCanDeleteAnUserByItsId()
    {
        $this->tableGateway->delete(['id' => 1])->shouldBeCalled();
        $this->userTable->deleteUser(1);
    }

    // public function testSaveAlbumWillUpdateExistingAlbumsIfTheyAlreadyHaveAnId()
    // {
    //     $inputData = [
    //         "id" => 3,
    //         "username"  => "LedZeppelin95Update",~~
    //         "email"     => "longdamdgmail.com",
    //         "fullname" => "redZeppelin",
    //         "password" => "123",
    //         "gender" => 1,
    //         "skill" => 6, //C++
    //         "phone" => '0393184265',
    //         "description" => 'description',
    //         "birthday" => '2021-12-01',
    //         "avatar" => null,
    //     ];
    //     $user = new User();
    //     $user->exchangeArray($inputData);

    //     $resultSet = $this->prophesize(ResultSetInterface::class);
    //     $resultSet->current()->willReturn($user);

    //     $this->tableGateway
    //         ->select(['id' => 3])
    //         ->willReturn($resultSet->reveal());
    //     $this->tableGateway
    //         ->update(
    //             ['id' => 3]
    //         )->shouldBeCalled();

    //     $this->userTable->saveUser($user);
    // }
}
