<?php declare(strict_types=1);

namespace App\WebSocket\Middleware;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Log\Helper\CLog;
use Swoft\WebSocket\Server\Contract\MessageHandlerInterface;
use Swoft\WebSocket\Server\Contract\MiddlewareInterface;
use Swoft\WebSocket\Server\Contract\RequestInterface;
use Swoft\WebSocket\Server\Contract\ResponseInterface;

/**
 * Class GlobalWsMiddleware
 *
 * @Bean()
 */
class GlobalWsMiddleware implements MiddlewareInterface
{
    /**
     * @param RequestInterface        $request
     * @param MessageHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(RequestInterface $request, MessageHandlerInterface $handler): ResponseInterface
    {
        $start = '>before cxcxzcxzc';

        CLog::info('before handle');

        $resp = $handler->handle($request);

        $resp->setData($start . $resp->getData() . ' after>');

        CLog::info('after handle');

        \server()->log(__METHOD__, [], 'error');

        return $resp;
    }
}