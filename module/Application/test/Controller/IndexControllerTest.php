<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Application\Model\User;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Application\Model\UserTable;
use Zend\ServiceManager\ServiceManager;
use Prophecy\Argument;

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
    }

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

    public function testIndexActionViewModelTemplateRenderedWithinLayout()
    {
        $this->dispatch('/', 'GET');
        $this->assertQuery('.container .jumbotron');
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

    public function testRegisterActionRedirectsAfterValidPost()
    {
        $this->userTable
            ->saveUser(Argument::type(User::class))
            ->shouldBeCalled();

        $postData = [
            'username'  => 'Led Zeppelin III',
            'fullname' => 'Led Zeppelin',
            'email'     => 1223,
            'password' => '123',
        ];
        $this->dispatch('/application/register', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/application/index');
    }
}
