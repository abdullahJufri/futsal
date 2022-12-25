<?php

namespace App\Controllers\api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Futsal extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
    }

    public function insert_futsal()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');
        $jumlah_lapangan = $this->request->getPost('jumlah_lapangan');
        $id_pengelola = $this->request->getPost('id_pengelola');
        $alamat_lapangan = $this->request->getPost('alamat_lapangan');
        $maps = $this->request->getPost('maps');
        $builderUsers = $this->db->table('users');
        $builderUsers->where(['email' => $email])->select('*');
        $queryUsers    =  $builderUsers->get();

        $rowUsers = $queryUsers->getRowArray();

        if ($rowUsers['roles'] == 0) {
            $dataValues['name'] = $name;
            $dataValues['jumlah_lapangan'] = $jumlah_lapangan;
            $dataValues['id_pengelola'] = $id_pengelola;
            $dataValues['alamat_lapangan'] = $alamat_lapangan;
            $dataValues['maps'] = $maps;
            $tgl_buat = date('Y-m-d H:i:s');
            $dataValues['created_at'] = $tgl_buat;

            $builderInserts = $this->db->table('futsal');
            $insertDatas =  $builderInserts->insert($dataValues);

            if ($insertDatas) {
                $success = true;
                $message = 'Berhasil Mengambil Data';
            } else {
                $success = false;
                $message = 'Gagal Mengambil Data, silahkan coba kembali';
            }
        } else {
            $success = false;
            $message = 'BUKAN ADMIN, silahkan coba kembali';
        }


        $output['success'] = $success;
        $output['message'] = $message;

        return $this->response->setJSON($output);
    }

    public function get_list_futsal()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');
        $jumlah_lapangan = $this->request->getPost('jumlah_lapangan');
        $id_pengelola = $this->request->getPost('id_pengelola');
        $alamat_lapangan = $this->request->getPost('alamat_lapangan');
        $maps = $this->request->getPost('maps');
        $builderUsers = $this->db->table('users');
        $builderUsers->where(['email' => $email])->select('*');
        $queryUsers    =  $builderUsers->get();

        $rowUsers = $queryUsers->getRowArray();

        if ($rowUsers['roles'] == 0) {
            $dataValues['name'] = $name;
            $dataValues['jumlah_lapangan'] = $jumlah_lapangan;
            $dataValues['id_pengelola'] = $id_pengelola;
            $dataValues['alamat_lapangan'] = $alamat_lapangan;
            $dataValues['maps'] = $maps;
            $tgl_buat = date('Y-m-d H:i:s');
            $dataValues['created_at'] = $tgl_buat;

            $builderInserts = $this->db->table('futsal');
            $insertDatas =  $builderInserts->insert($dataValues);

            if ($insertDatas) {
                $success = true;
                $message = 'Berhasil Mengambil Data';
            } else {
                $success = false;
                $message = 'Gagal Mengambil Data, silahkan coba kembali';
            }
        } else {
            $success = false;
            $message = 'BUKAN ADMIN, silahkan coba kembali';
        }


        $output['success'] = $success;
        $output['message'] = $message;

        return $this->response->setJSON($output);
    }
}
