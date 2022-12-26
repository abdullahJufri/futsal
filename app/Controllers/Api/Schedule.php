<?php

namespace App\Controllers\api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Schedule extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
    }

    // public function insert_futsal()
    // {
    //     $success = false;
    //     $message = 'Gagal Proses Data';

    //     $email = $this->request->getPost('email');
    //     $name = $this->request->getPost('name');
    //     $jumlah_lapangan = $this->request->getPost('jumlah_lapangan');
    //     $id_pengelola = $this->request->getPost('id_pengelola');
    //     $alamat_lapangan = $this->request->getPost('alamat_lapangan');
    //     $maps = $this->request->getPost('maps');
    //     $builderUsers = $this->db->table('users');
    //     $builderUsers->where(['email' => $email])->select('*');
    //     $queryUsers    =  $builderUsers->get();

    //     $rowUsers = $queryUsers->getRowArray();

    //     if ($rowUsers['roles'] == 0) {
    //         $dataValues['name'] = $name;
    //         $dataValues['jumlah_lapangan'] = $jumlah_lapangan;
    //         $dataValues['id_pengelola'] = $id_pengelola;
    //         $dataValues['alamat_lapangan'] = $alamat_lapangan;
    //         $dataValues['maps'] = $maps;
    //         $tgl_buat = date('Y-m-d H:i:s');
    //         $dataValues['created_at'] = $tgl_buat;

    //         $builderInserts = $this->db->table('futsal');
    //         $insertDatas =  $builderInserts->insert($dataValues);

    //         if ($insertDatas) {
    //             $success = true;
    //             $message = 'Berhasil Mengambil Data';
    //         } else {
    //             $success = false;
    //             $message = 'Gagal Mengambil Data, silahkan coba kembali';
    //         }
    //     } else {
    //         $success = false;
    //         $message = 'BUKAN ADMIN, silahkan coba kembali';
    //     }


    //     $output['success'] = $success;
    //     $output['message'] = $message;

    //     return $this->response->setJSON($output);
    // }

    public function get_list_schedule()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $builder_list_schedule = $this->db->table('schedule');

        $builder_list_schedule->select('*,  l.id as id_lapangan,l.nama_lapangan, f.harga_pagi, f.harga_malam, f.jam_buka, f.jam_tutup,');
        $builder_list_schedule->join('futsal f', 'f.id = schedule.id_futsal', 'left');
        $builder_list_schedule->join('lapangan l', 'l.id_jumlah_lapangan = f.jumlah_lapangan', 'left');

        $query_list_futsal    =  $builder_list_schedule->get();




        if ($query_list_futsal->getNumRows() > 0) {
            $success = true;
            $message = 'Berhasil mengambil list';
            $data_list_futsal = $query_list_futsal->GetResultArray();
        } else {
            $success = true;
            $message = 'Gagal Mengambil list, silahkan coba kembali';
            $data_list_futsal = [];
        }



        $output['success'] = $success;
        $output['message'] = $message;
        $output['data'] = $data_list_futsal;

        return $this->response->setJSON($output);
    }

    // public function get_detail_futsal()
    // {
    //     $success = false;
    //     $message = 'Gagal Proses Data';

    //     $id = $this->request->getPost('id');

    //     $builder_list_futsal = $this->db->table('futsal');
    //     $builder_list_futsal->select('l.id as value, l.nama_lapangan as label');
    //     $builder_list_futsal->where('futsal.id', $id);
    //     $builder_list_futsal->join('lapangan l', 'l.id_jumlah_lapangan = futsal.jumlah_lapangan', 'left');



    //     $query_list_futsal    =  $builder_list_futsal->get();




    //     if ($query_list_futsal->getNumRows() > 0) {
    //         $success = true;
    //         $message = 'Berhasil mengambil list';
    //         $data_list_futsal = $query_list_futsal->GetResultArray();
    //     } else {
    //         $success = true;
    //         $message = 'Gagal Mengambil list, silahkan coba kembali';
    //         $data_list_futsal = [];
    //     }



    //     $output['success'] = $success;
    //     $output['message'] = $message;
    //     $output['data'] = $data_list_futsal;

    //     return $this->response->setJSON($output);
    // }

    // public function get_futsal_admin()
    // {
    //     $success = false;
    //     $message = 'Gagal Proses Data';

    //     $id = $this->request->getPost('id');

    //     $builder_futsal_admin = $this->db->table('futsal');
    //     $builder_futsal_admin->select('*');
    //     $query_futsal_admin    =  $builder_futsal_admin->get();
    //     $row_futsal_admin = $query_futsal_admin->getRowArray();


    //     if ($row_futsal_admin['id_pengelola'] == $id) {
    //         if ($query_futsal_admin->getNumRows() > 0) {
    //             $success = true;
    //             $message = 'Berhasil mengambil data';
    //             $data_futsal_admin = $query_futsal_admin->GetResultArray();
    //         } else {
    //             $success = true;
    //             $message = 'Gagal Mengambil list, silahkan coba kembali';
    //             $data_futsal_admin = [];
    //         }
    //     } else {
    //         $success = false;
    //         $message = 'BUKAN ADMIN, silahkan coba kembali';
    //     }


    //     $output['success'] = $success;
    //     $output['message'] = $message;
    //     $output['data'] = $data_futsal_admin;

    //     return $this->response->setJSON($output);
    // }
}
