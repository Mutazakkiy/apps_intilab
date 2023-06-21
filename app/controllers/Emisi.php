<?php

class Emisi extends Controller {

	public function __construct()
	{	
        date_default_timezone_set('Asia/Jakarta');

		if($_SESSION['session_login'] != 'sudah_login') {
			Flasher::setMessage('Login','Tidak ditemukan.','danger');
			header('location: '. base_url . '/login');
			exit;
		} else {
			if(date('Y-m-d H:i:s') == $_SESSION['expired_at']){
				Flasher::setMessage('Login','Tidak ditemukan.','danger');
				header('location: '. base_url . '/login');
				exit;
			}
		}
	} 

	public function index()
	{
		if($_SESSION['versi'] == $this->versi()){
            
            $date = DATE('H:i:s');
            if($date > '01:00:00' && $date < '10:00:00'){
                $status = 'Selamat Pagi';
            } else if ($date > '10:00:01' && $date < '15:00:00'){
                $status = 'Selamat Siang';
            } else if ($date > '15:00:01' && $date < '18:00:00'){
                $status = 'Selamat Sore';
            } else {
                $status = 'Selamat Malam';
            }


			$data['title'] = 'APPS INTILAB';
			// $val = $this->model('UserModel')->getUserById();
			$data['nama'] = $_SESSION['name'];
            $data['salam'] = $status;
			// $data['koneksi'] = $this->connection();
			$data['total_data'] = $this->model('EmisiModel')->getJsonData();
			$this->view('templates/header', $data);
			$this->view('templates/sidebar', $data);
			$this->view('emisi/index', $data);
			$this->view('templates/footer');
		}else {
			session_start();
			session_destroy();
			header('location: '. base_url . '/login');
		}
		
	}

    public function add_data(){
        $data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		// $data['data'] = [];
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/scanQr', $data);
        $this->view('templates/footer');
    }

    public function scann(){
        $qr = '';
        $no_sample = '';
        $qr = $_POST['qr'];
        $no_sample = $_POST['no_sample'];
		$val = $this->model('EmisiModel')->GetData($qr, $no_sample);
		echo $val;
    }

    public function addOrderemisi(){
        $data['title'] = 'APPS INTILAB';
        $data['qr'] = $_POST['qr'];
        
        if($this->connection() == true && $_POST['qr'] != ''){
            $val = json_decode($this->model('EmisiModel')->GetData($_POST['qr']));
            if($val->record > 0){
                $data['id_kendaraan']   = $val->id_kendaraan;
                $data['id_qr']          = $val->id_qr;
                $data['bbm']            = $val->bbm;
                $data['plat']           = $val->plat;
                $data['no_mesin']       = $val->no_mesin;
                $data['merk']           = $val->merk;
                $data['transmisi']      = $val->transmisi;
                $data['tahun']          = $val->tahun;
                $data['cc']             = $val->cc;
                $data['km']             = $val->km;
                $data['kategori']       = $val->kategori;
                $data['bobot']          = $val->bobot;
            }else {
                $data['id_kendaraan']   = '';
                $data['id_qr']          = '';
                $data['bbm']            = '';
                $data['plat']           = '';
                $data['no_mesin']       = '';
                $data['merk']           = '';
                $data['transmisi']      = '';
                $data['tahun']          = '';
                $data['cc']             = '';
                $data['km']             = '';
                $data['kategori']       = '';
                $data['bobot']          = '';
            }
        }else {
            $data['id_kendaraan']   = '';
            $data['id_qr']          = '';
            $data['bbm']            = '';
            $data['plat']           = '';
            $data['no_mesin']       = '';
            $data['merk']           = '';
            $data['transmisi']      = '';
            $data['tahun']          = '';
            $data['cc']             = '';
            $data['km']             = '';
            $data['kategori']       = '';
            $data['bobot']          = '';
        }
        
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/input', $data);
        $this->view('templates/footer');
    }

    public function getregulasi(){
        $val = $this->model('EmisiModel')->regulasi();
        echo $val;
    }

    public function saveData(){
		$kon = $this->connection();
		$save = $this->model('EmisiModel')->saveData($kon, $_POST);
		echo json_encode($save['status']);
	}

    public function upload_data_to_server(){
		$data = $this->model('EmisiModel')->syncronize();
		echo $data;
	}

    public function detailEmisi($id=null){
        if($id){
            $data['qr'] = $id;
        }else {
            $data['qr'] = $_POST['qr_code'];
        }
        $data['title'] = 'APPS INTILAB';
        // $data['data'] = $this->model('EmisiModel')->getDetail($qr);
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/detail', $data);
        $this->view('templates/footer');
    }

    public function getDataDetail(){
        $val = $this->model('EmisiModel')->getDetail($_POST['qr']);
        echo $val;
    }

    public function viewData(){
        $data['title'] = 'APPS INTILAB';
        $val = $this->model('EmisiModel')->getDataEmisi();
		$data['data'] = $val->data;
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/data', $data);
        $this->view('templates/footer');
    }

    public function approveEmisi(){
		$id = $_POST['id'];
		$data = $this->model('EmisiModel')->approveData($id);
		echo $data;
	}

    public function deleteEmisi(){
		$id = $_POST['id'];
		$data = $this->model('EmisiModel')->deleteData($id);
		echo $data;
	}
}