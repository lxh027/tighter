<?php
/**
 * Created by PhpStorm.
 * User: huining
 * Date: 2018/11/24
 * Time: 19:12
 */
namespace app\index\Controller;
use \think\Controller;
class Logout extends Controller
{
    public function logout()
    {
        $_SESSION=0;
        $this ->success('已退出','#');
    }
}