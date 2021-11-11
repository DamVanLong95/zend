<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{

    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getUserById($id)
    {
        $id = (int)$id;

        $rowset = $this->tableGateway->select(['id' => $id]);

        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

    public function saveUser(User $user)
    {
        $data = [
            'username' => $user->getUserName(),
            'email' => $user->getEmail(),
            'fullname' => $user->getFullName(),
            'birthday' => $user->getBirthDay(),
            'phone' => $user->getPhone(),
            'description' => $user->getDescription(),
            'gender' => $user->getGender(),
            'avatar' => $user->getAvatar(),
            'skill' => $user->getSkill(),
            'password' => $user->getPassword(),
        ];

        if ($user->getId()) {
            return $this->tableGateway->update($data, [
                'id' => $user->getId()
            ]);
        } else {
           return $this->tableGateway->insert($data);
        }
    }

    public function deleteUser($id)
    {
        return $this->tableGateway->delete(array('id' => (int) $id));
    }
}
