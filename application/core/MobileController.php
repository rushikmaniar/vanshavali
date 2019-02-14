<?php
/**
 * Created by PhpStorm.
 * User: Admin2018
 * Date: 002 02-01-2019
 * Time: 12:58 PM
 */

class MobileController extends CI_Controller
{
    /*
     * Response to be send in json
     * */
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

        if((isset($_SESSION['vanshavali-mobile']))){
            //check if user exist in database
            $whr = array("user_email"=>$this->session->userdata('vanshavali-mobile')['user_email'],"is_verified"=>1);
            $result = $this->CommonModel->getRecord("user_master",$whr);
            if($result->num_rows() == 1){
                //continue nothing to do . echo json response is compulsory
            }else{
                $this->session->unset_userdata('vanshavali-mobile');
                $this->response_array['vanshavali_response']['code'] = 401;
                $this->response_array['vanshavali_response']['message'] = 'User Authenticatoin Failed.';
                echo json_encode($this->response_array);
                exit;
            }
        }else{
            //nothing
            $this->response_array['vanshavali_response']['code'] = 401;
            $this->response_array['vanshavali_response']['message'] = 'Session Expired.';
            echo json_encode($this->response_array);
            exit;
        }

        //echo json_encode($this->response_array);
    }

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
            echo "false";
        } else {
            echo "true";
        }
        exit();

    }


}