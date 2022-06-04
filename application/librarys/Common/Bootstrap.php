<?php 
/**
 *
 * @copyright (C), 2013-, King.
 * @name Bootstrap.php
 * @author King
 * @version stable 2.0
 * @Date 2022年5月22日下午2:25:50
 * @Class List class
 * @Function List function_container
 * @History King 2022年5月22日下午2:25:50 2017年3月8日下午4:20:28 0 第一次建立该文件
 */
namespace App\Common;



use Tiny\MVC\Bootstrap\Bootstrap as Base;

/**
* @autowired
* @package namespace
* @since 2022年5月22日下午2:28:29
* @final 2022年5月22日下午2:28:29
*/
class Bootstrap extends Base
{
    public function initPut() 
    {
        echo 'bootstrap';
    }
}
?>