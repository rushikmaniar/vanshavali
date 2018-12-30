<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28/7/2018
 * Time: 10:04 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class DatabaseManagement extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->pageTitle = 'Database Management';
        $this->render("databasemanagement/index.php");
    }

    /* Truncate Almost tables */
    public function truncatedatabase()
    {
        $tables = $this->db->query("SELECT t.TABLE_NAME AS myTables FROM INFORMATION_SCHEMA.TABLES AS t WHERE t.TABLE_SCHEMA = 'feedback' AND  t.TABLE_NAME NOT IN ('user','ranking','section_master','criteria_master')")->result_array();
        $final = array_map(function ($data) {
            return $data['myTables'];
        }, $tables);
        foreach ($final as $key => $val) {
            $this->CommonModel->db->empty_table($val);
        }

        $this->session->set_flashdata('success', 'Tables Truncated Successfully');
        redirect(base_url('backoffice/DatabaseManagement'));
    }

    /* Export Full database */
    public function exportdatabase()
    {
        $this->load->dbutil();
        $db_name = 'feedback' . date('Y') . '.zip';


        $backup =& $this->dbutil->backup(array('format'=>'zip','filename'=>$db_name));


        $save = FCPATH . 'backup/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);


        $this->load->helper('download');
        force_download($db_name, $backup);
        redirect(base_url('backoffice/DatabaseManagement'));
    }

}