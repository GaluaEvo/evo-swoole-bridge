<?php
/**
 * Created by PhpStorm.
 * User: insidestyles
 * Date: 05.05.18
 * Time: 10:38
 */

namespace Insidestyles\SwooleBridge\Adapter;

use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;

/**
 * Class AbstractAdapter
 * @package Insidestyles\SwooleBridge\Adapter
 */
abstract class AbstractAdapter implements SwooleAdapterInterface
{
    /**
     * @var RequestHandlerInterface
     */
    protected $requestHandler;

    /**
     * @var RequestBuilderFactory
     */
    protected $requestBuilderFactory;

    /**
     * @var SwooleResponseEmitterInterface
     */
    protected $responseEmitter;

    /**
     * AbstractAdapter constructor.
     * @param SwooleResponseEmitterInterface $responseEmitter
     * @param RequestBuilderFactory $requestBuilder
     */
    public function __construct(
        SwooleResponseEmitterInterface $responseEmitter,
        RequestHandlerInterface $requestHandler,
        RequestBuilderFactory $requestBuilder
    ) {
        $this->requestBuilderFactory = $requestBuilder;
        $this->requestHandler = $requestHandler;
        $this->responseEmitter = $responseEmitter;
    }

    /**
     * @inheritdoc
     */
    public function handle(SwooleRequest $swooleRequest, SwooleResponse $swooleResponse): void
    {
        $this->before($swooleRequest);
        $psrServerRequest = $this->requestBuilderFactory->createServerRequest($swooleRequest);
        $psrResponse = $this->requestHandler->handle($psrServerRequest);
        $this->after($psrResponse);
        $this->responseEmitter->toSwoole($psrResponse, $swooleResponse);
    }

    /**
     * @param SwooleRequest $swooleRequest
     */
    protected function before(SwooleRequest $swooleRequest)
    {
        //optional
    }

    /**
     * @param ResponseInterface $response
     */
    protected function after(ResponseInterface $response)
    {
        //optional
    }
}