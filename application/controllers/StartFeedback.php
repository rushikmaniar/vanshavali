<?php

/**
 * Created by PhpStorm.
 * User: jatin
 * Date: 010 10-06-2018
 * Time: 01:39 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class StartFeedback extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $classlist = $this->CommonModel
            ->dbjoin(
                array(
                    array(
                        'table' => 'employee_allocation',
                        'condition' => 'class_master.class_id = employee_allocation.class_id',
                        'jointype' => 'INNER'
                    )
                ))
            ->getRecord('class_master')->result_array();

        $val = '
        section_master.section_id,
        section_master.section_name,
        
        criteria_master.criteria_id,
        criteria_master.criteria_name,
        criteria_master.type_data                  
        ';
        $section_data = $this->CommonModel
            ->dbOrderBy(array('section_master.section_id','ASC'))
            ->dbjoin(
                array(
                    array(
                        'table' => 'criteria_master',
                        'condition' => 'criteria_master.section_id = section_master.section_id'
                    )
                ))
            ->getRecord('section_master','',$val)->result_array();

        //section wise criteria list

        $section_list = array();
        foreach ($section_data as $row):

            if(array_key_exists($row['section_id'],$section_list)):
                $section_list[$row['section_id']]['criteria_list'][$row['criteria_id'] ]= array('criteria_id'=>$row['criteria_id'],'criteria_name'=>$row['criteria_name'],'type_data'=>$row['type_data']);
            else:
                $section_list[$row['section_id']] = array('section_id'=>$row['section_id'],'section_name'=>$row['section_name'],'criteria_list'=>array($row['criteria_id'] => array('criteria_id'=>$row['criteria_id'],'criteria_name'=>$row['criteria_name'],'type_data'=>$row['type_data'])));
                    endif;

            endforeach;

        //if options are there
        $section_with_options = array();
        foreach ($section_list as $row):
            foreach ($row['criteria_list'] as $row_criteria):
                if($row_criteria['type_data'] == 1) {
                    $option_list = $this->CommonModel->getRecord('option_master', array('option_master.criteria_id' => $row_criteria['criteria_id']), 'option_id,option_text,option_value')->result_array();
                    $row_criteria['option_list'] = $option_list;
                    $section_list[$row['section_id']]['criteria_list'][$row_criteria['criteria_id']]['option_list'] = $option_list;
                }
            endforeach;
        endforeach;

        $this->pageTitle = 'Feedback System';
        $this->pageData['class_list'] = $classlist;
        $this->pageData['section_list'] = $section_list;
        $this->render('startfeedback.php');
    }

    public function getRelatedEmployees(){
        $class_id = $this->input->post('class_id');
        $response = array('code'=>0,'data'=>array(),'message'=>'');
        if($class_id != ''){
            $emp_list = $this->CommonModel
                ->dbjoin(
                    array(
                        array(
                            'table' => 'employee_master',
                            'condition' => 'employee_allocation.emp_code = employee_master.emp_code'
                        )
                    ))
                ->getRecord("employee_allocation", array('class_id' => $class_id),'employee_allocation.emp_code,employee_allocation.is_optional,employee_master.emp_name,employee_master.emp_image')->result_array();
            /*$employee_code_list = array_map(function ($data){return $data['employee_codes'];},$emp_list);
            $employee_name_list = array_map(function ($data){return $data['emp_name'];},$emp_list);*/

            if(!empty($emp_list)){
                $response['data'] = $emp_list;
                $response['code'] = 1;
            }
            else{
                $response['message'] = 'No Employees allocated to this class';
            }

        }else{
            $response['messsage'] = 'Null Class id';
        }
        echo json_encode($response);
    }
    public function InsertFeedbackData(){

        //insert entry in entry_record table
        $class_id = $this->input->post('frm_feedback_class');
        $entry_id = $this->CommonModel->save('entry_record',array('class_id'=>$class_id));

        //insert record in analysis master
        $section = $this->input->post('section');

        foreach ($section as $row_section):
            if($row_section['section_name'] == 'Employee Section'):
                foreach ($row_section['points'] as $employees):
                    foreach ($employees as $row_employee):
                        $empdata = array(
                            'entry_id'=>$entry_id,
                            'class_id'=>$class_id,
                            'section_id'=>$row_section['section_id'],
                            'criteria_id'=>$row_employee['criteria_code'],
                            'criteria_points'=>$row_employee['emp_criteria_points'],
                            'emp_code'=>$row_employee['emp_code']
                        );
                        $this->CommonModel->save('analysis_master',$empdata);
                    endforeach;
                endforeach;
            else:
                foreach ($row_section['points'] as $index=>$general):
                    $general_section_data = array(
                        'entry_id'=>$entry_id,
                        'class_id'=>$class_id,
                        'section_id'=>$row_section['section_id'],
                        'criteria_id'=>$index,
                        'criteria_points'=>$general,
                        'emp_code'=>null
                    );
                    $this->CommonModel->save('analysis_master',$general_section_data);
                endforeach;
            endif;

            //entry in remark_master
            $remrks = $row_section['remarks'];
            $remarks_data = array(
                'entry_id'=>$entry_id,
                'section_id'=>$row_section['section_id'],
                'remarks'=>$row_section['remarks']
            );
            $this->CommonModel->save('remarks_master',$remarks_data);

        endforeach;

        $this->session->set_flashdata('success',"Feedback Stored Successfully");
        redirect(base_url('thankyou'));

    }
}