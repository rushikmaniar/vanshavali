<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        //check entry in anysis table
        $analysis_entry = $this->CommonModel->getRecord('analysis_master')->num_rows();
       $OrWhere = array();
       $val = '
       department_master.*,
       (SELECT COUNT(entry_id) FROM `entry_record`) as entries 
       ';
        $department_data = $this->CommonModel
            ->dbGroupBy('department_master.dept_id')
            ->dbjoin(
                array(
                    array(
                        'table' => 'class_master',
                        'condition' => 'department_master.dept_id = class_master.dept_id'
                    )
                )
            )
            ->dbOrderBy(array('dept_id'=>'DESC'))
            ->getRecord('department_master', $OrWhere, $val)->result_array();

        $this->pageTitle = 'Department Management';
        $this->pageData['analysis_entry'] = $analysis_entry;
        $this->pageData['department_data'] = $department_data;
        $this->render("Department/index.php");
    }
    
    
    /**
     * View add Department modal
     * 
     */
    public function viewAddDepartmentModal()
    {
        $this->render("backoffice/Department/view_add_department",FALSE);
    }

    
    /**
     * Add or edit Department
     * 
     */
    public function addEditDepartment()
    {
        //check entry in entry_record
        $entry_record = $this->CommonModel->getRecord('entry_record',array('class_id'=>$this->input->post('class_id')))->num_rows();
        if($entry_record == 0) {

            if ($this->input->post('action') && $this->input->post('action') == "addDepartment") {
                $department_data = array(
                    "dept_id" => $this->input->post('department_frm_dept_id'),
                    "dept_name" => $this->input->post('department_frm_dept_name')
                );


                $save = $this->CommonModel->save("department_master", $department_data);
                if ($save) {
                    $this->session->set_flashdata("success", "Department added successfully");
                } else {
                    $this->session->set_flashdata("error", "problem adding Department. Try Later");
                }
            }

            if ($this->input->post('action') && $this->input->post('action') == "editDepartment" && $this->input->post('update_id')) {

                $department_data = array(
                    "dept_name" => $this->input->post('department_frm_dept_name')
                );

                $update = $this->CommonModel->update("department_master", $department_data, array('dept_id' => $this->input->post('update_id')));
                if ($update) {
                    $this->session->set_flashdata("success", "Department updated successfully");
                } else {
                    $this->session->set_flashdata("error", "Problem Editing Department.Try Later");
                }
            }
        }else{
            $this->session->set_flashdata("error", "Entry Record Of this Class Exist . First Delete That Records");

        }
        
        redirect("backoffice/Department","refresh");
    }
    
    
    /**
     * View edit modal with set Department data
     * 
     * @param int $dept_id
     */
    public function viewEditDepartmentModal($dept_id)
    {

        $department_data = $this->CommonModel->getRecord("department_master",array('dept_id'=>$dept_id))->row_array();
        $this->pageData['department_data'] = $department_data;
        $this->render("backoffice/Department/view_add_Department",FALSE);
    }
    
    
    /**
     * Delete Department
     * 
     */
    public function deleteDepartment()
    {
        if ($this->input->post('dept_id'))
        {
            $result = $this->CommonModel->delete("department_master",array('dept_id'=>$this->input->post('dept_id')));
            if ($result)
            {
                $res_output['code'] = 1;
                $res_output['status'] = "success";
                $res_output['message'] = "Department deleted successfully";
                echo json_encode($res_output);
                exit();
            }
            else 
            {
                $res_output['code'] = 0;
                $res_output['status'] = "error";
                $res_output['message'] = "Department not delete";
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