<?php
/**
 * Created by PhpStorm.
 * User: lxh001
 * Date: 2018/11/24
 * Time: 13:15
 */
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Session;
class Match extends Controller{
    public function index(){
        $view = new View();
        return $view -> fetch('Main');
    }
    public function find(){//随机匹配
        $username = Session::get('user', 'hackday');
        $time = input('post.time');
        $statu = db('user') -> where('user',$username) -> select();
        //已匹配
        if ($statu[0]['match'] != 'non_matching') {
            $this->success('Matched');
            //apireturn('ok',0,$statu[0]['match']);
            return ;
        }
        $queue =db('user') -> where('time',$time) -> select();
        $match = '';
        //获取可匹配的人
        foreach ($queue as $line){
            if ($line['user'] != $username&&$line['match']=='non_matching') $match = $line['user'];
        }
        //匹配失败
        if ($match == '') {
            db('user')->where('user', $username)->update(['time' => $time]);
            //apireturn('ok',0,'fail');
            $this->error('None');
            return ;
        }
        //匹配成功
        db('user') -> where('user',$match) -> update(['match' => $username, 'time' => $time]);
        db('user') -> where('user',$username) -> update(['match' => $match]);
        //apireturn('ok',0,$match);
        $this->success('Matched');
        return ;
    }

    public function self(){//单人学习
        $username = Session::get('user', 'hackday');;
        $time = input('post.time');
        $statu = db('user') -> where('user',$username) -> select();
        //已匹配
        if ($statu[0]['match'] != 'non_matching') {
            $this->success('Matched');
            //apireturn('ok',0,'fail');
            return ;
        }
        db('user') -> where('user',$username) -> update(['match' => $username , 'time' => $time]);
        //apireturn('ok',0,'success');
        $this->success('Sueecss');
        return ;
    }

    public function makeroom(){//创建房间
        $username = Session::get('user', 'hackday');;
        $room = input('post.room');
        $time = input('post.time');
        $check = db('user') -> where('room',$room) ->select();
        //判重
        foreach ($check as $line){
            if ($line['match']!='non_matching') {
                $this->error('Room Used');
                //apireturn('ok',0,'used');
                return ;
            }
        }
        $statu = db('user') -> where('user',$username) -> select();
        //已匹配
        if ($statu[0]['match'] != 'non_matching') {
            $this->success('Matched');
            //apireturn('ok',0,$statu[0]['match']);
            return ;
        }
        $queue =db('user') -> where('room',$room) -> select();
        $match = '';
        //获取可匹配的人
        foreach ($queue as $line){
            if ($line['user'] != $username&&$line['match']=='non_matching') $match = $line['user'];
        }
        //匹配失败
        if ($match == '') {
            db('user')->where('user', $username)->update(['time' => $time, 'room' => $room]);
            $this->error('None');
            //apireturn('ok',0,'fail');
            return ;
        }
        //匹配成功
        db('user') -> where('user',$match) -> update([ 'time' => $time , 'match' => $username , 'room' => $room]);
        db('user') -> where('user',$username) -> update(['match' => $match ]);
        $this->success('Matched');
        //apireturn('ok',0,$match);
        return ;
    }

    public function dismiss(){//解散房间
        $username = Session::get('user', 'hackday');;
        $lasttime = input('post.lasttime');
        $user1 = db('user') -> where('user',$username) -> select();
        $match = $user1[0]['match'];
        $time = $user1[0]['time'];
        $user2 = db('user') -> where ('user',$match) -> select();
        if ($time==0) $time=$user2[0]['time'];
        $tottime1=$user1[0]['total_time'];
        $tottime2=$user2[0]['total_time'];
        if ($lasttime<$time){
            //扣除积分
        }
        db('user') -> where('user',$username) -> update(['time' => 0 , 'match' => 'non_matching' , 'room' => '0' , 'total_time' => $tottime1+$lasttime]);
        db('user') -> where('user',$match) -> update(['time' => 0 , 'match' => 'non_matching' , 'room' => '0' , 'total_time' => $tottime2+$lasttime]);
        $this->success('Dismissed');
        //apireturn('ok',0,'dismiss');
        return ;
    }
}
