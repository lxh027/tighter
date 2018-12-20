<?php
/**
 * Created by PhpStorm.
 * User: huining
 * Date: 2018/11/24
 * Time: 17:15
 */
namespace app\index\controller;
use \think\Controller;
use think\Session;
use \think\View;
class Index extends Controller
{
    public function index()
    {
        $view = new View();
        return $view -> fetch('Login');
    }
    public function login(){
        $view = new View();
        return $view -> fetch('Login');
    }
    public function register(){
        $view = new View();
        return $view -> fetch('Register');
    }
    public function makeroom(){
        $view = new View();
        return $view -> fetch('Makeroom');
    }
    public function main(){
        $view = new View();
        return $view -> fetch('Main');
    }
    public function countdown(){
        $view = new View();
        return $view -> fetch('Countdown');
    }
    public function matching(){
        $view = new View();
        return $view -> fetch('matching');
    }
    public function calender(){
        $view = new View();
        return $view -> fetch('calender');
    }
    public function mine(){
        $view = new View();
        return $view -> fetch('mine');
    }
}