<?php
class Clothes_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_clothes($cuaca=NULL,$acara=NULL) {
        // Select fields from baju, cuaca, and acara tables
        $this->db->select('baju.*, cuaca.cuaca_name, acara.acara_name,cuaca.id as cid,acara.id as aid'); 
        $this->db->from('baju');
        $this->db->join('cuaca', 'cuaca.id = baju.cuaca_id');
        $this->db->join('acara', 'acara.id = baju.acara_id');
        if ($cuaca) {
            $this->db->where('baju.cuaca_id', $cuaca); // Assuming the primary key in the baju table is 'id'
            $this->db->where('baju.acara_id', $acara);
            $query = $this->db->get();
            return $query->result();
        }else{
            $query = $this->db->get();
            return $query->result();
        }
        
    }

    public function get_cuaca($id=NULL) {
        if ($id) {
            $query = $this->db->get_where('cuaca', array('id' => $id));
            return $query->row_array();
        } else {
            $query = $this->db->get('cuaca');
            return $query->result();
        }
    }

    public function get_acara($id=NULL) {
        if ($id) {
            $query = $this->db->get_where('acara', array('id' => $id));
            return $query->row_array();
        } else {
            $query = $this->db->get('acara');
            return $query->result();
        }
    }


    public function set_clothes($id = 0) {
        $data = array(
            'name' => $this->input->post('name'),
            'size' => $this->input->post('size'),
            'color' => $this->input->post('color'),
            'price' => $this->input->post('price')
        );

        if ($id == 0) {
            return $this->db->insert('clothes', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('clothes', $data);
        }
    }

    public function delete_clothes($id) {
        return $this->db->delete('clothes', array('id' => $id));
    }
    public function cekdata($data) {
        // Select fields from baju, cuaca, and acara tables
        $this->db->select('baju.*, cuaca.cuaca_name, acara.acara_name'); 
        $this->db->from('baju');
        $this->db->join('cuaca', 'cuaca.id = baju.cuaca_id');
        $this->db->join('acara', 'acara.id = baju.acara_id');
        $this->db->where('recommendation', $data);
        $query = $this->db->get();
        return $query->result();
        
    }
    public function getFavorit($baju_id) {
        // Select fields from baju, cuaca, and acara tables
        $this->db->select('COUNT(*) as count');
        $this->db->from('history_search');
        $this->db->where('baju_id', $baju_id);
        $query = $this->db->get();
        return $query->row()->count;
        
    }
}
