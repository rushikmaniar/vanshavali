<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RemarksRecord extends AdminController{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = 'Remarks Record';


        $val = '
        remarks_master.remark_id,
        entry_record.entry_id,
        class_master.class_name,
        section_master.section_name,
        remarks_master.remarks
        ';
        //get entry_record_data
        $remarks_record = $this->CommonModel
            ->dbjoin(
                array(

                    array(
                        'table' => 'entry_record',
                        'condition' => 'remarks_master.entry_id = entry_record.entry_id'
                    ),
                    array(
                        'table' => 'class_master',
                        'condition' => 'entry_record.class_id = class_master.class_id'
                    ),
                    array(
                        'table' => 'section_master',
                        'condition' => 'remarks_master.section_id = section_master.section_id'
                    )
                )
            )
            ->getRecord('remarks_master','',$val)->result_array();


        $this->pageData['remarks_record'] = $remarks_record;
        $this->render('RemarksRecord/index.php');
    }

}
?>