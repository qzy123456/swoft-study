<?php declare(strict_types=1);

namespace App\Aspect;

use App\Model\Logic\RequestBean;
use Swoft\Aop\Annotation\Mapping\After;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\Before;
use Swoft\Aop\Annotation\Mapping\PointBean;
use Swoft\Bean\BF;
use Swoft\Co;
use function vdump;

/**
 * Class RequestBeanAspect
 *
 * @since 2.0
 * @Aspect()
 * @PointBean(include={"requestBean"})
 */
class RequestBeanAspect
{
    /**
     * @Before()
     */
    public function beforeRun(): void
    {
        $id = (string)Co::tid();
        /** @var RequestBean $rb */
        $rb = BF::getRequestBean('requestBean', $id);

        vdump(__METHOD__, $rb->temp);
    }

    /**
     * @After()
     */
    public function afterRun(): void
    {
        $id = (string)Co::tid();
        /** @var RequestBean $rb */
        $rb = BF::getRequestBean('requestBean', $id);

        vdump(__METHOD__, $rb->temp);
    }
}
