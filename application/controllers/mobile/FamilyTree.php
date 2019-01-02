<?php
/**
 * Created by PhpStorm.
 * User: rushikwin8
 * Date: 002 02-01-2019
 * Time: 03:35 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class FamilyTree extends MobileController
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     *  Get list of Family trees Relevant To Looged In User From family_trees_table
     *
     * */
    public function getFamilyTreeList()
    {
        //logged in user data
        $userdata = $this->sesssion->usedata('vanshavali-mobile')[0];

        $val = '
            family_trees.family_tree_id,
            family_trees.family_tree_name,
            family_trees.family_tree_ownerid,
            
            family_access_table.user_id,
            family_access_table.can_view,
            family_access_table.can_insert,
            family_access_table.can_update,
            family_access_table.can_delete
            
        ';
        $OrWhere = array('user_id' => $userdata['user_id']);
        $family_list = $this->CommonModel
            ->dbOrderBy(array('family_trees.family_tree_id' => 'DESC'))
            ->dbjoin(
                array(
                    array(
                        'table' => 'family_access_table',
                        'condition' => 'family_trees.family_tree_id = family_access_table.family_id',
                        'jointype' => 'inner'
                    )
                )
            )->getRecord('family_trees', $OrWhere, $val)->result_array();

        echo json_encode($family_list);
        exit(0);
    }

    /*
     * Creates Family_tree in family_tree table
     * */
    public function createFamilyTree()
    {
        $response_array = array('code' => 0, 'message' => '');
        $userdata = $this->sesssion->usedata('vanshavali-mobile')[0];

        //get post data
        if ((isset($_POST['family_tree_name']))) {
            //check if family with sam name exists
            $tree_list = $this->CommonModel
                ->getRecord('family_trees', array('family_tree_id'), array('family_tree_name' => $_POST['family_tree_name']));

            if ($tree_list->num_rows() > 0) {
                //family with same name already exsts. generate error
                $response_array['code'] = 0;
                $response_array['message'] = 'Family Already Exists . Try Another Name';
            } else {
                $family_details = array();

                //continue to insert new family in family_trees
                $family_details['family_tree_name'] = $this->input->post('family_tree_name');
                $family_details['family_tree_ownerid'] = $userdata['user_id'];
                $family_treee_id = $this->CommonModel->save('family_trees', $family_details);

                //insert in family_access_table
                $family_access = array();

                $family_access['user_id'] = $userdata['user_id'];
                $family_access['family_id'] = $family_treee_id;
                $family_access['can_view'] = 1;
                $family_access['can_insert'] = 1;
                $family_access['can_update'] = 1;
                $family_access['can_delete'] = 1;


                $this->CommonModel->save('family_access_table', $family_access);

                $response_array['code'] = 1;
                $response_array['message'] = 'Family Added Successfully';

            }

        }
        echo json_encode($response_array);
        exit;
    }

    /*
     * Update Family Tree Name
     * */
    public function updateFamilyTree()
    {
        $response_array = array('code' => 0, 'message' => '');
        $userdata = $this->sesssion->usedata('vanshavali-mobile')[0];

        //get post data
        if ((isset($_POST['new_family_tree_name'])) && (isset($_POST['old_family_tree_name']))) {
            //check if family with sam name exists
            $tree_list = $this->CommonModel
                ->getRecord('family_trees', array('family_tree_id'), array('family_tree_name' => $_POST['new_family_tree_name']));

            if ($_POST['new_family_tree_name'] == $_POST['old_family_tree_name']) {
                //same name applied . do nothing
            } else {
                //name changed
                if ($tree_list->num_rows() > 0) {
                    //family with same name already exsts. generate error
                    $response_array['code'] = 0;
                    $response_array['message'] = 'Family Already Exists . Try Another Name';
                } else {
                    //now check if user is owner of family
                    $chcek_owner = $this->CommonModel
                        ->getRecord('family_trees', array('family_tree_id'), array('family_tree_name' => $_POST['old_family_tree_name'], 'family_tree_ownerid' => $userdata['user_id']))->num_row();

                    if ($chcek_owner == 1) {
                        //user is owner of family

                        //now go for update
                        $family_details = array();

                        //continue to insert new family in family_trees
                        $family_details['family_tree_name'] = $this->input->post('new_family_tree_name');


                        $this->CommonModel->update('family_trees', $family_details, array('family_tree_name' => $_POST['old_family_tree_name']));

                        $response_array['code'] = 1;
                        $response_array['message'] = 'Family Updated Successfully';

                    } else {
                        //user not authorised to rename
                        $response_array['code'] = 0;
                        $response_array['message'] = 'You Are Not Authorised to Rename Family';

                    }

                }

            }
        } else {
            $response_array['message'] = 'Parameters missing or invalid  in post data';
        }
        echo json_encode($response_array);
        exit;
    }

    /*
     * Removes Or Deletes Family Tree
     * */
    public function removeFamilyTree()
    {
        $response_array = array('code' => 0, 'message' => '');
        $userdata = $this->sesssion->usedata('vanshavali-mobile')[0];

        if ((isset($_POST['family_id']))) {

            //is user Authororised to delete . check family_access_table

            //now check if user is owner of family
            $chcek_user = $this->CommonModel
                ->getRecord('family_access_table', '*', array('family_id' => $_POST['family_id'], 'user_id' => $userdata['user_id'], 'can_delete' => 1))->num_row();
            if ($chcek_user == 1) {
                //user is authorised
                //go For delete

                $delete_family = $this->CommonModel->delete('family_access_table', array('user_id' => $userdata['user_id'], 'family_id' => $_POST['family_id']));

                $response_array['code'] = 1;
                $response_array['message'] = 'Family Deleted Successfully';
            } else {
                //user not authorised
                $response_array['code'] = 0;
                $response_array['message'] = 'You Are Not Authorised To Delete Family';

            }


        } else {
            $response_array['message'] = 'Parameters missing or invalid  in post data';

        }
        echo json_encode($response_array);
        exit;


    }


}