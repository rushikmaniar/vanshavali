<?php
/**
 * Created by PhpStorm.
 * User: rushikwin8
 * Date: 004 04-01-2019
 * Time: 08:31 PM
 */

class FamilyAccess extends MobileController
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * viewFamilyAccess for particula family and user
     * */
    public function viewFamilyAccess()
    {
        $userdata = $this->session->userdata('vanshavali-mobile');
        //check post data
        if ((isset($_POST['family_id'])) && (isset($_POST['user_id'])) ) {
            //check if user is authorised
            $is_owner = $this->CommonModel->getRecord('family_trees', array('family_tree_id' => $_POST['family_id'], 'family_tree_ownerid' => $userdata['user_id']))->num_rows();
            if ($is_owner == 1) {
                //user is authorised . continue to update
                $family_id = $_POST['family_id'];
                $user_id = $_POST['user_id'];
                $bool_data = $_POST['data'];

                $family_acces_data = array(
                    'user_id'=>$_POST['user_id'],
                    'family_id'=>$family_id,
                    'can_view'=>$bool_data['can_view'],
                    'can_insert'=>$bool_data['can_insert'],
                    'can_update'=>$bool_data['can_update'],
                    'can_delete'=>$bool_data['can_delete']
                );

                $where = array(
                    'user_id' => $user_id,
                    'family_id' => $family_id
                );

                $access_update = $this->CommonModel->update('family_access_table', $family_acces_data, $where);

                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok. Family Acccess Updated Succcessfuly';


            } else {
                //User Is Not Authorised . Error 403
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden . User Not Authorised';
            }


        } else {
            //Invalid data . Error 400 Bad Request
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad request. Invalid Parameters';
        }
    }


    /*
     * insert in family_access is in pending_request accepted request
     * delete of family_access is done when user is removed
     * */

    /*
     * update family_access_table
     * POST : user_id,family_id
     * can_view , can_insert , can_update , can_delete valuue must be zero Or One
     * data - array(
     *          can_view = 0 or 1
     *          can_insert = 0 or 1
     *          can_upadate = 0 or 1
     *          can_delete = 0 or 1
     * )
     * */
    public function updateFamilyAccess()
    {
        $userdata = $this->session->userdata('vanshavali-mobile');
        //check post data
        if ((isset($_POST['family_id'])) && (isset($_POST['user_id'])) && (isset($_POST['data']))) {
            //check if user is authorised
            $is_owner = $this->CommonModel->getRecord('family_trees', array('family_tree_id' => $_POST['family_id'], 'family_tree_ownerid' => $userdata['user_id']))->num_rows();
            if ($is_owner == 1) {
                //user is authorised . continue to update
                $family_id = $_POST['family_id'];
                $user_id = $_POST['user_id'];
                $bool_data = $_POST['data'];

                $family_acces_data = array(
                    'user_id'=>$_POST['user_id'],
                    'family_id'=>$family_id,
                    'can_view'=>$bool_data['can_view'],
                    'can_insert'=>$bool_data['can_insert'],
                    'can_update'=>$bool_data['can_update'],
                    'can_delete'=>$bool_data['can_delete']
                );

                $where = array(
                    'user_id' => $user_id,
                    'family_id' => $family_id
                );

                $access_update = $this->CommonModel->update('family_access_table', $family_acces_data, $where);

                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok. Family Acccess Updated Succcessfuly';


            } else {
                //User Is Not Authorised . Error 403
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden . User Not Authorised';
            }


        } else {
            //Invalid data . Error 400 Bad Request
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad request. Invalid Parameters';
        }

    }
}