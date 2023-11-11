<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_Model extends CI_Model {

 function __construct() {
        parent::__construct();
    }
    public function getUserForLogin($credential){			
        return $this->db->get_where('users', $credential);
        }
        public function getdata(){
        $query =$this->db->get('users');
        $result=$query->result();
        return $result;
        }
        //**exists employee email check**//
        public function Does_email_exists($email) {
            $user = $this->db->dbprefix('users');
            $sql = "SELECT `email` FROM $user
            WHERE `email`='$email'";
            $result=$this->db->query($sql);
            if ($result->row()) {
                return $result->row();
            } else {
                return false;
            }
        }
        public function insertUser($data){
            $this->db->insert('users',$data);
        }
        public function UpdateKey($data,$email){
            $this->db->where('email',$email);
            $this->db->update('users',$data);
        }
        public function UpdatePassword($key,$data){
            $this->db->where('forgotten_code',$key);
            $this->db->update('users',$data);	    
        }	
        public function UpdateStatus($verifycode,$data){
            $this->db->where('confirm_code',$verifycode);
            $this->db->update('users',$data);	    
        }
        //**exists employee email check**//
        public function Does_Key_exists($reset_key) {
            $user = $this->db->dbprefix('users');
            $sql = "SELECT `forgotten_code` FROM $user
            WHERE `forgotten_code`='$reset_key'";
            $result=$this->db->query($sql);
            if ($result->row()) {
                return $result->row();
            } else {
                return false;
            }
        }
        public function GetUserInfo($key){
            $user = $this->db->dbprefix('users');
            $sql = "SELECT `password` FROM $user
            WHERE `forgotten_code`='$key'";
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;			
        }		
        public function GetuserInfoBycode($verifycode){
            $user = $this->db->dbprefix('users');
            $sql = "SELECT * FROM $user
            WHERE `confirm_code`='$verifycode'";
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;			
        }	

    function create_account(){
        extract($_POST);
        $data['firstname'] = $firstname;
        $data['lastname'] = $lastname;
        $data['email'] = $email2;
        $data['password'] = md5($password);
        $data['phone_number'] = $phone_number;
       
        if(!isset($type))
        $data['type'] = 5;
        else
        $data['type'] = $type;

        $insert = $this->db->insert('users',$data);
        if($insert){
            $user_id= $this->db->insert_id();
            $data['user_id'] = $user_id;
            foreach($data as $key => $val){
                if($key != 'password')
                $this->session->set_userdata($key,$val);
            }

            $resp['status'] = 'success';
            $resp['type']=$data['type'];
            return json_encode($resp);
        }

    }
    function login(){
        extract($_POST);
        $chk_email = $this->db->get_where('users',array('email'=>$email))->num_rows();
        if($chk_email <= 0 ){
            $resp['status'] = 'email_unknown';
        }else{
            $qry = $this->db->get_where('users',array('email'=>$email,'password'=>md5($password)));
            if($qry->num_rows() <= 0){
            $resp['status'] = 'login_failed';
            }else{
                if($qry->row()->status ==2 ){
                 $resp['status'] = 'blocked';
                    
                }else{
                    foreach($qry->row() as $key => $val){
                    if($key != 'password'){
                        $key = $key == 'id' ? 'user_id' : $key;
                        $this->session->set_userdata($key,$val);
                    }
                }

                $resp['status'] = 'success';
                $resp['type'] = $this->session->userdata('type');
                }
                
            }
        }
        return json_encode($resp);
    }

}