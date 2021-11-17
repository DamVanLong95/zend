<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Application\Form\RegisterForm;
use Application\Model\User;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Model\UserTable;
use Zend\ServiceManager\ServiceManager;
use Prophecy\Argument;
use Zend\Db\TableGateway\TableGatewayInterface;
use org\bovigo\vfs\content\LargeFileContent;
use org\bovigo\vfs\vfsStream;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
        $this->configureServiceManager($this->getApplicationServiceLocator());
        $this->tableGateway = $this->prophesize(Argument::type(TableGatewayInterface::class));
    }

    /**
     * Configuring the service manager for the tests
     */
    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(UserTable::class, $this->mockUserTable()->reveal());

        $services->setAllowOverride(false);
    }

    protected function updateConfig($config)
    {
        $config['db'] = [];
        return $config;
    }

    protected function mockUserTable()
    {
        $this->userTable = $this->prophesize(UserTable::class);
        return $this->userTable;
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->userTable->fetchAll()->willReturn([]);
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

    /**
     * Test action with post
     */
    public function testAddActionRedirectsAfterValidPost()
    {
        // check param instane
        $this->userTable
            ->saveUser(Argument::type(User::class))
            ->shouldBeCalled();

        $postData = [
            'fullname'  => 'Nguyen van A',
            'username' => 'NguyenA123',
            'email'     => 'longdv@gmail.com',
            'password' => '12454!',
            'phone' => '0393184274',
            'gender' => 1,
            'description' => "fds",
            'avatar' => "fsdf",
            'birthday' => '2011-01-11',
            'skill' => 1,
        ];
        $this->dispatch('/application/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/application/index');

    }

    public function testSaveUserWillInsertNewUsersIfTheyDontAlreadyHaveAnId()
    {
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

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($user);
        var_dump( $this->userTable->saveUser($user));die;

        $this->assertSame($resultSet,  $this->userTable->saveUser($user));
       ;
    }
}
