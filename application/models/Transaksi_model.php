<?php

class Transaksi_model extends CI_model
{
    public function getData($dari=NULL,$sampai=NULL)
    {
    	if ($dari) {
    		$this->db->select('m.nama_menu,m.harga,t.*')
	        ->from('transaksi t')
	        ->join('menu m', 't.id_menu = m.id')
	        ->where('DATE(t.tgl_transaksi) >=', $dari) 
		    ->where('DATE(t.tgl_transaksi) <=', $sampai)
		    ->where('t.deleted',0);
	        $query = $this->db->get();

        	return $query->result();
    	}else{
    		$this->db->select('m.nama_menu,m.harga,t.*')
	        ->from('transaksi t')
	        ->join('menu m', 't.id_menu = m.id')
		    ->where('t.deleted',0);
	        $query = $this->db->get();

        	return $query->result();
    	}
    }

}