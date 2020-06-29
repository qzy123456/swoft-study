<?php declare(strict_types=1);

namespace App\Http\Controller;
use Swoft;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * Class CookieController
 *
 * @since 2.0
 *
 * @Controller(prefix="cookie")
 */
class CookieController
{
    /**
     * @RequestMapping("set")
     *
     * @return Response
     */
    public function set(): Response
    {
        /** @var Response $resp */
        $resp = context()->getResponse();
        Swoft::trigger('event name', 'target', 1, 2);


        return $resp->setCookie('c-name', 'c-value')->withData(['hello']);
    }

    /**
     * @RequestMapping("get")
     *
     * @param Request $request
     *
     * @return array
     */
    public function get(Request $request): array
    {
        return $request->getCookieParams();
    }

    /**
     * @RequestMapping("del")
     *
     * @return Response
     */
    public function del(): Response
    {
        /** @var Response $resp */
        $resp = context()->getResponse();

        return $resp->delCookie('c-name')->withData(['ok']);
    }
}
