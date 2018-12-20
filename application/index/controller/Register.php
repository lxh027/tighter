<?php
/**
 * Created by PhpStorm.
 * User: huining
 * Date: 2018/11/24
 * Time: 13:54
 */
namespace app\index\controller;
use \think\Db;
use \think\Controller;
class Register extends Controller
{
    public function register()
    {
        //通过post获得账号密码
        $account = input('post.account');
        $password = input('post.password');
        //判断账号是否被注册
        $result =  Db::table('user') -> where('user' , $account) -> select();
        if($result)
        {
            $this -> redirect('\index\index\register');//账号已被注册,此处#为之前注册界面
        }
        else
        {
            if(strlen($account)>20||strlen($account)<6)
            {
                $this -> redirect('\index\index\register');//#是注册界面
            }
            else if (strlen($password)>20||strlen($password)<6)
            {
                $this -> redirect('\index\index\register');//#是注册界面
            }

            $data = ['user' => $account,'password' => $password];
            $is_success=Db::table('user') -> insert($data);
            if($is_success)
            {
                $this -> redirect('\index\index\login');//注册成功,#为主页
            }
            else
            {
                $this -> redirect('\index\index\register');//注册失败,#为注册界面
            }

        }
    }
}