<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

header('Access-Control-Allow-Origin: *');
class Akun extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }

    //Menampilkan data kontak
    function index_get()
    {
        $id = $this->get('id_akun');
        if ($id == '') {
            $query = "select * from akun where jenis_akun not in(1,2)";
            $akun = $this->db->query($query)->result();
        } else {
            $this->db->where('id_akun', $id);
            $akun = $this->db->get('akun')->result();
        }
        $this->response($akun, 200);
    }
    //Mengirim atau menambah data user baru
    function index_post()
    {
        $data = array(
            'nama'          => $this->post('nama'),
            'email'    => $this->post('email'),
            'password'    => $this->post('password'),
            'alamat'    => $this->post('alamat'),
            'telepon'    => $this->post('telepon')
        );
        $insert = $this->db->insert('akun', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    //Memperbarui data user yang telah ada
    function index_put()
    {
        $id = $this->put('id_akun');
        $data = array(
            'nama'          => $this->put('nama'),
            'email'    => $this->put('email'),
            'password'    => $this->put('password'),
            'alamat'    => $this->put('alamat'),
            'telepon'    => $this->put('telepon')
        );
        $this->db->where('id_akun', $id);
        $update = $this->db->update('akun', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    //Menghapus salah satu data user
    function index_delete()
    {
        $id = $this->delete('id_akun');
        $this->db->where('id_akun', $id);
        $delete = $this->db->delete('akun');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
