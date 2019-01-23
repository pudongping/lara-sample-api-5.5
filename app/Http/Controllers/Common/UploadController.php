<?php
/**
 * User: alex
 * Date: 2018-1-23
 * 二维码：https://github.com/SimpleSoftwareIO/simple-qrcode
 */

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\UploadRequest;
use App\Models\Code;
use App\Exceptions\ApiException;
use Log;
use QrCode;

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

    public function getQrCode(){

        $storagePath = storage_path(\ConstInc::QR_PATH);
        if(!checkCreateDir($storagePath)){
            Log::error("can't create dir $storagePath");
            throw new ApiException(Code::ERR_QRCODE);
        }

        $toUrl = 'www.drling.xin';
        // logo 图，目前只支持 png 格式
        $logoPath = $storagePath . 'logo.png';
        // 二维码最终存储的位置
        $codePath = $storagePath . date('His') . mt_rand(10, 99) . '.png';
        // format()自定义输出图片格式 <必须是第一个设置（见官方文档）>  size()尺寸设置
        $code = QrCode::format('png')->size(100)
                                    // 颜色设置
                                     ->color(255,0,255)
                                    // 边距设置
                                     ->margin(0)
                                    // 容错级别 H 最高
                                     ->errorCorrection('H')
                                    // 二维码加 logo 图，且logo图占二维码的30%，第三个参数为true时logo路径采用绝对路径
                                     ->merge($logoPath, .3, true)
                                    // 需要转换成二维码的 url， 二维码图片保存的路径
                                     ->generate($toUrl, $codePath);
        $blob = file_get_contents($codePath);
        // 删除图片
        unlink($codePath);
        return base64_encode($blob);
    }


}
