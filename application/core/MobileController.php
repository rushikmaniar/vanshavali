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
    protected $userdata = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('CommonModel');


        if( (isset($_POST['user_email']))   && (isset($_POST['token'])) ){
            //check if user exist in database
            $val = '
            user_id,
            user_email,
            user_type.user_type_name,
            is_verified,
            token as user_token
            ';
            $whr = array("user_email"=>$_POST['user_email'],"token"=>$_POST['token'],'is_verified'=>1);
            $result = $this->CommonModel
                ->dbjoin(
                    array(
                        array(
                            'table' => 'user_type',
                            'condition' => 'user_master.user_type_id = user_type.user_type_id',
                            'jointype' => 'inner'
                        )
                    ))
                ->getRecord("user_master",$whr,'user_id,user_email,');
            if($result->num_rows() == 1){
                $this->userdata = $result->row_array();
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
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad Request.';
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