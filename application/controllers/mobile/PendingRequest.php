<?php
/**
 * Created by PhpStorm.
 * User: rushikwin8
 * Date: 004 04-01-2019
 * Time: 09:36 PM
 */

class PendingRequest extends MobileController
{
    public function __construct()
    {
        parent::__construct();
    }
    /*
     * //TODO:makeRequest(),deleteRequest(),UpdateRequest(),viewRequest()
     * */

    /*
     * make request to join family . insert record in pending_request table
     *
     * */
    public function makeRequest()
    {

        if ((isset($_POST['family_tree_name']))) {
            //get user_id and family owner_id
            $userdata = $this->session->userdata('vanshavali-mobile');
            $family_data = $this->CommonModel->getRecord('family_trees', array('family_tree_name' => $_POST['family_tree_name']), '*');
            if ($family_data->num_rows() == 1) {
                $family = $family_data->row_array();
                $orWhere = array(
                    'request_from_user_id' => $userdata['user_id'],
                    'request_to_user_id' => $family['family_tree_ownerid'],
                    'request_for_family_id' => $family['family_tree_id']
                );
                //family found
                //check if request is already exists in database
                $pending_request = $this->CommonModel->getRecord('pending_request', $orWhere);

                //if num_row > 0 request already exists. is_viewed and is_accepted
                if ($pending_request->num_rows() > 0) {
                    //request already made . Error 409 Confilcts
                    $this->response_array['vanshavali_response']['code'] = 409;
                    $this->response_array['vanshavali_response']['message'] = 'Error 409 Conflicts. Request Already Made By User';

                } else {
                    //go for insert pending request
                    $request_data = array(
                        'request_from_user_id' => $userdata['user_id'],
                        'request_to_user_id' => $family['family_tree_ownerid'],
                        'request_for_family_id' => $family['family_tree_id']
                    );
                    $pending_request_id = $this->CommonModel->save('pending_request', $request_data);
                    $this->response_array['vanshavali_response']['code'] = 200;
                    $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok. Request For Joining Family made Succesfull';

                }


            } else {
                //family not found
                $this->response_array['vanshavali_response']['code'] = 204;
                $this->response_array['vanshavali_response']['message'] = 'Error 204. No Familes found in Table';

            }


        } else {
            //error 400 bad reqest . invalid parameters
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 BadRequest. Invalid Parameters Passed';
        }
        echo json_encode($this->response_array);
        exit;
    }

    /*
     * get list of pending request
     * post data :
     *  family_tree_id
     * */
    public function getRequestList()
    {
        if( (isset($_POST['family_tree_id']))){
            $userdata = $this->session->userdata('vanshavali-mobile');

            //check if user is author of familt_tree
            $family_where = array(
                'family_tree_ownerid'=>$userdata['user_id'],
                'family_tree_id'=>$_POST['family_tree_id']
            );
            $check_owner = $this->CommonModel->getRecord('family_trees',$family_where)->num_rows();
            if($check_owner == 1){
                //user is owner of family . show request list
                $where = array(
                    'request_for_family_id'=>$_POST['family_tree_id']
                );
                $pending_request = $this->CommonModel->getRecord('pending_request',$where)->result_array();
                $this->response_array['vanshavali_response']['data'] = $pending_request;
                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok. Pending_request Feteched';

            }else{
                //user is not owner of family
                //error 403 Forbidden.
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden. User Not Authorised To view Family';
            }

        }else{
            //error 400 bad reqest . invalid parameters
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 BadRequest. Invalid Parameters Passed';
        }
        echo json_encode($this->response_array);
        exit;
    }

    /*
     * delete pending request
     * post data :
     *  family_tree_id
     *  pending_request_id
     * */
    public function deleteRequest()
    {
        if( (isset($_POST['family_tree_id'])) && (isset($_POST['request_id']))){
            $userdata = $this->session->userdata('vanshavali-mobile');

            //check if user is author of familt_tree
            $family_where = array(
                'family_tree_ownerid'=>$userdata['user_id'],
                'family_tree_id'=>$_POST['family_tree_id']
            );
            $check_owner = $this->CommonModel->getRecord('family_trees',$family_where)->num_rows();
            if($check_owner == 1){
                //user is owner of family . allow to delte request
                $where = array(
                    'id'=>$_POST['request_id']
                );
                $pending_request = $this->CommonModel->delete('pending_request',$where);
                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok. Pending request Deleted';

            }else{
                //user is not owner of family
                //error 403 Forbidden.
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden. User Not Authorised To Delete Pending Request';
            }

        }else{
            //error 400 bad reqest . invalid parameters
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 BadRequest. Invalid Parameters Passed';
        }
        echo json_encode($this->response_array);
        exit;
    }

    /*
    * make  pending request as viewd by owner of family only
    * post data :
    *  family_tree_id
    *  pending_request_id
    * */
    public function makeRequestViewed()
    {
        if( (isset($_POST['family_tree_id'])) && (isset($_POST['request_id']))){
            $userdata = $this->session->userdata('vanshavali-mobile');

            //check if user is author of familt_tree
            $family_where = array(
                'family_tree_ownerid'=>$userdata['user_id'],
                'family_tree_id'=>$_POST['family_tree_id']
            );
            $check_owner = $this->CommonModel->getRecord('family_trees',$family_where)->num_rows();
            if($check_owner == 1){
                //user is owner of family . allow to delte request
                $where = array(
                    'id'=>$_POST['request_id']
                );
                $pending_request = $this->CommonModel->update('pending_request',array('is_viewed'=>1),$where);
                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok. Pending request Deleted';

            }else{
                //user is not owner of family
                //error 403 Forbidden.
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden. User Not Authorised To Delete Pending Request';
            }

        }else{
            //error 400 bad reqest . invalid parameters
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 BadRequest. Invalid Parameters Passed';
        }
        echo json_encode($this->response_array);
        exit;
    }



}