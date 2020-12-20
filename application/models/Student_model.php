<?php

class Student_model extends CI_Model {

    protected $table = 'tbl_student';

    public function __construct() {
        parent::__construct();
    }

    public function saveStudent($data, $student_id = '') {

        if ($student_id == '') {
            $status = $this->db->insert($this->table, $data);
        } else {
            $this->db->where('student_id', $student_id);
            $status = $this->db->update($this->table, $data);
        }
       // print_r($this->db->last_query());  exit;
        return ($status == true ? true : false);
    }

    public function updateStudentClass($student_id, $class_id) {
        $data = array(
            'class_id' => $this->input->post('class_id'),
        );
        $this->db->where('student_id', $student_id);
        $status = $this->db->update($this->table, $data);
    }

    public function getStudent($id) {
        $query = $this->db->get_where($this->table, array('student_id' => $id));
        return $query->row();
    }

    public function getStudentDetails($limit = null, $start = null, $count_status = '', $class_id = '', $student_id = '') {

        $sql = "SELECT student.*, class.class_name FROM tbl_student student INNER JOIN tbl_classes class ON student.class_id = class.class_id ";
        if ($class_id != '')
            $sql .= " WHERE student.class_id = " . $class_id;
        if ($student_id != '')
            $sql .= " AND student.student_id = " . $student_id;
        if (isset($start) && isset($limit) && $count_status == '')
        {
            $sql .= " ORDER BY student.created_date DESC ";
            $sql .= " LIMIT " . $start . "," . $limit;
        }

        $query = $this->db->query($sql);

        if ($count_status != '')
            return $query->num_rows();
        else if ($student_id != '')
            return $query->row();
        else
            return $query->result();
    }

    public function getAllStudents() {
        // $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function deleteStudent($id) {
        $this->db->where('student_id', $id);
        return $this->db->delete($this->table);
    }

    public function getStudentswithClass() {
        $query = $this->db->query("SELECT student.*, class.class_name FROM tbl_student student inner join tbl_classes class on student.class_id = class.class_id");
    }

}

?>