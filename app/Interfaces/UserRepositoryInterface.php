<?php
namespace App\Interfaces;
use App\Interfaces\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface {
    public function getAdmins();
    public function getCustomers();
}