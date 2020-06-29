<?php declare(strict_types=1);
namespace App\Http\Controller;

use App\Model\Entity\User;
use Exception;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Log\Helper\Log;
use Swoft\Redis\Redis;
use Swoft\Stdlib\Helper\JsonHelper;
use Swoft\Timer;
use function random_int;

/**
 * Class TimerController
 *
 * @since 2.0
 *
 * @Controller(prefix="timer")
 */
class TimerController
{
    /**
     * @RequestMapping(name="after")
     *
     * @return array
     * @throws Exception
     */
    public function after(): array
    {
        $timerId = 1;
        Timer::after(3 * 1000, function (int $timerId) {
            $user = new User();

            $user->save();
            $id = $user->getId();

            Redis::set("$id", $user->toArray());
            Log::info('用户ID=' . $id . ' timerId=' . $timerId);
            sgo(function () use ($id) {
                $user = User::find($id)->toArray();
                Log::info(JsonHelper::encode($user));
                Redis::del("$id");
            });
        },$timerId);

        return ['after'];
    }

    /**
     * @RequestMapping()
     *
     * @return array
     * @throws Exception
     */
    public function tick(): array
    {
        $timerId = 1;
        Timer::tick(3 * 1000, function (int $timerId) {
            $user = new User();
            $user->name(random_int(1, 100));

            $user->save();
            $id = $user->getId();

            Redis::set("$id", $user->toArray());
            Log::info('用户ID=' . $id . ' timerId=' . $timerId);
            sgo(function () use ($id) {
                $user = User::find($id)->toArray();
                Log::info(JsonHelper::encode($user));
                Redis::del("$id");
            });
        },$timerId);

        return ['tick'];
    }
}
