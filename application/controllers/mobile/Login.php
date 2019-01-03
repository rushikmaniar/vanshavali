<?php
/**
 * Created by PhpStorm.
 * User: Rushik
 * Date: 12-04-2018
 * Time: 11:47 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
    public $response_array=array();
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

        if($this->input->post('LoginFormEmail'))
        {
            $whr = array("user_email"=>$this->input->post('LoginFormEmail'),"user_pass"=>md5($this->input->post('LoginFormPassword')),"is_verified"=>1);
            $result = $this->CommonModel->getRecord("user_master",$whr);
            if ($result->num_rows() == 1)
            {
                //email password are correct
                //set sesson data
                $user_data = $result->result_array();
                $this->session->set_userdata("vanshavali-mobile",$user_data[0]);

                $this->response_array['code'] = 1;
                $this->response_array['message'] = 'Login Successfull';

            }
            else
            {
                $this->response_array['code'] = 0;
                $this->response_array['message'] = 'Incorrect Username and Password';
            }
        }
        echo json_encode($this->response_array);
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

        $response_array = array('code'=>0,'message'=>'');


        if( (isset($_POST['user_email'])) && (isset($_POST['user_pass']))){
            //check if user email already exists
            if( (isset($_SESSION['vanshavali-mobile'])) ){
                //send error . user logged in 
                $response_array['message'] = "User Logged In .";
                echo json_encode($response_array);
                exit;
            }
            else{
                //check if user already exists
                $user_data = $this->CommonModel->getRecord('user_master',array('user_email'=>$_POST['user_email']) , '*');
                if($user_data->num_rows() > 0){
                    //user already exits
                    $response_array['message'] = "User Already Exists.";
                }
                else{
                    //go for registration
                    $userinfo = array();
                    $userinfo['user_email'] = $this->input->post('user_email');
                    $userinfo['user_email'] = md5($this->input->post('user_email'));


                    //user type as simple user
                    $userinfo['user_type_id'] = $this->CommonModel->getRecord('user_type',array('user_type_name'=>'SIMPLE_MEMBER') , 'user_type_id')->result_array()[0]['user_type_id'];

                }
            }
        }
    }


}