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

    public function index()
    {

    }

    /*
     *  Get list of Family trees Relevant To Looged In User From family_trees_table
     *
     * */
    public function getFamilyTreeList()
    {
        //logged in user data

        $userdata = $this->sesssion->userdata('vanshavali-mobile');

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

        $this->response_array['vanshavali_response']['code'] = 200;
        $this->response_array['vanshavali_response']['data']['family_list'] = $family_list;
        $this->response_array['vanshavali_response']['message'] = 'Status 200 Ok . Family List Fetched';

        echo json_encode($this->response_array);
        exit(0);
    }

    /*
     * Creates Family_tree in family_tree table
     * */
    public function createFamilyTree()
    {

        $userdata = $this->sesssion->userdata('vanshavali-mobile');

        //get post data
        if ((isset($_POST['family_tree_name']))) {
            //check if family with sam name exists
            $tree_list = $this->CommonModel
                ->getRecord('family_trees', array('family_tree_name' => $_POST['family_tree_name']), array('family_tree_id'));

            if ($tree_list->num_rows() > 0) {
                //family with same name already exsts. generate error
                $this->response_array['vanshavali_response']['code'] = 409;
                $this->response_array['vanshavali_response']['message'] = 'Error 409 Conflicts . Family Already Exists . Try Another Name';
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

                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = '200 Ok . Family Added Successfully';

            }

        }
        echo json_encode($this->response_array);
        exit;
    }

    /*
     * Update Family Tree Name
     * */
    public function updateFamilyTree()
    {
        $userdata = $this->sesssion->userdata('vanshavali-mobile');

        //get post data
        if ((isset($_POST['new_family_tree_name'])) && (isset($_POST['old_family_tree_name'])) && (isset($_POST['family_id']))) {
            //check if user is authorised . user should be owner of family
            $where = array('family_tree_id' => $_POST['family_id'], 'family_tree_ownerid' => $userdata['user_id']);
            $chcek_owner = $this->CommonModel
                ->getRecord('family_trees', $where)->num_rows();

            if ($chcek_owner == 1) {
                //users is authorised . check for duplication of family tree name
                $orWhere = array('family_tree_name' => $_POST['new_family_tree_name'], 'family_tree_id !=' => $_POST['family_id']);
                $tree_list = $this->CommonModel
                    ->getRecord('family_trees', $orWhere);
                if ($tree_list->num_rows() > 0) {
                    //famliy name Exists Error
                    $this->response_array['vanshavali_response']['code'] = 409;
                    $this->response_array['vanshavali_response']['message'] = 'Error 409 Conflicts . Family Already Exists . Try Another Name';
                } else {
                    //go For Update
                    $family_details = array();

                    //continue to insert new family in family_trees
                    $family_details['family_tree_name'] = $this->input->post('new_family_tree_name');


                    $this->CommonModel->update('family_trees', $family_details, array('family_tree_id' => $_POST['family_id']));

                    $this->response_array['vanshavali_response']['code'] = 200;
                    $this->response_array['vanshavali_response']['message'] = 'Status 200 OK . Family Tree Name Updated';
                }

            } else {
                //error user not authorised
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden . User Not Authorised To Rename Family Tree';;
            }
        } else {
            //wrong parameters Error 400 Bad Request
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad Request. Insufficient Parameters';
        }
        echo json_encode($this->response_array);
        exit;
    }

    /*
     * Removes Or Deletes Family Tree
     * */
    public function removeFamilyTree()
    {
        $userdata = $this->sesssion->userdata('vanshavali-mobile');

        if ((isset($_POST['family_id']))) {

            //is user Authororised to delete . check family_access_table

            //now check if user is owner of family
            $where = array(
                'family_id' => $_POST['family_id'],
                'family_tree_ownerid' => $userdata['user_id']
            );
            $chcek_user = $this->CommonModel
                ->getRecord('family_trees', $where)->num_rows();
            if ($chcek_user == 1) {
                //user is authorised
                //go For delete

                $delete_family = $this->CommonModel->delete('family_trees', array('family_id' => $_POST['family_id']));

                $this->response_array['vanshavali_response']['code'] = 200;
                $this->response_array['vanshavali_response']['message'] = '200 OK . Family Tree Successfully';
            } else {
                //user not authorised
                $this->response_array['vanshavali_response']['code'] = 403;
                $this->response_array['vanshavali_response']['message'] = 'Error 403 Forbidden . User Not Authorised';

            }


        } else {
            $this->response_array['vanshavali_response']['code'] = 400;
            $this->response_array['vanshavali_response']['message'] = 'Error 400 Bad Request . Parameters Invalid';

        }
        echo json_encode($this->response_array);
        exit;


    }




}