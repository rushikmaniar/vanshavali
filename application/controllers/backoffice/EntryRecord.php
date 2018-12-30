<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EntryRecord extends AdminController{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = 'EntryRecord';

        //get list of class
        $class_list = $this->CommonModel->getRecord('class_master')->result_array();

        //get entry_record_data
        $entry_record = $this->CommonModel
            ->dbjoin(
                array(
                    array(
                        'table' => 'class_master',
                        'condition' => 'entry_record.class_id = class_master.class_id'
                    )
                )
            )
            ->getRecord('entry_record','','entry_record.entry_id,entry_record.class_id,class_master.class_name')->result_array();

        $this->pageData['class_list'] = $class_list;
        $this->pageData['entry_record'] = $entry_record;
        $this->render('EntryRecord/index.php');
    }

    public function deleteEntryRecord()
    {
        $class_id = $this->input->post('class_id');
        if ($class_id)
        {
            if($class_id == "ALL"){
                $result = $this->CommonModel->db->empty_table('entry_record');
            }
            else{
                $result = $this->CommonModel->delete("entry_record",array('class_id'=>$class_id));
            }
            if ($result)
            {
                $res_output['code'] = 1;
                $res_output['status'] = "success";
                $res_output['message'] = "Entry deleted successfully";
                echo json_encode($res_output);
                exit();
            }
            else
            {
                $res_output['code'] = 0;
                $res_output['status'] = "error";
                $res_output['message'] = "Entry not deleted";
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