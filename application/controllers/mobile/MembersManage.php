<?php
/**
 * Created by PhpStorm.
 * User: Admin2018
 * Date: 008 08-01-2019
 * Time: 11:25 AM
 */
/*
 * Class Manages MemeberList table .
 * Manages Maembers of Family .
 * Only Owner Or Admins Of  family can manage memeber
 * */
class MembersManage extends MobileController
{
    public function __construct()
    {
        parent::__construct();
    }
    //TODO:getFamilyMemberList(),addFamilyMember(),updateFamilyMember(),deleteFamilyMemeber()

    /*
     * get List Of Memeber of Family Appropriate To user.
     * post Parameters :
     * family_id
     * */
    public function getFamilyMemberList()
    {
        $userdata = $this->userdata;

        if( (isset($_POST['family_id'])) ){
            //check if user logged in can_view family
            $family_access_where = array(
                'user_id'=>$userdata['user_id'],
                'family_id'=>$_POST['family_id']
            );
            $family_access = $this->CommonModel->getRecord('family_access_table',$family_access_where)->row_array();

            //check id can_view = 1
            if($family_access['can_view'] == 1){
                //user Authorised to view Family
                $member_list_where = array(
                    'member_family_tree_id'=>$_POST['family_id']
                );
                $member_list = $this->CommonModel->getRecord('member_list');

                $this->response_array['vanshavali_response']['data']['member_list'] = $member_list->result_array();
                $this->response_array['vanshavali_response']['data']['no_of_rows'] = $member_list->num_rows();
                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok. Members Records Fetech Succcessfuly';
            }else{
                //else user is not Authorised to view Family . Error 403 Forbidden
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden . User Not Authorised';
            }

        }else{
            //Invalid Paramenter Error 400 Bad Request.
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad request. Invalid Parameters';

        }
        echo json_encode($this->response_array);
        exit;
    }

}