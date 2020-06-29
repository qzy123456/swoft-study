<?php declare(strict_types=1);
namespace App\Http\Controller;

use Psr\Http\Message\ResponseInterface;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
 use Swoft\Http\Message\Response;
 use App\Model\Entity\User;

/**
 * Class UserController
 *
 * @Controller(prefix="/users")
 * @package App\Http\Controller
 */
class UserController{
    /**
     * Get data list. access uri path: /users
     * @RequestMapping(route="/users", method=RequestMethod::GET)
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public function index(): object
    {
//        $user = User::new();
//
//        $user->setName('Swoft');
//        $user->save();
//// 保存之后获取 ID
//        $userId = $user->getId();
        // 当结果不存在时创建
        //$userId = User::firstOrCreate(['name' => 'Swoft']);
        $userId = User::find(2);
        print_r(context()->getData()['user']);
        $name = context()->get('name');
        //$userId =  $user->delete();

       return  context()->getResponse()->withData($name);
    }

    /**
     * Get one by ID. access uri path: /users/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::GET)
     * @return array
     */
    public function get(): void
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://www.baidu.com');

        echo $response->getStatusCode(); # 200
        echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'
    }

    /**
     * Create a new record. access uri path: /users
     * @RequestMapping(route="/users", method=RequestMethod::POST)
     * @return array
     */
    public function post(): array
    {
        return ['id' => 2];
    }

    /**
     * Update one by ID. access uri path: /users/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::PUT)
     * @return array
     */
    public function put(): array
    {
        return ['id' => 1];
    }

    /**
     * Delete one by ID. access uri path: /users/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::DELETE)
     * @return array
     */
    public function del(): array
    {
        return ['id' => 1];
    }
}
