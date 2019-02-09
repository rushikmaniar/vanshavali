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
    protected $response_array = array(

        'vanshavali_response'=>array(

            'code'=>null,
            'message'=>null,
            'data'=>null

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
            //check if user logged in
            if ((isset($_SESSION['vanshavali-mobile']))) {
                //send error . user logged in 
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden . User Session LoggedIn';
                echo json_encode($this->response_array);
                exit;
            } else {
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
                        $random_code = $this->createRandomCode();
                        $temp = $this->CommonModel->getRecord('user_master', array('verification_code' => $random_code))->num_rows();
                    }

                    $userinfo['verification_code'] = $random_code;
                    
                    $userid = $this->CommonModel->save('user_master', $userinfo);

                    //TODO : send mail code in registerUser


                    $this->response_array['vanshavali_response']['code'] = 200;
                    $this->response_array['vanshavali_response']['message'] = 'Status 200 OK. User Created Succesfully';
                }
            }
        } else {
            //wrong parameters Error 400 Bad Request
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad Request. Insufficient Parameters';
        }
        echo json_encode($this->response_array);
        exit;
    }

    private function createRandomCode()
    {

        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime() * 1000000);
        $i = 0;
        $pass = '';

        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;

    }
    //TODO: forgot Password

    public function checkexists($update_field = false,$id = false)
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
            $this->response_array['vanshavali_response']['message']=false;
        } else {
            $this->response_array['vanshavali_response']['code'] = 200;
            $this->response_array['vanshavali_response']['message']=true;
        }
        echo json_encode($this->response_array);
        exit();

    }


}