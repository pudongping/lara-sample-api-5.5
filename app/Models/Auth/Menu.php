<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = [
        'pid',
        'name',
        'path',
        'icon',
        'category_id',
        'status'
    ];

    public $timestamps = false;


    public function getList($pids = []){
        if(empty($pids)){
            return $this->where('pid', '=', 0)->where('status', 1)->get();
        }else{
            return $this->whereIn('pid', $pids)->where('status', 1)->get();
        }
    }



}
