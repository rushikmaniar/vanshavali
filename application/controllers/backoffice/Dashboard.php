<?php
/**
 * Created by PhpStorm.
 * User: Rushik
 * Date: 23-04-2018
 * Time: 11:07 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //total employees
        $total_employees = $this->CommonModel->getRecord('employee_master')->num_rows();

        //total classes
        $total_class = $this->CommonModel->getRecord('class_master')->num_rows();

        //total entries
        $total_entries = $this->CommonModel->getRecord('entry_record')->num_rows();

        //total criterias
        $total_criterias = $this->CommonModel->getRecord('criteria_master')->num_rows();

        $records = array('total_employees'=>$total_employees,'total_class'=>$total_class,'total_entries'=>$total_entries,'total_criterias'=>$total_criterias);

        $this->pageData['records'] = $records;
        $this->pageTitle = 'Dashboard';
        $this->render("dashboard/index");
    }
}