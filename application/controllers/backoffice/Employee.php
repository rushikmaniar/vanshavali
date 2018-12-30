<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends AdminController
{
    public $DIR = "upload/employee/";
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $search = ($this->input->get('txt_srch')) ? $this->input->get('txt_srch') : FALSE;
        //$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        //$pageLink = $this->CommonModel->createPagination(site_url("backoffice/Employee/index"),"emloyee_master",'',NULL,array('emp_code'=>'%'.($search) ? $search : ''.'%','emp_name'=>'%'.($search) ? $search : ''.'%','emp_phone'=>'%'.($search) ? $search : ''.'%','emp_email'=>'%'.($search) ? $search : ''.'%'),$this->per_page,$offset);
        //$employee_data = $this->CommonModel->dblike(array('emp_code'=>'%'.($search) ? $search : ''.'%','emp_name'=>'%'.($search) ? $search : ''.'%','emp_phone'=>'%'.($search) ? $search : ''.'%','emp_email'=>'%'.($search) ? $search : ''.'%'))->dbOrderBy(array('id'=>'DESC'))->getRecord("emloyee_master",'','employee_master.*,SELE',$this->per_page,$offset)->result_array();
        $val = '
        employee_master.*,
        department_master.dept_id,
        department_master.dept_name,
        (SELECT COUNT(`emp_code`) FROM `analysis_master` WHERE employee_master.emp_code = analysis_master.emp_code) as analysis_emp_code_entries
        ';
        $OrWhere = array();
        $employee_data = $this->CommonModel
            ->dbOrderBy(array('emp_code'=>'DESC'))
            ->dbjoin(
            array(
                array(
                    'table' => 'department_master',
                    'condition' => 'employee_master.dept_id = department_master.dept_id'
                )
            )
        )->getRecord('employee_master', $OrWhere, $val)->result_array();


        $this->pageTitle = 'Employee Management';
        $this->pageData['employee_data'] = $employee_data;
        $this->pageData['totalDisplay'] = count($employee_data);
        /*$this->pageData['offset'] = $offset;
        $this->pageData['pagelink'] = $pageLink;*/
        $this->render("Employee/index.php");
    }
    
    
    /**
     * View add Employee modal
     * 
     */
    public function viewAddEmployeeModal()
    {
        $OrWhere = array();
        $department_data = $this->CommonModel
            ->dbOrderBy(array('dept_id'=>'ASC'))
            ->getRecord('department_master', $OrWhere, 'department_master.*')->result_array();

        $this->pageData['department_list'] = $department_data;

        $this->render("backoffice/Employee/view_add_employee",FALSE);
    }

    
    /**
     * Add or edit Employee
     * 
     */
    public function addEditEmployee()
    {

        if ($this->input->post('action') && $this->input->post('action') == "addEmployee")
        {
            $employee_data = array(
                "emp_code" => $this->input->post('employee_frm_emp_code'),
                "emp_name" => $this->input->post('employee_frm_emp_name'),
                "emp_phone" => $this->input->post('employee_frm_emp_phone'),
                "emp_email" => $this->input->post('employee_frm_emp_email'),
                "dept_id" => $this->input->post('employee_frm_dept_id'),
                "emp_image" => null
            );


           $save = $this->CommonModel->save("employee_master",$employee_data);

           if($save){
               if($_FILES['employee_frm_emp_image']){
                   $path =  $_FILES['employee_frm_emp_image']['name'];
                   $ext = pathinfo($path, PATHINFO_EXTENSION);
                   $filename = 'emp_img_'.$save;
                   $path = FCPATH.'\\uploads\\employee';
                   $isupload = $this->CommonModel->doUpload('employee_frm_emp_image',$path,$filename,'jpg|png');
                   if($isupload){
                       $image = $this->CommonModel->update('employee_master', array('emp_image' => $filename.'.'.$ext), array('emp_code' => $save));
                   }

               }
                $this->session->set_flashdata("success","Employee added successfully");
            }else{
                $this->session->set_flashdata("error","problem adding employee. Try Later");
            }
        }
        
        if ($this->input->post('action') && $this->input->post('action') == "editEmployee" && $this->input->post('update_id'))
        {
            //check entry in analysis_master
            $analysis_record = $this->CommonModel->getRecord('analysis_master',array('emp_code'=>$this->input->post('update_id')))->num_rows();

            if($analysis_record == 0) {

                $employee_data = array(
                    "emp_code" => $this->input->post('employee_frm_emp_code'),
                    "emp_name" => $this->input->post('employee_frm_emp_name'),
                    "emp_phone" => $this->input->post('employee_frm_emp_phone'),
                    "emp_email" => $this->input->post('employee_frm_emp_email'),
                    "dept_id" => $this->input->post('employee_frm_dept_id')
                );

                $update = $this->CommonModel->update("employee_master", $employee_data, array('emp_code' => $this->input->post('update_id')));
                if ($update) {
                    if($_FILES['employee_frm_emp_image']){
                        $path =  $_FILES['employee_frm_emp_image']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $filename = 'emp_img_'.$this->input->post('update_id');
                        $path = FCPATH.'\\uploads\\employee';
                        $isupload = $this->CommonModel->doUpload('employee_frm_emp_image',$path,$filename,'jpg|png');
                        if($isupload){
                            $image = $this->CommonModel->update('employee_master', array('emp_image' => $filename.'.'.$ext), array('emp_code' => $this->input->post('update_id')));
                        }

                    }
                    $this->session->set_flashdata("success", "Employee updated successfully");
                } else {
                    $this->session->set_flashdata("error", "Problem Editing Employee.Try Later");
                }
            }else{
                $this->session->set_flashdata("error", "Entry Record Of this Employee Exist . First Delete That Records");
            }
        }
        
        redirect("backoffice/Employee","refresh");
    }
    
    
    /**
     * View edit modal with set employee data
     * 
     * @param int $user_id
     */
    public function viewEditEmployeeModal($emp_code)
    {
        $OrWhere = array();
        $department_data = $this->CommonModel
            ->dbOrderBy(array('dept_id'=>'DESC'))
            ->getRecord('department_master', $OrWhere, 'department_master.*')->result_array();

        $this->pageData['department_list'] = $department_data;

        $department_list = $this->CommonModel->getRecord("department_master",'')->result_array();
        $employee_data = $this->CommonModel->getRecord("employee_master",array('emp_code'=>$emp_code))->row_array();
        $this->pageData['employee_data'] = $employee_data;
        $this->pageData['department_list'] = $department_list;
        $this->render("backoffice/Employee/view_add_Employee",FALSE);
    }
    
    
    /**
     * Delete Employee
     * 
     */
    public function deleteEmployee()
    {
        if ($this->input->post('emp_code'))
        {
            //check entry in analysis_master
            $analysis_record = $this->CommonModel->getRecord('analysis_master',array('emp_code'=>$this->input->post('emp_code')))->num_rows();

            if($analysis_record == 0) {
                $result = $this->CommonModel->delete("employee_master", array('emp_code' => $this->input->post('emp_code')));
                if ($result) {
                        //delete employee image
                        unlink(FCPATH.'uploads\\employee\\'.$this->input->post('emp_image'));


                    $res_output['code'] = 1;
                    $res_output['status'] = "success";
                    $res_output['message'] = "Employee delete successfully";
                    echo json_encode($res_output);
                    exit();
                } else {
                    $res_output['code'] = 0;
                    $res_output['status'] = "error";
                    $res_output['message'] = "Employee not delete";
                    echo json_encode($res_output);
                    exit();
                }
            }else{
                $res_output['code'] = 0;
                $res_output['status'] = "error";
                $res_output['message'] = "EEntry Record Exist . First Delete That Records";
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