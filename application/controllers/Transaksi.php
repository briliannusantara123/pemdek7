<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {
	public function __construct()
    {
        parent::__construct();

        $this->load->model('Menu_model');
        $this->load->model('Home_model');
        
        // Library
		$this->load->library('form_validation'); 

        // Session
        // $level = $this->session->userdata('level');
        // if($this->session->userdata('username') == ""){
        //    redirect('auth/logout');
     }


	public function index()
	{
		$qty = $this->input->post('qty');
		$id_menu = $this->input->post('id_menu');
        if($qty)
        {
        	$data = [
			'id_menu' => $id_menu,
			'qty' => $qty,
			'bayar' => $this->input->post('bayar')
			];
			$simpan = $this->db->insert('transaksi',$data);
			if ($simpan) {
				$menu = $this->Menu_model->getMenuName($id_menu);
				$update = [
					'stok' => $menu->stok - $qty,
				];
				$this->db->where('id',$id_menu);
				$this->db->update('menu',$update);
			}
			$this->session->set_flashdata('notif', 'Transaksi Berhasil Disimpan', 300); // Disimpan selama 300 detik
			redirect('transaksi');
        } else 
        {
            $data = [
				'menu' => $this->Menu_model->getData(),
			];
			$this->load->view('template/header');
	        $this->load->view('transaksi/index',$data);
	        $this->load->view('template/footer');

        }
		
	}
	public function getMenu($menu) {
        $data = $this->Menu_model->getMenuName($menu);
        echo json_encode($data);
    }
}
