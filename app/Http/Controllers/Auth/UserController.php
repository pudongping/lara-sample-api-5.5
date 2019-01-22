<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\UserRequest;
use App\Models\Code;
use App\Exceptions\ApiException;

class UserController extends Controller
{

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;

//        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Auth\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * 用户列表（显示transformer全部字段）
     *
     * @param UserRequest $request
     * @return mixed
     */
    public function getList(UserRequest $request){
        $data = $this->userRepository->getList($request);
        return $this->response->send($data);
    }

    /**
     * 新增用户
     *
     * @param UserRequest $request
     * @return mixed
     * @throws ApiException
     */
    public function postAdd(UserRequest $request){
        $data = $this->userRepository->postAdd($request);
        return $this->response->send($data);
    }

    /**
     * 编辑用户显示页面（只显示用户的id、name字段）
     *
     * @param UserRequest $request
     * @return mixed
     */
    public function getEdit(UserRequest $request){
        $item = $this->userRepository->getEdit($request);
        return $this->response->send($item,['id','name']);
    }






}
