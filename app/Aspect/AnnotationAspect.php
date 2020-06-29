<?php declare(strict_types=1);
namespace App\Aspect;

use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointBean;
use Swoft\Aop\Annotation\Mapping\Before;
/**
 * Class AnnotationAspect
 *
 * @since 2.0
 * @Aspect()
 * @PointBean(include={"requestBeanTwo"})
 */
class AnnotationAspect
{
    /**
     * @Before()
     */
    public function beforeRun(): void
    {
        vdump(__METHOD__, "this  is AnnotationAspect");
    }
}
