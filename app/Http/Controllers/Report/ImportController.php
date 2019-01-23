<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Code;

class ImportController extends Controller
{

    public function __construct()
    {
    }

    /**
     * 上传 Excel 表格
     *
     * @param Request $request
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function postUpload(Request $request){
        $file = $request->file('filename');
        $realPath = $file->getRealPath();
        $spreadsheet = IOFactory::load($realPath);
        $current = $spreadsheet->getActiveSheet();
        $allColumn = $current->getHighestColumn();
        if(strlen($allColumn) >= 3) {
            Code::setCode(Code::ERR_EXCEL_COLUMN);
            return $this->response->send();
        }
        // excel 表中所有内容
        $content = $current->toArray();
        dump($content);
    }


}
