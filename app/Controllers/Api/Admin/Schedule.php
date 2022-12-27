<?php

namespace App\Controllers\api\admin;

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

    public function list()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $id_futsal = $this->request->getPost('id_futsal');
        $id_lapangan = $this->request->getPost('id_lapangan');
        $tanggal = $this->request->getPost('tanggal');
        // $jam = $this->request->getPost('jam');


        $builder_list_schedule = $this->db->table('schedule');
        $builder_list_schedule->select('schedule.id,tanggal,jam,id_futsal,id_lapangan, f.name as nama_futsal,  l.id as id_lapangan,l.nama_lapangan, status,schedule.created_at');
        $builder_list_schedule->where('id_futsal', $id_futsal, 'id_lapangan', $id_lapangan);
        $builder_list_schedule->where('id_lapangan', $id_lapangan);
        $builder_list_schedule->where('tanggal', $tanggal);
        // $builder_list_schedule->select('l.id as id_lapangan,l.nama_lapangan,');

        $builder_list_schedule->join('futsal f', 'f.id = schedule.id_futsal', 'left');
        $builder_list_schedule->join('lapangan l', 'l.id = schedule.id_lapangan', 'left');

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
}
