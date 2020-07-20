<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Common;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\Connection\Connection;
use Swoft\Db\Contract\DbSelectorInterface;

/**
 * Class DbSelector
 *
 * @since 2.0
 *
 * @Bean()
 */
class DbSelector implements DbSelectorInterface
{
    /**
     * @param Connection $connection
     */
    public function select(Connection $connection): void
    {
        $connection->setPoolName("db1.pool");
        //print_r($connection);
        $selectIndex  =context()->getRequest()->getQueryParams();
        $selectIndex = isset($selectIndex['id']) ? (int)$selectIndex['id']: 0;
        //print_r(context()->getData()['user'] );
        $createDbName = $connection->getDb();
        var_dump('这是craet',$createDbName);

        if ($selectIndex == 1) {
            $selectIndex = '';
        }

        if ($createDbName == 'test') {
            $createDbName = 'test';
        }

        $dbName = sprintf('%s%s', $createDbName, $selectIndex);
        var_dump('这是最后的db',$dbName);
        $connection->db($dbName);
    }
}
