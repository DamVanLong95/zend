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

    public function saveUser(User $user)
    {
        $data = [
            'username' => $user->getUserName(),
            'email' => $user->getEmail(),
            'fullname' => $user->getFullName(),
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
}
