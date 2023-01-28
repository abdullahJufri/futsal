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
        $builder = $this->db->table('users');
        $builder->where(['email' => $email])->select('*');
        $query =  $builder->get();

        $rowUsers = $query->getRowArray();

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

        $id_pengelola = $this->request->getPost('id_pengelola');


        $builder = $this->db->table('futsal');
        $builder->where('futsal.id_pengelola', $id_pengelola);
        $builder->select('*,id as id_futsal');
        $query    =  $builder->get();


        if ($query->getNumRows() > 0) {
            $success = true;
            $message = 'Berhasil mengambil data';
            $data_futsal_admin = $query->GetRowArray();
        } else {
            $success = true;
            $message = 'Gagal Mengambil list, silahkan coba kembali';
            $data_futsal_admin = [];
        }


        $output['success'] = $success;
        $output['message'] = $message;
        $output['data'] = $data_futsal_admin;

        return $this->response->setJSON($output);
    }

    public function update()
    {
        $success = false;
        $message = 'Gagal Proses Data';
        $id_pengelola = $this->request->getPost('id_pengelola');
        $alamat_lapangan = $this->request->getPost('alamat_lapangan');
        $jumlah_lapangan = $this->request->getPost('jumlah_lapangan');
        $harga_pagi = $this->request->getPost('harga_pagi');
        $harga_malam = $this->request->getPost('harga_malam');

        $builder = $this->db->table('futsal');
        $builder->select('*');
        $builder->where('id_pengelola', $id_pengelola);
        $data1 = [
            'jumlah_lapangan' => $jumlah_lapangan,
            'alamat_lapangan' => $alamat_lapangan,
            'harga_pagi' => $harga_pagi,
            'harga_malam' => $harga_malam,

        ];
        $builder->update($data1);

        $query    =  $builder->get();

        // $builder_list_futsal->join('lapangan l', 'l.id_jumlah_lapangan = futsal.jumlah_lapangan', 'left');
        if ($query->getNumRows() > 0) {
            $dataValues['jumlah_lapangan'] = $jumlah_lapangan;
            $dataValues['harga_pagi'] = $harga_pagi;
            $dataValues['harga_malam'] = $harga_malam;
            $success = true;
            $message = 'Berhasil Update';
        } else {
            $success = true;
            $message = 'Gagal Update, silahkan coba kembali';
        }



        $output['success'] = $success;
        $output['message'] = $message;


        return $this->response->setJSON($output);
    }
}
