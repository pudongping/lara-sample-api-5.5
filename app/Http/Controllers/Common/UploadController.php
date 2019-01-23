<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\UploadRequest;
use App\Models\Code;
use App\Exceptions\ApiException;

class UploadController extends Controller
{

    public function __construct()
    {
    }

    public function postPic(UploadRequest $request){
        $storagePath = storage_path().'/app/';

        // public文件夹下面uploads/xxxx-xx-xx 建文件夹
        $destinationPath = 'upload/' . date('Y-m-d');
        if($request->hasFile('pic') && $request->file('pic')->isValid()){
            $file = $request->file('pic');
            // 上传文件后缀
            $extension = $file->getClientOriginalExtension();
            // 重命名
            $fileName = date('His') . mt_rand(100, 999) . '.' . $extension;
            $file->move($storagePath . $destinationPath, $fileName);
            $url = config("app.web_url")."/$destinationPath/$fileName";
            return $this->response->send(["url" => $url]);
        }else{
            throw new ApiException(Code::ERR_FILE_UP_LOAD);
        }
    }


}
