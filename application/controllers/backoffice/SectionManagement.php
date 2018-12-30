<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SectionManagement extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //check entry in anysis table
        $section_analysis_entry = $this->CommonModel->getRecord('analysis_master')->num_rows();
        $OrWhere = array();
        $section_data = $this->CommonModel
            ->dbOrderBy(array('section_id' => 'DESC'))
            ->getRecord('section_master', $OrWhere, 'section_master.*')->result_array();

        $this->pageTitle = 'Section Management';
        $this->pageData['section_master_data'] = $section_data;
        $this->pageData['section_analysis_entry'] = $section_analysis_entry;
        $this->render("Section/index.php");
    }


    /**
     * View add Section modal
     *
     */
    public function viewAddSectionModal()
    {
        $this->render("backoffice/Section/view_add_section", FALSE);
    }


    /**
     * Add or edit Section
     *
     */
    public function addEditSection()
    {
        //check entry in entry_record
        $entry_record = $this->CommonModel->getRecord('entry_record')->num_rows();

        if($entry_record == 0) {

            if ($this->input->post('action') && $this->input->post('action') == "addSection") {
                $section_data = array(
                    "section_name" => $this->input->post('section_master_frm_section_name')
                );


                $save = $this->CommonModel->save("section_master", $section_data);
                if ($save) {
                    $this->session->set_flashdata("success", "Section added successfully");
                } else {
                    $this->session->set_flashdata("error", "problem adding Section. Try Later");
                }
            }

            if ($this->input->post('action') && $this->input->post('action') == "editSection") {
                $section_data = array(
                    "section_name" => $this->input->post('section_master_frm_section_name')
                );

                $update = $this->CommonModel->update("section_master", $section_data, array('section_id' => $this->input->post('update_id')));
                if ($update) {
                    $this->session->set_flashdata("success", " Section updated successfully");
                } else {
                    $this->session->set_flashdata("error", "Problem Editing Section.Try Later");
                }
            }
        }else{
            $this->session->set_flashdata("error", "Entry Record Exist . First Delete That Records");

        }
        redirect("backoffice/SectionManagement", "refresh");
    }


    /**
     * View edit modal with set Section data
     *
     * @param int $section_master_id
     */
    public function viewEditSectionModal($section_master_id)
    {

        $section_data = $this->CommonModel->getRecord("section_master", array('section_id' => $section_master_id))->row_array();
        $this->pageData['section_master_data'] = $section_data;
        $this->render("backoffice/Section/view_add_section", FALSE);
    }


    /**
     * Delete  Section
     *
     */
    public function deleteSection()
    {
        if ($this->input->post('section_master_id')) {
            //check entry in entry_record
            $entry_record = $this->CommonModel->getRecord('entry_record')->num_rows();
            if ($entry_record == 0) {
                $result = $this->CommonModel->delete("section_master", array('section_id' => $this->input->post('section_master_id')));
                if ($result) {
                    $res_output['code'] = 1;
                    $res_output['status'] = "success";
                    $res_output['message'] = "Section deleted successfully";
                    echo json_encode($res_output);
                    exit();
                } else {
                    $res_output['code'] = 0;
                    $res_output['status'] = "error";
                    $res_output['message'] = "Section not delete";
                    echo json_encode($res_output);
                    exit();
                }
            } else {
                //record exist in entry record
                $res_output['code'] = 0;
                $res_output['status'] = "error";
                $res_output['message'] = "Entry Record Exist . First Delete That Records";
                echo json_encode($res_output);
                exit();
            }
        } else {
            $res_output['code'] = 0;
            $res_output['status'] = "error";
            $res_output['message'] = "Request parameter not found,please try again";
            echo json_encode($res_output);
            exit();
        }

    }
}


?>