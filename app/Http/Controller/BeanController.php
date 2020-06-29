<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Common\MyBean;
use App\Model\Logic\RequestBean;
use App\Model\Logic\RequestBeanTwo;
use Swoft\Bean\BeanFactory;
use Swoft\Co;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * Class BeanController
 *
 * @since 2.0
 *
 * @Controller(prefix="bean")
 */
class BeanController
{
    /**
     * @RequestMapping("single")
     *
     * @return array
     */
    public function singleton(): array
    {
        //这里调用了 App/Common/MyBean.php
        $b = BeanFactory::getBean(MyBean::class);
        return [$b->myMethod()];
        //[["hi"]]
    }

    /**
     * @RequestMapping("req")
     *
     * @return array
     */
    public function request(): array
    {
        $id = (string)Co::tid();
        echo $id; // 2
        /** @var RequestBean $request */
        //这里调用 app/Aspect/RequestBeanAspect 这个切面(切面又调用了 app/Model/Logic/requestBean.php)
        //切面内有2个方法 RequestBeanAspect::beforeRun 和 afterRun

        $request = BeanFactory::getRequestBean('requestBean', $id);
        //传参数
        $request->temp = ['rid' => $id];
        //打印出        vdump(__METHOD__, $rb->temp);
        //PRINT ON App\Aspect\RequestBeanAspect(32):
        //string(39) "App\Aspect\RequestBeanAspect::beforeRun"
        //array(1) {
        //  ["rid"]=> string(1) "2"
        //}
        //PRINT ON App\Aspect\RequestBeanAspect(44):
        //string(38) "App\Aspect\RequestBeanAspect::afterRun"
        //array(1) {
        //  ["rid"]=> string(1) "2"
        //}
        return $request->getData(); //["requestBean"]

    }

    /**
     * @return array
     *
     * @RequestMapping("req2")
     */
    public function requestTwo(): array
    {
        $id = (string)Co::tid();

        /* @var RequestBeanTwo $request */
        //这里直接调用 app/Model/Logic/RequestBeanTwo.php
        //TODO 这里 app/Aspect/下面的切面其实是默认全部都会加载到的，只要是切面里面定义用到的地方，
        //TODO 都会用到切面里面的方法
        $request = BeanFactory::getRequestBean(RequestBeanTwo::class, $id);
        return $request->getData();
        //["data"]
    }
}
