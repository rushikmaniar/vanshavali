<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller
{

    public $pageData = array();
    public $pageTitle = 'Page Title';
    public $userInfo = array();
    public $siteData = array();
    public $per_page = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('CommonModel');
        //site settings
        $site_settings = $this->CommonModel->getRecord('site_settings');
        $this->pageData['site_settings'] = $site_settings->result_array();
    }

    public function render($the_view = null, $template = 'main')
    {
        if ($the_view) {
            if ($template) {
                $this->pageData['page_content'] = $this->load->view($the_view, $this->pageData, TRUE);
                $this->load->view('template/' . $template, $this->pageData);
            } else {
                $this->load->view($the_view, $this->pageData);
            }

        } else {
            exit("View Not Found");
        }
    }


}
