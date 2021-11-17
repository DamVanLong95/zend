<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\RegisterForm;
use Application\Model\User;
class IndexController extends AbstractActionController
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $users  = $this->table->fetchAll();

        return ['users' => $users];
    }

    public function addAction()
    {
        $form = new RegisterForm();

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return ['form' => $form];
        }

        //Xử lý khi POST
        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $data =  $request->getPost()->toArray();
        $file =  $request->getFiles()->toArray();
        $post = array_merge_recursive($data, $file);
        $form->setData($post);

        //Kiểm tra hợp lệ
        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $data = $form->getData();
        $user = new User;
        $user->exchangeArray($data);

        $this->table->saveUser($user);

        //Thông báo - chuyển hướng sang trang khác
        return $this->redirect()->toRoute('application', [
            'controller' => 'index',
            'action' => 'index'
        ]);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (0 === $id) {
            return $this->redirect()->toRoute('application', ['action' => 'add']);
        }

        $user = $this->table->getUserById($id);

        $form = new RegisterForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');

        // Xu ly method GET.
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        if (!$request->isPost()) {
            return $viewData;
        }

        // Xu ly method POST.
        $form->setInputFilter($user->getInputFilter());
        $data =  $request->getPost()->toArray();
        $file =  $request->getFiles()->toArray();
        $post = array_merge_recursive($data, $file);
        $form->setData($post);
       
        if (!$form->isValid()) {
            return $viewData;
        }
      
        $this->table->saveUser($user);

        // Redirect to album list
        return $this->redirect()->toRoute('application', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('application');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteUser($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('application');
        }

        return [
            'id'    => $id,
            'user' => $this->table->getUserById($id),
        ];
    }
}
