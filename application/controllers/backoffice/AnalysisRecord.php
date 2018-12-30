<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AnalysisRecord extends AdminController{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = 'Analysis Record';


        $val = '
        	analysis_master.analysis_master_id,
        	entry_record.entry_id,
        	class_master.class_name,
        	section_master.section_name,
        	criteria_master.criteria_name,
        	analysis_master.criteria_points,
        	employee_master.emp_name
        	
        ';
        //get analysis_master record
        $analysis_record = $this->CommonModel
            ->dbjoin(
                array(

                    //join with entry_record
                    array(
                        'table' => 'entry_record',
                        'condition' => 'analysis_master.entry_id = entry_record.entry_id'
                    ),
                    //join with class_master
                    array(
                        'table' => 'class_master',
                        'condition' => 'analysis_master.class_id = class_master.class_id'
                    ),
                    //join with section_master
                    array(
                        'table' => 'section_master',
                        'condition' => 'analysis_master.section_id = section_master.section_id'
                    ),
                    //join with criteria_master
                    array(
                        'table' => 'criteria_master',
                        'condition' => 'analysis_master.criteria_id = criteria_master.criteria_id'
                    ),
                    //join with criteria_master
                    array(
                        'table' => 'employee_master',
                        'condition' => 'analysis_master.emp_code = employee_master.emp_code'
                    )
                )
            )
            ->getRecord('analysis_master','',$val)->result_array();

        $this->pageData['analysis_record'] = $analysis_record;
        $this->render('AnlaysisRecord/index.php');
    }

}
?>