<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\RegisterForm;
use Application\Model\User;
use Zend\Filter\File\Rename;

class IndexController extends AbstractActionController
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function registerAction()
    {
        $form = new RegisterForm();

        $request = $this->getRequest();
        $params = $this->params();

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

        $newFileName = date('Y-m-d-h-i-s') . '-' . $file['avatar']['name'];

        // Rename file upload.
        $filter = new Rename(array(
            "target"    => IMAGE_PATH . $newFileName,
            "overwrite " => true,
            "randomize" => true,
        ));

        $filter->filter($file['avatar']);

        $data['avatar'] = $newFileName;

        $user = new User;
        $user->exchangeArray($data);

        $this->table->saveUser($user);

        //Thông báo - chuyển hướng sang trang khác
        return $this->redirect()->toRoute('application', [
            'controller' => 'index',
            'action' => 'index'
        ]);
    }
}
