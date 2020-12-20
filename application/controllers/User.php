<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {

    protected $table = 'tbl_user';

    public function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('user_model');
    }

    public function login() {

        $this->load->view('login');
    }

    public function validate() {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        
        if ($this->form_validation->run() == FALSE) {
            if (isset($this->session->userdata['logged_in'])) {
                $this->load->view('student');
            } else {
                $this->load->view('login');
            }
        } else {
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );

            $result = $this->user_model->login($data);
            if ($result == TRUE) {

                $email = $this->input->post('email');
                $result = $this->user_model->getUser($email);
                if ($result != false) {
                    $session_data = array(
                        'username' => $result[0]->username,
                        'email' => $result[0]->email,
                    );
                    $this->session->set_userdata('logged_in', $session_data);
                    $this->session->set_flashdata('success_message', "Logged In Successfully");
                    redirect('student/');
                }
            } else {
              
                $this->session->set_flashdata('error_message', "Invalid Username or Password");
                $this->load->view('login', $data);
            }
        }
    }

    public function logout() {

        $sess_array = array(
            'email' => '',
            'username' => ''
        );
        $this->session->set_flashdata('success_message', "Logged Out Successfully");
        $this->session->unset_userdata('logged_in', $sess_array);
       
        $this->load->view('login');
    }

}
?>