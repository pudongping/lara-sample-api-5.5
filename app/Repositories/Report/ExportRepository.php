<?php
/**
 * User: alex
 * Date: 2019-1-23
 * https://phpspreadsheet.readthedocs.io/en/develop/
 */

namespace App\Repositories\Report;

use App\Repositories\BaseRepository;
use Log;
use App\Exceptions\ApiException;
use App\Models\Code;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class ExportRepository extends BaseRepository{

    const PATH = 'app/export';

    public function __construct()
    {
    }

    public function saveReport($fileName, $data, $titles){
        $path = storage_path(self::PATH) . date("Y-m-d") . "/";
        if(!checkCreateDir($path)){
            Log::error("can't create dir: $path");
            throw new ApiException(Code::ERR_EXPORT);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $rowIdx = 1;
        $colIdx = 0;
        foreach ($titles as $title => $v){
            $colIdx++;

            // 写入第一行数据（列，行，值）
//            $sheet->setCellValueByColumnAndRow($colIdx , $rowIdx, $title);

            foreach ($data as $rowNumber => $value){
                if(isset($value[$title])){
                    $sheet->setCellValueByColumnAndRow($colIdx , $rowIdx + $rowNumber + 1, $value[$title]);
                }
            }

        }

        // 导出表格
        $writer = new Xlsx($spreadsheet);

        $writer->save($path . $fileName);
        return $path . $fileName;
    }




}