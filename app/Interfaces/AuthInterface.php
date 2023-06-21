<?php

namespace App\Interfaces;

interface AuthInterface
{
    /**
     * Login Auth User
     * @param string $email
     * @param string $password
     */
    public function login($email, $password);

    /**
     * Register User
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function register($email, $name, $password);
}