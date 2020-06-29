<?php declare(strict_types=1);
namespace App\Http\Controller;

use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * Class BeanController
 *
 * @since 2.0
 *
 * @Controller(prefix="resp")
 */
class RespController
{
    /**
     * @RequestMapping()
     *
     * @return array
     */
    public function ary(): array
    {
        return ['ary'];
    }

    /**
     * @RequestMapping()
     *
     * @return string
     */
    public function str(): string
    {
        return 'string';
    }
}
