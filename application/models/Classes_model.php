<?php

class Classes_model extends CI_Model {

    protected $table = 'tbl_classes';

    public function __construct() {
        parent::__construct();
    }

    public function getClasses() {

        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getClass($id) {
        $query = $this->db->get_where($this->table, array('class_id' => $id));
        return $query->row();
    }
     public function checkName($class_name) {
        $query = $this->db->get_where($this->table, array('class_name' => $class_name));
        return $query->num_rows();
    }

    public function saveClass($data, $class_id) {

        if ($class_id == '') {
            $status = $this->db->insert($this->table, $data);
        } else {
            $this->db->where('class_id', $class_id);
            $status = $this->db->update($this->table, $data);
        }
        return ($status == true ? true : false);
    }

    public function deleteClass($id) {
        $this->db->where('class_id', $id);
        if (!$this->db->delete($this->table)) {           
                return false;
        } else
            return true;
    }

}

?>