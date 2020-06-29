<?php declare(strict_types=1);

namespace App\Console\Command;

use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use Swoft\Console\Exception\ConsoleErrorException;
use Swoft\Console\Helper\Show;
use Swoft\Console\Input\Input;

/**
 * Class DemoCommand
 *
 * @Command(name="demo",coroutine=false)
 */
class DemoCommand
{
    /**
     * @CommandMapping(name="test")
     * @param Input $input
     */
    public function test(Input $input): void
    {
        //php bin/swoft demo:test john male  43    --opt1 value1            -y
        //                        参数1 参数2  参数3 options 参数opt1->value1 -y 不传就是true（bool），传了就是参数
        //{
        //    "args": [
        //        "john", //按顺序
        //        "male",
        //        "43"
        //    ],
        //    "opts": {
        //        "y": true,  //-y后面不传就是 "y"：true ，传参数 就是 "y"：xxxx
        //        "opt1": "value1"
        //    }
        //}
        Show::prettyJSON([
            'args' => $input->getArgs(),
            'opts' => $input->getOptions(),
        ]);
    }

    /**
     * @CommandMapping("err")
     * @throws ConsoleErrorException
     */
    public function coError(): void
    {
        ConsoleErrorException::throw('this is an error message');
    }
}
