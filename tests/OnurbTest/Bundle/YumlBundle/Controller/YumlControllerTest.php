<?php

namespace OnurbTest\Bundle\YumlBundle\Controller;

use Onurb\Bundle\YumlBundle\Controller\YumlController;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class YumlControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $controllerName = 'Onurb\\Bundle\\YumlBundle\\Controller\\YumlController';

    /**
     * @covers \Onurb\Bundle\YumlBundle\Controller\YumlController
     */
    public function testIndexAction()
    {
        $yumlClient = $this->getMock('Onurb\\Bundle\\YumlBundle\\Yuml\\YumlClientInterface');

        $yumlClient->expects($this->once())
            ->method('makeDslText')
            ->will($this->returnValue('[Simple.Entity|+a;b;c]'));

        $yumlClient->expects($this->once())
            ->method('getGraphUrl')
            ->will($this->returnValue('http://yuml.me/15a98c92.png'));

        $this->container = $this->getMock('Symfony\\Component\\DependencyInjection\\ContainerInterface');

        $this->container->expects($this->once())->method('get')
            ->with($this->matches('onurb.doctrine_yuml.client'))
            ->will($this->returnValue($yumlClient));

        $controller = $this->createController();

        $response = $controller->indexAction();

        //On teste si la r�ponse est bien une redirection.
        $this->assertTrue($response instanceof RedirectResponse);
    }

    protected function createController()
    {
        /**
         * @var \Onurb\Bundle\YumlBundle\Controller\YumlController $controller
         */
        $controller = new $this->controllerName;
        $controller->setContainer($this->container);

        return($controller);
    }
}
