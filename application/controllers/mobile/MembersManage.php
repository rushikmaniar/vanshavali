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
        $userdata = $this->session->userdata('vanshavali-mobile');

        if( (isset($_POST['family_id']))    ){
            //check if user logged in can_view family
            $family_access_where = array(
                'user_id'=>$userdata['user_id'],
                'family_id'=>$_POST['family_id']
            );
            $family_access = $this->getRecord('family_access_table',$family_access_where)->row_array();
        }else{

        }
    }

}