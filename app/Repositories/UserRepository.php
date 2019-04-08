<?php
namespace App\Repositories;
use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(UserRepository $model)
    {
        $this->model=$model;
    }
}