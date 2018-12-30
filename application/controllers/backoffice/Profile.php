<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
    }

    public function index()
    {
        $this->pageTitle = "Profile";
        $user_data = $this->CommonModel->getRecord('user', array('user_id' => $this->session->userdata('feedback-admin')['user_id']));

        $this->pageData['user_details'] = $user_data->row_array();
        $this->render('Profile/index.php');
    }


    public function editProfile()
    {

        //post data
        $user_details = $this->input->post();

        //session data
        $session_user = $this->session->userdata('feedback-admin');

        $update = $this->CommonModel->update('user', array('user_email' => $user_details['frm_profile_user_email']), array('user_id' => $session_user['user_id']));
        if ($update) {
            if($_FILES['frm_profile_user_image']){
                $path =  $_FILES['frm_profile_user_image']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $filename = 'user_img_'.$session_user['user_id'];
                $path = FCPATH.'\\uploads\\user\\profile';
                $isupload = $this->CommonModel->doUpload('frm_profile_user_image',$path,$filename,'jpg|png');
                if($isupload){
                    $image = $this->CommonModel->update('user', array('user_image' => $filename.'.'.$ext), array('user_id' => $session_user['user_id']));
                }

            }
            //update session

            $session_user['user_email'] = $user_details['frm_profile_user_email'];
            $session_user['user_image'] = $filename.'.'.$ext;
            $this->session->set_userdata('feedback-admin', $session_user);

            $this->session->set_flashdata('success', 'Profile Updated successfully');

        } else {
            $this->session->set_flashdata('error', 'Fail To  Update Profile.Try Again');

        }
        redirect(base_url('backoffice/Profile'));
    }

    public function viewChangePasswordModel()
    {
        $session_user = $this->session->userdata('feedback-admin');

        $user_id = $session_user['user_id'];
        $this->pageData['user_id'] = $user_id;
        $this->render("backoffice/Profile/change_password", FALSE);
    }

    public function checkPassword()
    {
        $session_user = $this->session->userdata('feedback-admin');
        $old_password = $this->input->post('frm_change_password_oldpassword');
        $result = $this->CommonModel->getRecord('user', array('user_id' => $session_user['user_id'], 'user_password' => md5($old_password)));

        if ($result->num_rows() == 1) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updatePassword()
    {
        $session_user = $this->session->userdata('feedback-admin');
        $post_data = $this->input->post();

        if ($post_data) {
            $data = array('user_password' => md5($post_data['frm_change_password_newpassword']));
            $where = array('user_id' => $session_user['user_id']);
            $update = $this->CommonModel->update('user', $data, $where);
            if ($update) {
                $this->session->set_flashdata('success', 'Password Update successfully.');
            } else {
                $this->session->set_flashdata('error', 'Something went Wrong . Try Later');

            }
        } else {
            $this->session->set_flashdata('error', 'Password Updated Successfully');
        }

        redirect(base_url('backoffice/Profile'));
    }
}

?>