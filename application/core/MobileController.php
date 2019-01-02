<?php
/**
 * Created by PhpStorm.
 * User: Admin2018
 * Date: 002 02-01-2019
 * Time: 12:58 PM
 */

class MobileController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CommonModel');
        $response_array = array();

        if(isset($_SESSION['vanshavali-mobile'])){
            //check if user exist in database
            $whr = array("user_email"=>$this->session->userdata('vanshavali-mobile')['user_email'],"is_verified"=>1);
            $result = $this->CommonModel->getRecord("user_master",$whr);
            if($result->num_rows() == 1){
                //continue
                $response_array['code'] = 1;
                $response_array['message']= 'Login Successfully';
            }else{
                $this->session->unset_userdata('vanshavali-mobile');

                $response_array['code'] = 0;
                $response_array['message'] = 'Username Password Incorrect';
            }
        }else{
            //nothing
            $response_array['code'] = 0;
            $response_array['message']='Session Out';
        }

        echo json_encode($response_array);
    }
}