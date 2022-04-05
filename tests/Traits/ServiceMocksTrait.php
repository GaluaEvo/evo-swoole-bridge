<?php

namespace Insidestyles\SwooleBridge\Tests\Traits;

use Insidestyles\SwooleBridge\Adapter\Kernel\Psr15SymfonyKernel;
use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Zend\Expressive\Application as ZendApp;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpFoundation\Request as SfRequest;
use Symfony\Component\HttpFoundation\Response as SfResponse;

/**
 * Class ServiceMocksTrait helps to mock the common objects.
 * @package Insidestyles\SwooleBridge\Tests\Traits
 */
trait ServiceMocksTrait
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mock($className)
    {
        return self::getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockPsrLogger()
    {
        return $this->mock(LoggerInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSymfonyKernel()
    {
        return $this->mock(Kernel::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockPsr15SymfonyKernel()
    {
        return $this->mock(Psr15SymfonyKernel::class);
    }


    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockZendApp()
    {
        return $this->mock(ZendApp::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSwooleResponseEmitterInterface()
    {
        return $this->mock(SwooleResponseEmitterInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockRequestBuilderFactory()
    {
        return $this->mock(RequestBuilderFactory::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockDiactorosFactory()
    {
        return $this->mock(DiactorosFactory::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockPsrResponse()
    {
        return $this->mock(PsrResponse::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockPsrServerRequest()
    {
        return $this->mock(ServerRequestInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSwooleRequest()
    {
        return $this->mock(SwooleRequest::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSwooleResponse()
    {
        return $this->mock(SwooleResponse::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSfRequest()
    {
        return $this->mock(SfRequest::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSfResponse()
    {
        return $this->mock(SfResponse::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockHttpKernelInterface()
    {
        return $this->mock(HttpKernelInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockIlluminateKernelInterface()
    {
        return $this->mock(\Illuminate\Contracts\Http\Kernel::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockHttpFoundationFactoryInterface()
    {
        return $this->mock(HttpFoundationFactoryInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockHttpMessageFactoryInterface()
    {
        return $this->mock(HttpMessageFactoryInterface::class);
    }
}