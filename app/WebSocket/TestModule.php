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
        //这个时候可以根据 url的地址进行传参  ws://127.0.0.1:18308/test?name=朝阳&id=2111
        //如果是加密过后的  那么就是ws://127.0.0.1:18308/test?data=xaxsax2121-xsax
        //否则就要在onMessage 这个逻辑里面增加一个 login的处理方法 用于绑定用户的 名字 ID 对应的fd的结构体，或者
        //超大的数组里面，数据库里面，redis里面
        print_r($request->get());
        //Array
        //(
        //    [name] => 朝阳
        //    [id] => 2111
        //    [encoding] => text
        //)
        Session::current()->push("Opened, welcome!(FD: $fd)");
    }
}
