<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Support\GValue;
use App\Models\Code;
use App\Http\Requests\Auth\UserRequest;
use App\Repositories\Auth\UserRepository;

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

    public function getTest(Request $request){
        $validated = $request->validated();
        dump($validated);die;
        Code::setCode(Code::ERR_PARAMS,null,['5']);
        dump(Code::getCode());
    }

    public function getMenu(){
        return GValue::$controller;
    }


    public function getList(){

    }

    public function postAdd(UserRequest $userRequest){
        dump($userRequest);

    }



}
