<?php
declare(strict_types=1);

namespace Insidestyles\SwooleBridge\Builder;

use Psr\Http\Message\ServerRequestInterface;
use Swoole\Http\Request as SwooleRequest;
use Laminas\Diactoros\ServerRequest;

/**
 * My new comment
 *
 * Class ServerRequestBuilder
 * @package Insidestyles\SwooleBridge\Builder
 */
class ServerRequestBuilder implements RequestBuilderInterface
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @inheritdoc
     */
    public function build(SwooleRequest $swooleRequest)
    {
        $body = (string)$swooleRequest->rawContent();

        if (empty($body)) {
            $body = 'php://input';
        } else {
            $body = fopen('data://text/plain,' . $body,'r');
        }

        $this->request = new ServerRequest(
            $this->buildServerParams($swooleRequest),
            $swooleRequest->files ?? [],
            $swooleRequest->server['request_uri'] ?? null,
            $swooleRequest->server['request_method'] ?? null,
            $body,
            $swooleRequest->header ?? [],
            $swooleRequest->cookie ?? [],
            $swooleRequest->get ?? [],
            $swooleRequest->post ?? null,
            $swooleRequest->server['server_protocol'] ?? '1.1'
        );
    }

    /**
     * @param SwooleRequest $swooleRequest
     * @return mixed
     */
    protected function buildServerParams(SwooleRequest $swooleRequest)
    {
        $server = $swooleRequest->server ?? [];
        $header = $swooleRequest->header ?? [];

        $return['USER'] = get_current_user();

        if (function_exists('posix_getpwuid')) {
            $return['USER'] = posix_getpwuid(posix_geteuid())['name'];
        }

        $return['HTTP_CACHE_CONTROL'] = $header['cache-control'] ?? '';
        $return['HTTP_UPGRADE_INSECURE_REQUESTS'] = $header['upgrade-insecure-requests-control'] ?? '';
        $return['HTTP_CONNECTION'] = $header['connection'] ?? '';
        $return['HTTP_DNT'] = $header['dnt'] ?? '';
        $return['HTTP_ACCEPT_ENCODING'] = $header['accept-encoding'] ?? '';
        $return['HTTP_ACCEPT_LANGUAGE'] = $header['accept-accept-language'] ?? '';
        $return['HTTP_ACCEPT'] = $header['accept'] ?? '';
        $return['HTTP_USER_AGENT'] = $header['user-agent'] ?? '';
        $return['HTTP_HOST'] = $header['user-host'] ?? '';
        $return['SERVER_NAME'] = '_';
        $return['SERVER_PORT'] = $server['server_port'] ?? null;
        $return['SERVER_ADDR'] = $server['server_addr'] ?? '';
        $return['REMOTE_PORT'] = $server['remote_port'] ?? null;
        $return['REMOTE_ADDR'] = $server['remote_addr'] ?? '';
        $return['SERVER_SOFTWARE'] = $server['server_software'] ?? '';
        $return['GATEWAY_INTERFACE'] = $server['server_software'] ?? '';
        $return['REQUEST_SCHEME'] = 'http';
        $return['SERVER_PROTOCOL'] = $server['server_protocol'] ?? null;
        $return['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../../bin');
        $return['DOCUMENT_URI'] = '/';
        $return['REQUEST_URI'] = $server['request_uri'] ?? '';
        $return['SCRIPT_NAME'] = '/swoole-expressive';
        $return['CONTENT_LENGTH'] = $header['content-length'] ?? null;
        $return['CONTENT_TYPE'] = $header['content-type'] ?? null;
        $return['REQUEST_METHOD'] = $server['request_method'] ?? 'GET';
        $return['QUERY_STRING'] = $server['query_string'] ?? '';
        $return['SCRIPT_FILENAME'] = rtrim((string)$return['DOCUMENT_ROOT'], '/') . '/' . ltrim($return['SCRIPT_NAME']);
        $return['PATH_INFO'] = $server['path_info'] ?? '';
        $return['FCGI_ROLE'] = 'RESPONDER';
        $return['PHP_SELF'] = $return['PATH_INFO'];
        $return['REQUEST_TIME_FLOAT'] = $server['request_time_float'] ?? '';
        $return['REQUEST_TIME'] = $server['request_time'] ?? '';

        return $return;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
