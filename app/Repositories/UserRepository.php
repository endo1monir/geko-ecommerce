<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function getAdmins()
    {
        return $this->model->role('admin')->get();
    }

    public function getCustomers()
    {
        return $this->model->role('customer')->get();
    }
}
