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
            'id' => $user->getId(),
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
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
        ];
        $dateTime = new \DateTime();
        if ($user->getId()) {
            $data['updated_at'] = $dateTime->format('Y-m-d H:i:s');
            return $this->tableGateway->update($data, [
                'id' => $user->getId()
            ]);
        } else {
            $data['created_at'] = $dateTime->format('Y-m-d H:i:s');
            return $this->tableGateway->insert($data);
        }
    }

    public function deleteUser($id)
    {
        return $this->tableGateway->delete(array('id' => (int) $id));
    }
}
