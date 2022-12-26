<?php

namespace App\Controllers\api\admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
    }

    public function registration()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $phone = $this->request->getPost('phone');
        $name = $this->request->getPost('name');
        $roles = $this->request->getPost('roles');

        $builderUsers = $this->db->table('users');
        $builderUsers->where(['email' => $email,]);
        $queryUsers    =  $builderUsers->get();

        if (empty($queryUsers->getNumRows())) {
            $dataValues['email'] = $email;
            $dataValues['password'] = md5($password);
            $dataValues['name'] = $name;
            $dataValues['phone'] = $phone;
            $dataValues['roles'] = $roles;
            $tgl_buat = date('Y-m-d H:i:s');
            $dataValues['created_at'] = $tgl_buat;

            $builderInserts = $this->db->table('users');
            $insertDatas =  $builderInserts->insert($dataValues);

            if ($insertDatas) {
                $success = true;
                $message = 'Berhasil Melakukan Registrasi, silahkan login';
            } else {
                $success = false;
                $message = 'Gagal Melakukan Registrasi, silahkan coba kembali';
            }
        } else {
            $message = 'Akun Sudah Terdaftar, silahkan coba kembali';
        }

        $output['success'] = $success;
        $output['message'] = $message;

        return $this->response->setJSON($output);
    }

    public function login()
    {
        $success = false;
        $message = 'Gagal Proses Data';

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $builderUsers = $this->db->table('users');
        $builderUsers->where(['email' => $email, 'password' => md5($password)])->select('*');
        $queryUsers    =  $builderUsers->get();

        if ($queryUsers->getNumRows() > 0) {
            $success = true;
            $message = 'Berhasil melakukan login';
            $data_user = $queryUsers->getRowArray();
        } else {
            $success = true;
            $message = 'Kombinasi email dan password salah, silahkan coba kembali';
            $data_user = [];
        }

        $output['success'] = $success;
        $output['message'] = $message;
        $output['data'] = $data_user;

        return $this->response->setJSON($output);
    }
}
