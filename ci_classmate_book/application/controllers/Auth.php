<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;
include('D:wamp64/www/yibao/third_party/JWT.php');


class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
    }

    public function register()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'id' => $this->input->post('id'),
            'password' => md5($this->input->post('password')),
            'address' => $this->input->post('address'),
            'weichat' => $this->input->post('weichat'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'qq' => $this->input->post('qq'),
            'personality' => $this->input->post('personality')
         );

        //查看数据库中是否有相同ID
        $array  = array('id' => $this->input->post('id'));
        $res = $this->auth_model->search($array);
        $res = $res->num_rows();
        
        if($res > 0)
        {
            $result['state'] = 0;
            $result['reason'] = "该ID已经存在";
            $res = $res[0];
            $result['ower_name'] = "";
            $result['ower_address'] = "";
            $result['ower_phone'] = "";
            $result['ower_weichat'] = "";
            $result['ower_email'] = "";
            $result['ower_qq'] = "";
            $result['ower_personality'] = "";
        }
        else
        {
            $res = $this->auth_model->add($data);
            $result['state'] = 1;
            $result['reason'] = "";
            $result['ower_name'] = "";
            $result['ower_address'] = "";
            $result['ower_phone'] = "";
            $result['ower_weichat'] = "";
            $result['ower_email'] = "";
            $result['ower_qq'] = "";
            $result['ower_personality'] = "";
        }
        echo_json($result);
        
        
    }

    public function login()
    {
        $data = array(
            'id' => $this->input->post('id'),
            'password' => md5($this->input->post('password'))
        );

        //判断是否注册
        $res = $this->auth_model->search($data);
        
        if($res->num_rows() > 0)
        {
            $result['state'] = 1;
            $result['reason'] = "";
            //转换成数组返回
            $res = $res->result_array();
            // print_r($res);
            $res = $res[0];
            $result['ower_name'] = $res['name'];
            $result['ower_address'] = $res['address'];
            $result['ower_phone'] = $res['phone'];
            $result['ower_weichat'] = $res['weichat'];
            $result['ower_email'] = $res['email'];
            $result['ower_qq'] = $res['qq'];
            $result['ower_personality'] = $res['personality'];
        }
        else
        {
            $result['state'] = 0;
            $result['reason'] = "账号不存在或密码错误！";
            $result['state'] = 1;
            $result['reason'] = "";
            $result['ower_name'] = "";
            $result['ower_address'] = "";
            $result['ower_phone'] = "";
            $result['ower_weichat'] = "";
            $result['ower_email'] = "";
            $result['ower_qq'] = "";
            $result['ower_personality'] = "";
        }
        echo_json($result);



    }
}
