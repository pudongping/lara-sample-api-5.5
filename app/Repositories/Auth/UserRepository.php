<?php

namespace App\Repositories\Auth;

use App\Repositories\BaseRepository;
use App\Models\Auth\User;
use App\Models\Code;
use App\Exceptions\ApiException;
use Auth;

class UserRepository extends BaseRepository{

    protected $model;

    public function __construct(User $userModel)
    {
        $this->model = $userModel;
    }

    /**
     * 取当前用户的缩略信息
     *
     * @return User|null
     */
    public function getBasic(){
        $user = Auth::user();
        return $user;
    }

    public function getList($request){
       $search = $request->input('s');

       $model = $this->model->where(function ($query) use ($search) {
           if(!empty($search)){
               $query->orWhere('name', 'like', '%' . $search . '%');
               $query->orWhere('username', 'like', '%' . $search . '%');
               $query->orWhere('phone', 'like', '%' . $search . '%');
               $query->orWhere('email', 'like', '%' . $search . '%');
           }
       });

        if (false !== ($between = $this->searchTime($request))) {
            $model = $model->whereBetween("created_at", $between);
        }

       return $this->usePage($model);
    }

    public function postAdd($request){
        $data = $request->input();
        if(!isMobile($data['phone'])) throw new ApiException(Code::ERR_PARAMS, ['phone']);
        $data['password'] = bcrypt($data['password']);
        return $this->store($data);
    }

    public function getEdit($request){
        $id = $request->query('id');
        $user = $this->getById(intval($id));
        return $user;
    }


}