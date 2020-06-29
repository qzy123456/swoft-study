<?php declare(strict_types=1);

namespace App\WebSocket\Test;

use App\WebSocket\Middleware\DemoMiddleware;
use Swoft\Session\Session;
use Swoft\WebSocket\Server\Annotation\Mapping\MessageMapping;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;
use Swoft\WebSocket\Server\Connection;
use Swoft\WebSocket\Server\Message\Message;
use Swoft\WebSocket\Server\Message\Request;
use Swoft\WebSocket\Server\Message\Response;
use function is_numeric;
use function json_encode;
use Swoole\WebSocket\Server;
use const WEBSOCKET_OPCODE_PONG;
use function server;
/**
 * Class TestController
 *
 * @WsController(middlewares={DemoMiddleware::class})
 */
class TestController
{
    /**
     * Message command is: 'test.index'
     * //{     "cmd": "test.index",     "data": "test.index" }
     * @return void
     * @MessageMapping()
     */
    public function index(Message $msg): void
    {

        $data = $msg->getData();
        print_r($data);
        Session::current()->push('hi, this is test.index');
    }

    /**
     * Message command is: 'test.close'
     * //{     "cmd": "test.close",     "data": "test.close" }
     * @param Message $msg
     *
     * @return void
     * @MessageMapping("close")
     */
    public function close(Message $msg): void
    {
        $data = $msg->getData();
        var_dump($data);
        /** @var Connection $conn */
        $conn = Session::current();

        $fd = is_numeric($data) ? (int)$data : $conn->getFd();

        $conn->push("hi, will close conn $fd");

        // disconnect
        $conn->getServer()->disconnect($fd);
    }

    /**
     * Message command is: 'test.req'
     * //{     "cmd": "test.req",     "data": "test.req" }
     * @param Request $req
     *
     * @return void
     * @MessageMapping("req")
     */
    public function injectRequest(Request $req): void
    {
        $fd = $req->getFd();

        Session::current()->push("(your FD: $fd)message data: " . json_encode($req->getMessage()->toArray()));
    }

    /**
     * Message command is: 'test.msg'
     * //{     "cmd": "test.msg",     "data": "test.msg" }
     * @param Message $msg
     *
     * @return void
     * @MessageMapping("msg")
     */
    public function injectMessage(Message $msg): void
    {
        Session::current()->push('message data: ' . json_encode($msg->toArray()));
    }

    /**
     * Message command is: 'echo'
     * //{     "cmd": "hi",     "data": "echo" }
     * @param string $data
     * @MessageMapping(root=true)
     */
    public function echo(string $data): void
    {
        Session::current()->push('(echo)Recv: ' . $data);
    }

    /**
     * Message command is: 'hi'
     * //{     "cmd": "hi",     "data": 1 }
     * @param Request  $req
     * @param Response $res
     * @MessageMapping(root=true)
     */
    public function hi(Request $req, Response $res): void
    {
        $fd  = $req->getFd();
        $ufd = (int)$req->getMessage()->getData();

        if ($ufd < 1) {
            Session::current()->push('data must be an integer');
            return;
        }

        $res->setFd($ufd)->setContent("Hi #{$ufd}, I am #{$fd}");

    }

    /**
     * Message command is: 'bin'
     *
     * @MessageMapping("bin", root=true, opcode=2)
     * @param string $data
     *
     * @return string
     */
    public function binary(string $data): string
    {
        // Session::current()->push('Binary: ' . $data, \WEBSOCKET_OPCODE_BINARY);
        return 'Binary: ' . $data;
    }

    /**
     * Message command is: 'ping'
     *
     * @MessageMapping("ping", root=true)
     */
    public function pong(): void
    {
        Session::current()->push('pong!', WEBSOCKET_OPCODE_PONG);
    }

    /**
     * Message command is: 'test.ar'
     *
     * @MessageMapping("ar")
     * @param string $data
     *
     * @return string
     */
    public function autoReply(string $data): string
    {
        return '(home.ar)Recv: ' . $data;
    }

    /**
     * Message command is: 'test.ar'
     *
     * @MessageMapping("stop-worker")
     */
    public function testDie(): void
    {
        $wid = \server()->getPid('workerId');

        \vdump($wid);

        \server()->stopWorker($wid);
    }

    /**
     * Message command is: 'hiSome'
     * //{     "cmd": "hiSome",     "data": 1 }
     * @param Request  $req
     * @MessageMapping(root=true)
     */
    public function hiSome(Request $req): void
    {
        $fd  = $req->getFd();
        $ufd = (int)$req->getMessage()->getData();

        if ($ufd < 1) {
            Session::current()->push('data must be an integer');
            return;
        }
        //奥～奥～奥利给
        //TODO 这里是获取到所有的链接，用来批量发送，实际应用中  这个肯定是不会这么做的，会自己存储用户信息 [fd,name,id]
        //再进行一个循环，比如房间群发，就包含房间id，给用户发，那么就用name，或者id找到用户的fd，群发就是遍历
        foreach (wsServer() as $connection){
            server()->push($connection,"11111");
        }

    }
}
