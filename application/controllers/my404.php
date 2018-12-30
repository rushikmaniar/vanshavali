<?php
/**
 * Created by PhpStorm.
 * User: rushik
 * Date: 003 03-05-2018
 * Time: 08:46 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class my404 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->output->set_status_header('404');
        if(isset($_SESSION['feedback-admin'])){
            $home_link = base_url('backoffice');
        }
        else{
            $home_link = base_url();
        }
        $data['home_link'] = $home_link;
        $this->load->view('errors/pages/page-error-400',$data);//loading in custom error view
    }
}