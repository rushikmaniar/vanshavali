<?php
/**
 * Created by PhpStorm.
 * User: rushikwin8
 * Date: 001 01-08-2018
 * Time: 08:16 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class ThankYou extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('directory');
        $image = directory_map(FCPATH . '\images\thankyou');

        $this->pageTitle = 'Thank You';
        $this->pageData['thankyou_image'] = $image[array_rand($image)];

        $this->render('thankyou');
    }
}