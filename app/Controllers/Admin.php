<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->users->findAll();

        return view('admin/index', $data);
    }
}

