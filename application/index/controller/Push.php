<?php
namespace app\index\controller;

use GatewayWorker\Lib\Gateway;
use think\Controller;
use think\Session;

class Push extends Controller{

    public function helloAction () {
        $uid = $_GET['uid'];
        Session::set('uid', $uid);
        return $this->fetch();
    }

    public function BindClientId () {

        $client_id = $_POST['client_id'];
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '127.0.0.1:1238';

        $bindUid = Session::get('uid');
        // 假设用户已经登录，用户uid和群组id在session中
        // client_id与uid绑定
        Gateway::bindUid($client_id, $bindUid);
        Gateway::sendToUid($bindUid,'success');
        // 加入某个群组（可调用多次加入多个群组）
        // Gateway::joinGroup($client_id, $group_id);
    }

    public function AjaxSendMessage () {

        $uid = Session::get('uid');
        if($uid==1){
            $to_uid = 2;
        }else{
            $to_uid = 1;
        }
        $message = $_POST['message'];
        $data['msg'] = $message;
        $data['from_uid'] = $to_uid;
        $data['to_uid'] = $to_uid;
        // 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '127.0.0.1:1238';
        GateWay::sendToUid($to_uid, json_encode($data)); //发给对方
//        echo json_encode($data);
//        GateWay::sendToAll($message);
    }
}
