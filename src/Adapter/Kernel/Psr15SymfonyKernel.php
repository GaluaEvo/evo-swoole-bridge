<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 20.06.18
 * Time: 10:06
 */

namespace Insidestyles\SwooleBridge\Adapter\Kernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

/**
 * Class Psr15SymfonyKernel
 * @package Insidestyles\SwooleBridge\Adapter
 */
class Psr15SymfonyKernel implements RequestHandlerInterface
{
    /**
     * @var HttpKernelInterface
     */
    private $httpKernel;

    /**
     * @var HttpMessageFactoryInterface
     */
    private $httpMessageFactory;

    /**
     * @var HttpFoundationFactoryInterface
     */
    private $httpFoundationFactory;

    /**
     * Psr15SymfonyKernel constructor.
     * @param HttpKernelInterface $httpKernel
     * @param HttpFoundationFactoryInterface|null $httpFoundationFactory
     * @param HttpMessageFactoryInterface|null $httpMessageFactory
     */
    public function __construct(
        HttpKernelInterface $httpKernel,
        HttpFoundationFactoryInterface $httpFoundationFactory = null,
        HttpMessageFactoryInterface $httpMessageFactory = null
    ) {
        $this->httpKernel = $httpKernel;
        $this->httpFoundationFactory = $httpFoundationFactory ?: new HttpFoundationFactory();
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $this->httpMessageFactory = $httpMessageFactory ?: $psrHttpFactory;
    }

    /**
     * Handle the request and return a response.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $symfonyRequest = $this->httpFoundationFactory->createRequest($request);
        $symfonyResponse = $this->httpKernel->handle($symfonyRequest);

        return $this->httpMessageFactory->createResponse($symfonyResponse);
    }

}