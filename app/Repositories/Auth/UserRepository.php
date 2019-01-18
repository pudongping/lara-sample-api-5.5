<?php

namespace App\Repositories\Auth;

use App\Repositories\BaseRepository;
use App\Models\Auth\User;

class UserRepository extends BaseRepository{

    protected $model;

    public function __construct(User $userModel)
    {
        $this->model = $userModel;
    }


}