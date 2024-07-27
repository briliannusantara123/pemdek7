<?php
class Clothes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Clothes_model');
        $this->load->helper('url_helper');
    }

    public function index() {
        $cuaca_id = $this->input->post('cuaca_id');
        $acara_id = $this->input->post('acara_id');
        if ($cuaca_id) {
            $data['clothes'] = $this->Clothes_model->get_clothes($cuaca_id,$acara_id);
            $data['cuaca'] = $this->Clothes_model->get_cuaca();
            $data['acara'] = $this->Clothes_model->get_acara();
        }else{
            $data['clothes'] = $this->Clothes_model->get_clothes();
            $data['cuaca'] = $this->Clothes_model->get_cuaca();
            $data['acara'] = $this->Clothes_model->get_acara();
            $data['title'] = 'Clothes Archive';
        }
        $this->load->view('template/header', $data);
        $this->load->view('clothes/index', $data);
        $this->load->view('template/footer');
    }
    public function fetch_data() {
        // URL endpoint API Prolog
        $api_url = 'http://localhost:8080/get_data';

        // Mengambil data dari API Prolog
        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

        // Mengirimkan data ke browser dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function simpangambar()
    {
        $cekdata = $this->Clothes_model->cekdata($this->input->post('recommendation'));
        if ($cekdata) {
            $this->session->set_flashdata('error', 'Baju Tersebut Sudah Ada', 300);
        }else{
            $config['upload_path']          = './gambar/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048; // 2MB
            $config['max_width']            = 1920;
            $config['max_height']           = 1080;

            // Memuat pustaka upload dengan konfigurasi
            $this->load->library('upload', $config);

            // Memeriksa apakah file berhasil diunggah
            if ($this->upload->do_upload('gambar')) {
                // Mendapatkan informasi file yang diunggah
                $upload_data = $this->upload->data();
                
                // Menyimpan nama file yang diunggah ke dalam database
                $data = [
                    'cuaca_id' => $this->input->post('cuaca_id'),
                    'acara_id' => $this->input->post('acara_id'),
                    'recommendation' => $this->input->post('recommendation'),
                    'gambar' => $upload_data['file_name'], 
                ];
                
                // Menyimpan data ke database
                $this->db->insert('baju', $data);

                // Menampilkan notifikasi sukses
                $this->session->set_flashdata('notif', 'Berhasil Menambahkan Data Baju', 300); // Disimpan selama 300 detik
            } else {
                // Menangani kesalahan unggah
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('notif', 'Gagal Mengunggah Gambar: ' . $error, 300);
            }
        }
        

        // Mengarahkan kembali ke halaman menu
        redirect('clothes');
    }

    public function view($id = NULL) {
        $data['clothes_item'] = $this->Clothes_model->get_clothes($id);

        if (empty($data['clothes_item'])) {
            show_404();
        }

        $data['title'] = $data['clothes_item']['name'];

        $this->load->view('templates/header', $data);
        $this->load->view('clothes/view', $data);
        $this->load->view('templates/footer');
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a new clothes item';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('size', 'Size', 'required');
        $this->form_validation->set_rules('color', 'Color', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('clothes/create');
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $validation_result = $this->validate_name_with_prolog($name);

            if ($validation_result->status == "valid") {
                $this->Clothes_model->set_clothes();
                redirect('clothes');
            } else {
                $data['error'] = "The name is invalid or already exists.";
                $this->load->view('templates/header', $data);
                $this->load->view('clothes/create', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function edit($id) {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['clothes_item'] = $this->Clothes_model->get_clothes($id);

        if (empty($data['clothes_item'])) {
            show_404();
        }

        $data['title'] = 'Edit clothes item';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('size', 'Size', 'required');
        $this->form_validation->set_rules('color', 'Color', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('clothes/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $validation_result = $this->validate_name_with_prolog($name);

            if ($validation_result->status == "valid") {
                $this->Clothes_model->set_clothes($id);
                redirect('clothes');
            } else {
                $data['error'] = "The name is invalid or already exists.";
                $this->load->view('templates/header', $data);
                $this->load->view('clothes/edit', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function delete($id) {
        $this->Clothes_model->delete_clothes($id);
        redirect('clothes');
    }

    private function validate_name_with_prolog($name) {
        $url = "http://localhost:8080/validate_name";
        $data = array("name" => $name);
        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return json_decode($result);
    }
}
