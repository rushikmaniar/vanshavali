<?php
/**
 * Created by PhpStorm.
 * User: Rushik
 * Date: 12-04-2018
 * Time: 11:47 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    private $len = 50;
    protected $response_array = array(

        'vanshavali_response' => array(

            'code' => null,
            'message' => null,
            'data' => null

        )

    );


    public function __construct()
    {
        parent::__construct();
        $this->load->model('CommonModel');
    }

    /**
     * Login page
     */
    public function index()
    {

        /*if ($this->input->post('LoginFormEmail')) {
            $whr = array("user_email" => $this->input->post('LoginFormEmail'), "user_pass" => md5($this->input->post('LoginFormPassword')), "is_verified" => 1);
            $result = $this->CommonModel->getRecord("user_master", $whr);
            if ($result->num_rows() == 1) {
                //email password are correct
                //set sesson data
                $user_data = $result->result_array();
                $this->session->set_userdata("vanshavali-mobile", $user_data[0]);

                $this->response_array['code'] = 1;
                $this->response_array['message'] = 'Login Successfull';

            } else {
                $this->response_array['code'] = 0;
                $this->response_array['message'] = 'Incorrect Username and Password';
            }
        }
        echo json_encode($this->response_array);*/
    }


    /**
     * Logout functionality
     *
     */
    public function logout()
    {
        $this->session->unset_userdata('vanshavali-mobile');
    }


    /*
     * register new user
     *
     * */
    public function registerUser()
    {

        if ((isset($_POST['user_email'])) && (isset($_POST['user_pass']))) {

            //check if user already exists
            $user_data = $this->CommonModel->getRecord('user_master', array('user_email' => $_POST['user_email']), '*');
            if ($user_data->num_rows() > 0) {
                //user already exits
                $this->response_array['vanshavali_response']['code'] = 409;
                $this->response_array['vanshavali_response']['message'] = 'Error 409 Conflicts . User Already Exists . Try Another username';
            } else {
                //go for registration
                $userinfo = array();
                $userinfo['user_email'] = $this->input->post('user_email');
                $userinfo['user_pass'] = md5($this->input->post('user_pass'));


                //user type as simple user
                $userinfo['user_type_id'] = $this->CommonModel->getRecord('user_type', array('user_type_name' => 'SIMPLE_MEMBER'), 'user_type_id')->result_array()[0]['user_type_id'];
                $userinfo['is_verified'] = 0;

                //random code
                $random_code = null;

                //check if code exists in database
                $temp = 1;
                while ($temp != 0) {
                    $random_code = $this->createRandomCode(7);
                    $temp = $this->CommonModel->getRecord('user_master', array('verification_code' => $random_code))->num_rows();
                }

                $userinfo['verification_code'] = $random_code;

                $userid = $this->CommonModel->save('user_master', $userinfo);



                $to = $userinfo['user_email'];
                $to_name = $userinfo['user_email'];
                $subject = "Vanshavali Services Verfication";
                $body = "Vanshavali Services Register Token : ".$userinfo['verification_code'];

                //send mail
                $this->CommonModel->phpMail($to, $to_name, $subject = 'vanshavali Service', $body = 'Your Verification Code :'.$userinfo['verification_code']);

                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = 'Status 200 OK. User Created Succesfully';
            }
        } else {
            //wrong parameters Error 400 Bad Request
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad Request. Insufficient Parameters';
        }
        echo json_encode($this->response_array);
        exit;
    }

    private function createRandomCode($len = 10)
    {

        $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKMNOPQRSTUVWXYZ0123456789";
        srand((double)microtime() * 1000000);
        $i = 0;
        $pass = '';

        while ($i <= $len) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;

    }

    //TODO: forgot Password

    public function checkexists($update_field = false, $id = false)
    {
        //update field and $id  used while edit in CRUD

        $table = $this->input->post('table');
        $field = $this->input->post('field');
        $value = $this->input->post($field);

        if (isset($id) && $id != '' && isset($update_field) && $update_field != '') {
            $c = $this->CommonModel->getRecord($table, array($field => $value, "$update_field !=" => $id))->num_rows();

        } else {
            $c = $this->CommonModel->getRecord($table, array($field => $value))->num_rows();
        }

        if ($c > 0) {
            $this->response_array['vanshavali_response']['code'] = 200;
            $this->response_array['vanshavali_response']['message'] = false;
        } else {
            $this->response_array['vanshavali_response']['code'] = 200;
            $this->response_array['vanshavali_response']['message'] = true;
        }
        echo json_encode($this->response_array);
        exit();

    }

    public function generateToken()
    {

        $random_code = "";
        $num = -1;
        while ($num != 0) {
            //check if Exists in database
            $random_code = $this->createRandomCode($this->len);
            $num = $this->CommonModel->getRecord('user_master', array('token' => $random_code))->num_rows();
        }

        /* $this->response_array['vanshavali_response']['code']= 200;
         $this->response_array['vanshavali_response']['message']= "random Code Generated";
         $this->response_array['vanshavali_response']['data']['random_code']= $random_code;*/


        return $random_code;

    }

    public function verifyUser(){
        if( (isset($_POST['user_email'])) && (isset($_POST['verification_code']))  ){
            //get user from email
            $user = $this->CommonModel->getRecord('user_master', array('user_email'=>$_POST['user_email'],'verification_code' => $_POST['verification_code']));
        
            if($user->num_rows() == 0){
                //error user not found
                $this->response_array['vanshavali_response']['code'] = 204;
                $this->response_array['vanshavali_response']['message'] = "User Verification Failure.Try Later";
            }
            else{
                $user = $user->row_array();
                //make user verified
                $this->CommonModel->update('user_master',array('is_verified'=>1,'verification_code'=>null),array('user_email'=>$_POST['user_email']));
                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = "User Verified";
            }
            
        }else{
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = "Error 400 . bad Request";
        }
        echo json_encode($this->response_array);
        exit;
    }

    public function isUserValid(){
        if( (isset($_POST['user_email']))  && (isset($_POST['token'])) ){
            //get user from email
            $user = $this->CommonModel->getRecord('user_master', array('user_email'=>$_POST['user_email'],'verification_code' => null,'token'=>$_POST['token'],'token!='=>null));

            if($user->num_rows() == 0){
                //error user not found
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = "User Invlid.Try Login Again";
            }
            else{
                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = "User Is Valid";
            }
        }else{
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = "Error 400 . bad Request";
        }
        echo json_encode($this->response_array);
        exit;
    }
    public function checkUserCredentials(){
        if( (isset($_POST['user_email']))  && (isset($_POST['user_pass'])) ){
            //get user from email
            $user = $this->CommonModel->getRecord('user_master', array('user_email'=>$_POST['user_email'],'user_pass' => md5($_POST['user_pass'])));

            if($user->num_rows() == 0){
                //error user not found
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = "User email or Password Incorrect";
            }
            else if($user->row_array()['verification_code'] != null){
                $this->response_array['vanshavali_response']['code'] = 401;
                $this->response_array['vanshavali_response']['message'] = "User Is Not Verified";
            }else{
                //generate token
                $token = $this->generateToken();
                $this->response_array['vanshavali_response']['data']['token'] = $token;
                $this->response_array['vanshavali_response']['data']['user_id'] = $user->row_array()['user_id'];
                $this->CommonModel->update('user_master',array('token'=>$token),array('user_email'=>$_POST['user_email']));
                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = "200 Ok . User OK";
            }
        }else{
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = "Error 400 . bad Request";
        }
        echo json_encode($this->response_array);
        exit;
    }



}