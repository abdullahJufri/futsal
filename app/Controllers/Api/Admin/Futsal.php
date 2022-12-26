<?php

namespace App\Controllers\api\admin;

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

    public function insert()
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

    public function list()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $id = $this->request->getPost('id');

        $builder_futsal_admin = $this->db->table('futsal');
        $builder_futsal_admin->where('futsal.id_pengelola', $id);
        $builder_futsal_admin->select('*');
        $query_futsal_admin    =  $builder_futsal_admin->get();
        $row_futsal_admin = $query_futsal_admin->getRowArray();


        if ($row_futsal_admin['id_pengelola'] == $id) {
            if ($query_futsal_admin->getNumRows() > 0) {
                $success = true;
                $message = 'Berhasil mengambil data';
                $data_futsal_admin = $query_futsal_admin->GetResultArray();
            } else {
                $success = true;
                $message = 'Gagal Mengambil list, silahkan coba kembali';
                $data_futsal_admin = [];
            }
        } else {
            $success = false;
            $message = 'BUKAN ADMIN, silahkan coba kembali';
        }


        $output['success'] = $success;
        $output['message'] = $message;
        $output['data'] = $data_futsal_admin;

        return $this->response->setJSON($output);
    }
}
