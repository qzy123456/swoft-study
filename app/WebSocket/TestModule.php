<?php declare(strict_types=1);


namespace App\WebSocket;

use App\WebSocket\Test\TestController;
use Swoft\Http\Message\Request;
use Swoft\Session\Session;
use Swoft\WebSocket\Server\Annotation\Mapping\OnOpen;
use Swoft\WebSocket\Server\Annotation\Mapping\WsModule;
use Swoft\WebSocket\Server\MessageParser\JsonParser;     //这个就是系统定义的格式， {  "cmd": "test.index",     "data": "test.index" }
use Swoft\WebSocket\Server\MessageParser\RawTextParser;  //这个就是纯字符串，自己解析

/**
 * Class TestModule
 *
 * @WsModule(
 *     "/test",
 *     defaultCommand="test.index",
 *     messageParser=JsonParser::class,
 *     controllers={TestController::class}
 * )
 */
class TestModule
{
    /**
     * @OnOpen()
     * @param Request $request
     * @param int     $fd
     */
    public function onOpen(Request $request, int $fd): void
    {
        Session::current()->push("Opened, welcome!(FD: $fd)");
    }
}
