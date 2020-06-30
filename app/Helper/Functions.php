<?php declare(strict_types=1);
use Swoole\WebSocket\Server;
function user_func(): string
{
    return 'hello';
}

if (!function_exists('wsServer')) {
    /**
     * Get server instance
     *
     * @return \Swoole\Coroutine\Iterator
     */
    function wsServer(): Iterator
    {

      return Server()->getSwooleServer()->connections;

    }
}