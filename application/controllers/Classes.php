<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Classes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('user/login');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model('classes_model');
        $this->load->library("pagination");
    }

    public function index() {
        $classes = $this->classes_model->getClasses();
        $this->load->view('class', array('classes' => $classes));
    }

    public function save() {
        $class_id = $this->input->post('class_id');
        $data = array(
            'class_name' => $this->input->post('class_name')
        );
        $check = $this->classes_model->checkName($this->input->post('class_name'));
        if ($check == 0) {
            $status = $this->classes_model->saveClass($data, $class_id);
            if ($status) {
                if ($class_id == '')
                    $this->session->set_flashdata('success_message', "Class Added Successfully");
                else
                    $this->session->set_flashdata('success_message', "Class Updated Successfully");
                redirect('classes/index/');
            }
        } else {
            $this->session->set_flashdata('error_message', "Class Already Exist");
            redirect('classes/index/');
        }
    }

    public function edit($id) {
        $class = $this->classes_model->getClass($id);
        $classes = $this->classes_model->getClasses();
        $this->load->view('class', array('classes' => $classes, 'standard' => $class));
    }

    public function delete() {

        $id = $this->input->post('id');
        $response = $this->classes_model->deleteClass($id);
        if ($response)
            $this->session->set_flashdata('success_message', "Class Deleted Successfully");
        else
            $this->session->set_flashdata('error_message', "Class Cannot Delete");
        echo $response;
    }

}
?>