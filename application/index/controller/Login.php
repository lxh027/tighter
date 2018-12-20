<?php
/**
 * Created by PhpStorm.
 * User: huining
 * Date: 2018/11/24
 * Time: 16:22
 */
namespace app\index\controller;
use \think\Db;
use \think\Controller;
use think\Session;

class Login extends Controller
{
    public function login()
    {
        //通过post获得账号密码
        $account = input('post.account');
        $password = input('post.password');
        //判断账号密码是否符合
        $result=Db::table('user') -> field(['user','password']) -> where('user',$account) -> select();
        if($result)
        {
            if($result[0]['password'] == $password)
            {
//                $_SESSION['user']=$result[0]['user'];
//                $_SESSION['is_online']=1;
//                echo $_SESSION['user'];
                Session::set("user", $result[0]['user'], 'hackday');
                $this -> redirect('\index\index\main');//登陆成功,#号为主页
            }
            else
            {
                $this -> redirect('\index\index\login');//#为登陆界面
            }
        }
        else
        {
            $this -> redirect('\index\index\register');//账号未注册,#为登陆界面
        }
    }
}