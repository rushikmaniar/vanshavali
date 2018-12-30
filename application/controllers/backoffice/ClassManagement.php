<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClassManagement extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
       $OrWhere = array();
        $val = '
        class_master.*,
        department_master.dept_id,
        department_master.dept_name,
        (SELECT COUNT(`entry_id`) FROM `entry_record` WHERE entry_record.class_id = class_master.class_id) as entries
        ';
        $class_data = $this->CommonModel
            ->dbOrderBy(array('class_master.class_id'=>'DESC'))
            ->dbjoin(
                array(
                    array(
                        'table' => 'department_master',
                        'condition' => 'class_master.dept_id = department_master.dept_id'
                    )
                )
            )->getRecord('class_master', $OrWhere, $val)->result_array();

        $this->pageTitle = 'Class Management';
        $this->pageData['class_data'] = $class_data;
        $this->render("Class/index.php");
    }
    
    
    /**
     * View add Class modal
     * 
     */
    public function viewAddClassModal()
    {
        $OrWhere = array();
        $department_data = $this->CommonModel
            ->dbOrderBy(array('dept_id'=>'ASC'))
            ->getRecord('department_master', $OrWhere, 'department_master.*')->result_array();

        $this->pageData['department_list'] = $department_data;
        $this->render("backoffice/Class/view_add_class",FALSE);

    }

    
    /**
     * Add or edit Class
     * 
     */
    public function addEditClass()
    {

        if ($this->input->post('action') && $this->input->post('action') == "addClass")
        {
            $class_data = array(
                "class_id" => $this->input->post('class_frm_class_id'),
                "class_name" => $this->input->post('class_frm_class_name'),
                "dept_id" => $this->input->post('class_frm_dept_id')
            );


            $save = $this->CommonModel->save("class_master",$class_data);
            if($save){
                $this->session->set_flashdata("success","Class added successfully");
            }else{
                $this->session->set_flashdata("error","problem adding Class. Try Later");
            }
        }
        
        if ($this->input->post('action') && $this->input->post('action') == "editClass")
        {
            $update_id = $this->input->post('update_id');
            if($update_id) {
                //check entry in entry_record
                $entry_record = $this->CommonModel->getRecord('entry_record', array('class_id' => $update_id))->num_rows();
                if ($entry_record == 0) {
                    $class_data = array(
                        "class_id" => $this->input->post('class_frm_class_id'),
                        "class_name" => $this->input->post('class_frm_class_name'),
                        "dept_id" => $this->input->post('class_frm_dept_id')
                    );

                    $update = $this->CommonModel->update("class_master", $class_data, array('class_id' => $this->input->post('update_id')));
                    if ($update) {
                        $this->session->set_flashdata("success", "Class updated successfully");
                    } else {
                        $this->session->set_flashdata("error", "Problem Editing Class.Try Later");
                    }
                } else {
                    $this->session->set_flashdata("error", "Entry Record Of this Class Exist . First Delete That Records");
                }
            }else{
                $this->session->set_flashdata("error", "Problem Editing Class.Try Later");
            }
        }
        
        redirect("backoffice/ClassManagement","refresh");
    }
    
    
    /**
     * View edit modal with set Class data
     * 
     * @param int $user_id
     */
    public function viewEditClassModal($class_id)
    {
        $OrWhere = array();
        $department_data = $this->CommonModel
            ->dbOrderBy(array('dept_id'=>'ASC'))
            ->getRecord('department_master', $OrWhere, 'department_master.*')->result_array();

        $this->pageData['department_list'] = $department_data;
        $class_data = $this->CommonModel->getRecord("class_master",array('class_id'=>$class_id))->row_array();
        $this->pageData['class_data'] = $class_data;
        $this->render("backoffice/Class/view_add_class",FALSE);
    }
    
    
    /**
     * Delete Class
     * 
     */
    public function deleteClass()
    {
        if ($this->input->post('class_id'))
        {
            //check entry in entry_record
            $entry_record = $this->CommonModel->getRecord('entry_record',array('class_id'=>$this->input->post('class_id')))->num_rows();
            if($entry_record == 0) {
                $result = $this->CommonModel->delete("class_master", array('class_id' => $this->input->post('class_id')));
                if ($result) {
                    $res_output['code'] = 1;
                    $res_output['status'] = "success";
                    $res_output['message'] = "Class deleted successfully";
                    echo json_encode($res_output);
                    exit();
                } else {
                    $res_output['code'] = 0;
                    $res_output['status'] = "error";
                    $res_output['message'] = "Class not deleted";
                    echo json_encode($res_output);
                    exit();
                }
            }else{
                $res_output['code'] = 0;
                $res_output['status'] = "error";
                $res_output['message'] = "Entry Record Of this Class Exist . First Delete That Records";
                echo json_encode($res_output);
                exit();
            }
        }
        else 
        {
            $res_output['code'] = 0;
            $res_output['status'] = "error";
            $res_output['message'] = "Request parameter not found,please try again";
            echo json_encode($res_output);
            exit();
        }
    }
}
?>