<?php declare(strict_types=1);

namespace App\Aspect;

use App\Common\MyBean;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\Before;
use Swoft\Aop\Annotation\Mapping\PointBean;
use function vdump;

/**
 * Class BeanAspect
 *
 * @since 2.0
 * @Aspect()
 * @PointBean(include={MyBean::class})
 */
class BeanAspect
{
    /**
     * @Before()
     */
    public function before(): void
    {
        vdump(__METHOD__);
    }
}
