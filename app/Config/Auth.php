<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use Myth\Auth\Config\Auth as BaseAuth;

class Auth extends BaseAuth
{
    /**
     * Views used by Auth Controllers
     * Override to use custom views
     */
    public $views = [
        'login'           => 'Auth/login',
        'register'        => 'Myth\Auth\Views\register',
        'forgot'          => 'Myth\Auth\Views\forgot',
        'reset'           => 'Myth\Auth\Views\reset',
        'emailForgot'     => 'Myth\Auth\Views\emails\forgot',
        'emailActivation' => 'Myth\Auth\Views\emails\activation',
    ];
}

