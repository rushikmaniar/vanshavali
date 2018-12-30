<?php
/**
 * Created by PhpStorm.
 * User: rushikwin8
 * Date: 012 12-08-2018
 * Time: 12:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class SiteManagement extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('directory');
    }

    public function index()
    {
        $this->pageTitle = 'Site Management';
        $this->pageData['site_settings'] = $this->CommonModel->getRecord('site_settings')->result_array();

        $imagelist = array();

        //$imagelist = directory_map(FCPATH . '\images\slider-image');
        $imagelist = $this->CommonModel->getRecord('slider')->result_array();
        $this->pageData['imagelist'] = $imagelist;
        $this->render('SiteManagement/index');
    }

    public function editSettings()
    {


        if ($this->input->post('frm_sitesettings')) {
            $settings_data = $this->input->post('frm_sitesettings');
            foreach ($settings_data as $key => $value) {
                $this->CommonModel->update('site_settings', array('settings_value' => $value), array('settings_id' => $key));
            }

            if($_FILES['sliderimg']){

                foreach ($_FILES['sliderimg']['name'] as $key => $row){


                    $temp = array(
                        'name'=>$_FILES['sliderimg']['name'][$key],
                        'type'=>$_FILES['sliderimg']['type'][$key],
                        'tmp_name'=>$_FILES['sliderimg']['tmp_name'][$key],
                        'error'=>$_FILES['sliderimg']['error'][$key],
                        'size'=>$_FILES['sliderimg']['size'][$key]
                    );
                    $_FILES['slide'][] = $temp;

                }

               foreach ($_FILES['slide'] as $key=> $row){
                   $path =  $row['name'];
                   $ext = pathinfo($path, PATHINFO_EXTENSION);
                   $filename = str_replace('.', '_', 'slide_'.$row['name']);
                   $path = FCPATH.'\\images\\slider-image\\';
                   $isupload = $this->CommonModel->doUpload("slide[$key]",$path,$filename,'jpg|png');
                   if($isupload){
                        $image = $this->CommonModel->save('slider', array('slidename' => $filename.'.'.$ext));
                    }
               }

            }else{
                echo 'else';
            }
            redirect(base_url('backoffice/SiteManagement'));
        } else {

            $this->session->flashdata('error', 'Invalid Parameter');
            redirect(base_url('backoffice'));
        }
    }

    public function deleleteSlides()
    {

        $slides = $this->input->post('slides');
        foreach ($slides as $row):
            $flag = unlink(FCPATH.'\\images\\slider-image\\'.$row);
                if($flag){
                    $delete = $this->CommonModel->delete('slider',array('slidename'=>$row));
                }
        endforeach;

    }
}