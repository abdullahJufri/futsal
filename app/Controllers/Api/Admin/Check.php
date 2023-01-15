<?php

namespace App\Controllers\api\admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Check extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
    }


    public function list()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $order_id = $this->request->getPost('order_id');
        $id_futsal = $this->request->getPost('id_futsal');
        // $id_futsal = $this->request->getPost('id_futsal');
        // $id_lapangan = $this->request->getPost('id_lapangan');
        // $tanggal = $this->request->getPost('tanggal');
        // $tanggal = $this->request->getPost('tanggal');
        // $jam = $this->request->getPost('jam');


        $builder = $this->db->table('schedule');
        // $builder->select('schedule.id,tanggal,jam,id_futsal,id_lapangan, f.name as nama_futsal,  l.id as id_lapangan,l.nama_lapangan, status,schedule.created_at');
        $builder->select('schedule.*,f.name, l.nama_lapangan, u.name as nama_user');
        $builder->where('id_futsal', $id_futsal);
        $builder->where('order_id', $order_id);
        $builder->orderBy('schedule.created_at', 'DESC');
        $builder->join('futsal f', 'f.id = schedule.id_futsal', 'left');
        $builder->join('lapangan l', 'l.id = schedule.id_lapangan', 'left');
        $builder->join('users u', 'u.id = schedule.id_user', 'left');

        $query    =  $builder->get();




        if ($query->getNumRows() > 0) {
            $success = true;
            $message = 'Berhasil mengambil list';
            $data = $query->getRowArray();
        } else {
            $success = false;
            $message = 'Invalid atau terjadi kesalahan, silahkan coba kembali';
            $data = null;
        }



        $output['success'] = $success;
        $output['message'] = $message;
        $output['data'] = $data;

        return $this->response->setJSON($output);
    }

    public function insert()
    {
        $success = false;
        $message = 'Gagal Proses Data';
        $order_id = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');

        $builder = $this->db->table('schedule');
        $builder->select('schedule.order_id, schedule.status');
        $builder->where('order_id', $order_id);
        $data1 = [
            'status' => $status,

        ];
        $builder->update($data1);

        $query    =  $builder->get();

        // $builder_list_futsal->join('lapangan l', 'l.id_jumlah_lapangan = futsal.jumlah_lapangan', 'left');
        if ($query->getNumRows() > 0) {
            $dataValues['status'] = $status;
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



    // public function insert()
    // {
    //     $success = false;
    //     $message = 'Gagal Proses Data';

    //     $id_futsal = $this->request->getPost('id_futsal');
    //     $id_lapangan = $this->request->getPost('id_lapangan');
    //     $tanggal = $this->request->getPost('tanggal');
    //     $jam = $this->request->getPost('jam');


    //     $builder = $this->db->table('schedule');
    //     $builder->select('schedule.id,tanggal,jam,id_futsal,id_lapangan, f.name as nama_futsal,  l.id as id_lapangan,l.nama_lapangan, status,schedule.created_at');
    //     $builder->where('id_futsal', $id_futsal,);
    //     $builder->where('id_lapangan', $id_lapangan);
    //     $builder->where('tanggal', $tanggal,);

    //     $builder->join('futsal f', 'f.id = schedule.id_futsal', 'left');
    //     $builder->join('lapangan l', 'l.id = schedule.id_lapangan', 'left');

    //     $query =  $builder->get();


    //     if (empty($query->getNumRows())) {
    //         $dataValues['email'] = $email;
    //         $dataValues['password'] = md5($password);
    //         $dataValues['name'] = $name;
    //         $dataValues['phone'] = $phone;
    //         $dataValues['roles'] = $roles;
    //         $tgl_buat = date('Y-m-d H:i:s');
    //         $dataValues['created_at'] = $tgl_buat;

    //         $builderInserts = $this->db->table('users');
    //         $insertDatas =  $builderInserts->insert($dataValues);

    //         if ($insertDatas) {
    //             $success = true;
    //             $message = 'Berhasil Melakukan Registrasi, silahkan login';
    //         } else {
    //             $success = false;
    //             $message = 'Gagal Melakukan Registrasi, silahkan coba kembali';
    //         }
    //     } else {
    //         $message = 'Akun Sudah Terdaftar, silahkan coba kembali';
    //     }


    //     if ($query->getNumRows() > 0) {
    //         $success = true;
    //         $message = 'Berhasil mengambil list';
    //         $data = $query->GetResultArray();
    //     } else {
    //         $success = true;
    //         $message = 'Gagal Mengambil list, silahkan coba kembali';
    //         $data = [];
    //     }



    //     $output['success'] = $success;
    //     $output['message'] = $message;
    //     $output['data'] = $data;

    //     return $this->response->setJSON($output);
    // }

    // public function list2()
    // {
    //     $success = false;
    //     $message = 'Gagal Proses Data';

    //     $tanggal = $this->request->getPost('tanggal');
    //     $jam = $this->request->getPost('jam');
    //     $id_futsal = $this->request->getPost('id_futsal');
    //     $id_lapangan = $this->request->getPost('id_lapangan');

    //     $builder_list_schedule = $this->db->table('schedule');
    //     $builder_list_schedule->select('schedule.id,tanggal,jam,id_futsal,id_lapangan, f.name as nama_futsal,  l.id as id_lapangan,l.nama_lapangan, status,schedule.created_at');
    //     // $builder_list_schedule->select('l.id as id_lapangan,l.nama_lapangan,');

    //     $builder_list_schedule->join('futsal f', 'f.id = schedule.id_futsal', 'left');
    //     $builder_list_schedule->join('lapangan l', 'l.id = schedule.id_lapangan', 'left');

    //     $query_list_futsal    =  $builder_list_schedule->get();




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
