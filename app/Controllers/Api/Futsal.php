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

    public function list()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        if ($this->request->getPost('id')) {
            $id = $this->request->getPost('id');
            $builder_list_futsal = $this->db->table('futsal');
            $builder_list_futsal->where('futsal.id', $id);

            // $builder_list_futsal->join('lapangan l', 'l.id_jumlah_lapangan = futsal.jumlah_lapangan', 'left');

            $query_list_futsal    =  $builder_list_futsal->get();
            if ($query_list_futsal->getNumRows() > 0) {
                $success = true;
                $message = 'Berhasil mengambil list';
                $data_list_futsal = $query_list_futsal->GetResultArray();
            } else {
                $success = true;
                $message = 'Gagal Mengambil list, silahkan coba kembali';
                $data_list_futsal = [];
            }
        } else {
            $builder_list_futsal = $this->db->table('futsal');
            $query_list_futsal    =  $builder_list_futsal->get();

            if ($query_list_futsal->getNumRows() > 0) {
                $success = true;
                $message = 'Berhasil mengambil list';
                $data_list_futsal = $query_list_futsal->GetResultArray();
            } else {
                $success = true;
                $message = 'Gagal Mengambil list, silahkan coba kembali';
                $data_list_futsal = [];
            }
        }

        $output['success'] = $success;
        $output['message'] = $message;
        $output['data'] = $data_list_futsal;

        return $this->response->setJSON($output);
    }

    // public function list2()
    // {
    //     $uri = new \CodeIgniter\HTTP\URI();
    //     $uri = service('uri');
    //     $success = false;
    //     $message = 'Gagal Proses Data';


    //     if ($this->$uri->segment('id')) {
    //         // $id = $this->request->getPost('id');
    //         $builder_list_futsal = $this->db->table('futsal');
    //         $builder_list_futsal->where('futsal.id', $id);

    //         // $builder_list_futsal->join('lapangan l', 'l.id_jumlah_lapangan = futsal.jumlah_lapangan', 'left');

    //         $query_list_futsal    =  $builder_list_futsal->get();
    //         if ($query_list_futsal->getNumRows() > 0) {
    //             $success = true;
    //             $message = 'Berhasil mengambil list';
    //             $data_list_futsal = $query_list_futsal->GetResultArray();
    //         } else {
    //             $success = true;
    //             $message = 'Gagal Mengambil list, silahkan coba kembali';
    //             $data_list_futsal = [];
    //         }
    //     } else {
    //         $builder_list_futsal = $this->db->table('futsal');
    //         $query_list_futsal    =  $builder_list_futsal->get();

    //         if ($query_list_futsal->getNumRows() > 0) {
    //             $success = true;
    //             $message = 'Berhasil mengambil list';
    //             $data_list_futsal = $query_list_futsal->GetResultArray();
    //         } else {
    //             $success = true;
    //             $message = 'Gagal Mengambil list, silahkan coba kembali';
    //             $data_list_futsal = [];
    //         }
    //     }

    //     $output['success'] = $success;
    //     $output['message'] = $message;
    //     $output['data'] = $data_list_futsal;

    //     return $this->response->setJSON($output);
    // }

    public function dd_lapangan()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $id = $this->request->getPost('id');

        $builder_list_futsal = $this->db->table('futsal');
        $builder_list_futsal->select('l.id as value, l.nama_lapangan as label');
        $builder_list_futsal->where('futsal.id', $id);
        $builder_list_futsal->join('lapangan l', 'l.id_jumlah_lapangan = futsal.jumlah_lapangan', 'left');
        $query_list_futsal    =  $builder_list_futsal->get();

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
}
