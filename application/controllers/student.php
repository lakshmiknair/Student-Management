<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('user/login');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('student_model');
        $this->load->model('classes_model');
        $this->load->library("pagination");
    }

    public function index() {
        $class_id = $this->input->post('class_id');

        if ($class_id == '')
            $class_id = $this->session->userdata('class_id');
        else if ($class_id == 0) {
            $this->session->unset_userdata('class_id');
            $class_id = '';
        } else {
            $this->session->set_userdata('class_id', $class_id);
            $this->session->userdata('class_id');
        }
        $data = $this->getStudentList($class_id);
        $this->load->view('index', $data);
    }

    public function getStudentList($class_id) {
        $config = array();
        $config["per_page"] = 3;
        $config["uri_segment"] = 3;
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $config["base_url"] = base_url() . "index.php/student/index/";
        $config["total_rows"] = $this->student_model->getStudentDetails(null, null, 1, $class_id, '');

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['classes'] = $this->classes_model->getClasses();

        $data['students'] = $this->student_model->getStudentDetails($config["per_page"], $page, '', $class_id, '');
        $data['class_id'] = $class_id;
        return $data;
    }

    public function ajaxStudentList() {

        if ($this->session->userdata('class_id'))
            $class_id = $this->session->userdata('class_id');
        else
            $class_id = '';

        $result = $this->getStudentList($class_id);

        $students = $result['students'];
        $classes = $result['classes'];
        $links = $result['links'];

        $data = '<table class="table table-bordered" id="table" >';
        $data .= '<thead class="well">';
        $data .= '<tr>';
        $data .= '<th>Firstname</th>';
        $data .= '<th>Lastname</th>';
        $data .= '<th>Email</th>';
        $data .= '<th>Emergency No.</th>';
        $data .= '<th>Class</th>';
        $data .= '<th>Update Class</th>';
        $data .= '<th>Edit</th>';
        $data .= '<th>Delete</th>';
        $data .= '</tr>';
        $data .= '</thead>';

        $data .= '<tbody>';
        if (!empty($students)) {
            foreach ($students as $student) {
              
                $data .= '<tr>';
                $data .= '<td>' . $student->firstname . '</td>';
                $data .= '<td>' . $student->lastname . '</td>';
                $data .= '<td>' . $student->email . '</td>';
                $data .= '<td>' . $student->emergency_number.'</td>';
                $data .= '</td><td data-id="' . $student->student_id . '">' . $student->class_name . '</td>';
                $data .= '<td><a class="btn btn-default class-update" data-id="' . $student->student_id . '" role="button">Update</a></td>';
                $data .= '<td><a class="btn btn-default edit-student"  href="' . base_url('index.php/student/edit/' . $student->student_id) . '" role="button">Edit</a></td>';
                $data .= '<td><a class="btn btn-default delete" data-id="' . $student->student_id . '" role="button">Delete</a></td>';
                $data .= '</tr>';
            }
        } else {
            $data .= '<tr><td colspan="8" class="text-center">NO RECORDS</td></tr>';
        }

        $data .= ' </tbody>';
        $data .= ' </table>';
        if (!empty($students)) {
            $data .= '<div class="pagination_links text-center" >' . $links . '</div>';
        }
        echo $data;
        exit;
    }

    public function getData() {
        /* $data['firstname'] = set_value('firstname') ? set_value('firstname') : (isset($student->firstname) ? $student->firstname : '');
          $data['lastname'] = set_value('lastname') ? set_value('lastname') : (isset($student->lastname) ? $student->lastname : '');
          $data['address'] = set_value('address') ? set_value('address') : (isset($student->address) ? $student->address : '');
          $data['contact_number'] = set_value('contact_number') ? set_value('contact_number') : (isset($student->contact_number) ? $student->contact_number : '');
          $data['emergency_number'] = set_value('emergency_number') ? set_value('emergency_number') : (isset($student->emergency_number) ? $student->emergency_number : '');
          $data['email'] = set_value('email') ? set_value('email') : (isset($student->email) ? $student->email : '');
          $data['class_id'] = set_value('class_id') ? set_value('class_id') : (isset($student->class_id) ? $student->class_id : '');
          $data['status'] = set_value('status') ? set_value('status') : (isset($student->status) ? $student->status : '');
          $data['student_id'] =  (isset($student->student_id) ? $student->student_id : '');
          $data['profile_image'] = isset($student->profile_image) ? $student->profile_image : ''; */

        $data['firstname'] = set_value('firstname') ? set_value('firstname') : '';
        $data['lastname'] = set_value('lastname') ? set_value('lastname') : '';
        $data['address'] = set_value('address') ? set_value('address') : '';
        $data['contact_number'] = set_value('contact_number') ? set_value('contact_number') : '';
        $data['emergency_number'] = set_value('emergency_number') ? set_value('emergency_number') : '';
        $data['email'] = set_value('email') ? set_value('email') : '';
        $data['class_id'] = set_value('class_id') ? set_value('class_id') : '';
        $data['status'] = set_value('status') ? set_value('status') : '';
        $data['student_id'] = '';
         $data['profile_image'] = '';
        $data['classes'] = $this->classes_model->getClasses();
        return $data;
    }

    public function create() {
        $data = $this->getData();
        $this->load->view('form', $data);
    }

    public function edit($id) {

        $student = $this->student_model->getStudent($id);
        //   $data = $this->getData($student);
        $data['firstname'] = $student->firstname;
        $data['lastname'] = $student->lastname;
        $data['address'] = $student->address;
        $data['contact_number'] = $student->contact_number;
        $data['emergency_number'] = $student->emergency_number;
        $data['email'] = $student->email;
        $data['class_id'] = $student->class_id;
        $data['status'] = $student->status;
        $data['profile_image'] = $student->profile_image;
        $data['student_id'] = $student->student_id;
        $data['classes'] = $this->classes_model->getClasses();
        $this->load->view('form', $data);
    }

    public function save() {

        $validator = array('success' => false, 'messages' => array());

        $validate_data = array(
            array(
                'field' => 'firstname',
                'label' => 'First Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'lastname',
                'label' => 'Last Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'contact_number',
                'label' => 'Contact Number',
                'rules' => 'numeric'
            ),
            array(
                'field' => 'emergency_number',
                'label' => 'Emergency Contact Number',
                'rules' => 'required|regex_match[/^[0-9]{10}$/]'
            ),
            array(
                'field' => 'email',
                'label' => 'Eamil',
                'rules' => 'valid_email'
            ),
            array(
                'field' => 'class_id',
                'label' => 'Class',
                'rules' => 'required'
            )
        );

        if (empty($_FILES['profile_image']['name']) && $this->input->post('photo') == '') {
            $this->form_validation->set_rules('profile_image', 'Profile Image', 'required');
        }

        $this->form_validation->set_rules($validate_data);
        $this->form_validation->set_error_delimiters('<p class = "text-danger">', '</p>');

        $student_id = $this->input->post('student_id');
        $profile_image = $this->input->post('photo');

        if ($this->form_validation->run()) {

            if (!empty($_FILES['profile_image']['name'])) {
                $imgUrl = $this->uploadImage();
            }

            $imgUrl = $imgUrl ?? $this->input->post('photo') ?? 'assets/images/default/default.jpg';

            $status = $this->input->post('student_id') == '' ? 1 : ($this->input->post('status')== 'on'? 1:0);
            $data = array(
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'address' => $this->input->post('address'),
                'contact_number' => $this->input->post('contact_number'),
                'emergency_number' => $this->input->post('emergency_number'),
                'email' => $this->input->post('email'),
                'class_id' => $this->input->post('class_id'),
                'profile_image' => $imgUrl,
                'status' => $status
            );


            if ($student_id != '')
                $data['updated_date'] = date('Y-m-d H:i:s');
            else
                $data['created_date'] = date('Y-m-d H:i:s');

            $status = $this->student_model->saveStudent($data, $student_id);

            if ($status == true) {
                if ($student_id == '')
                    $this->session->set_flashdata('success_message', "Student Details Added Successfully");
                else
                    $this->session->set_flashdata('success_message', "Student Details Updated Successfully");
            } else {

                $this->session->set_flashdata('error_message', "Error while inserting the information into the database");
            }
            redirect('student/');
        } else {

            $data = $this->getData();

            if ($student_id != '')
                $data['student_id'] = $student_id;
            if ($profile_image != '')
                $data['profile_image'] = $profile_image;

            $this->load->view('form', $data);
        }
    }

    public function uploadImage() {
        $type = explode('.', $_FILES['profile_image']['name']);
        $type = $type[count($type) - 1];
        $imagefile = uniqid(rand()) . '.' . $type;
        $url = 'assets/images/students/' . $imagefile;
        if (in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
            if (is_uploaded_file($_FILES['profile_image']['tmp_name'])) {
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $url)) {
                    $source_path = $url;
                    $thumb_path = 'assets/images/students/thumb/';
                    $thumb_width = 100;
                    $thumb_height = 100;
                    // Image resize config 
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $source_path;
                    $config['new_image'] = $thumb_path;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = $thumb_width;
                    $config['height'] = $thumb_height;

                    $this->load->library('image_lib', $config);

                    if ($this->image_lib->resize()) {
                        $thumbnail = $thumb_path . $imagefile;
                        $thumb_image_size = $thumb_width . 'x' . $thumb_height;
                    }

                    return $imagefile;
                } else {
                    return false;
                }
            }
        }
    }

    public function delete() {

        $id = $this->input->post('id');
        $response = $this->student_model->deleteStudent($id);
        if ($response)
            $this->session->set_flashdata('success_message', "Class Deleted Successfully");
        else
            $this->session->set_flashdata('error_message', "Class Cannot Delete");
        echo $response;
    }

    public function update() {

        $student_id = $this->input->post('student_id');
        $new_class_id = $this->input->post('class_id');
        $this->student_model->updateStudentClass($student_id, $new_class_id);
        $student = $this->student_model->getStudentDetails(null, null, '', '', $student_id);
        $class_name = $student->class_name;
        echo json_encode(array(
            "statusCode" => 200,
            "class_name" => $class_name
        ));
    }

    public function export() {

        $this->load->library('excel');
        $class_id = $this->session->userdata('class_id');

        $listInfo = $this->student_model->getStudentDetails(null, null, '', $class_id, '');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
// set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Contact Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Emergency Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Calss');
// set Row
        $rowCount = 2;
        foreach ($listInfo as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list->firstname);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->lastname);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list->address);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->contact_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list->emergency_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list->email);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list->status);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list->class_name);
            $rowCount++;
        }
        $filename = "Student-Report-" . date("Y-m-d-H-i-s") . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename = "' . $filename . '"');
        header('Cache-Control: max-age = 0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}

?>