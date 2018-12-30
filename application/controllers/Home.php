<?php

/**
 * Created by PhpStorm.
 * User: Rushik
 * Date: 12-04-2018
 * Time: 11:44 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends SiteController
{
    public function __construct()
    {

        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('directory');
        $imagelist = array();

        $imagelist = directory_map(FCPATH . '\images\slider-image');
        $this->pageData['imagelist'] = $imagelist;


        $this->pageTitle = 'feedback | Home';
        $this->render('home');
    }
}

?>

