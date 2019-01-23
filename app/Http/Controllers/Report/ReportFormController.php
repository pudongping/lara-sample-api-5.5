<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Code;
use App\Exceptions\ApiException;
use Response;
use App\Repositories\Report\ExportRepository;


class ReportFormController extends Controller
{

    protected $exportRepository;

    public function __construct(ExportRepository $exportRepository)
    {
        $this->exportRepository = $exportRepository;
    }


    public function getAllTables(){
        // 查询出所有的数据表
        $tables = DB::select("show tables");
        if(empty($tables)) throw new ApiException(Code::ERR_MODEL);
        // 数据表所对应的数据库
        $tablesInBases = array_first($tables);
        $tableIn = array_keys((array)$tablesInBases)[0];

        $array = [];
        $new = [];

        $titles = [
            "Field" => '字段',
            "Type" => '属性',
            "Collation" => '字符集',
            "Null" => '是否为空',
            "Key" => '自增主键',
            "Default" => '默认值',
            "Extra" => '自动递增',
            "Privileges" => '权限',
            "Comment" => '备注',
        ];

        foreach ($tables as $k => $v){
            // 所有的表名称
            $tableName = $v->$tableIn;
            // 查看表中注释
            $comments = Db::select("show full columns from $tableName");
            // 强制将对象转换成数组
            foreach ($comments as &$value){
                $value = (array)$value;
            }
            // excel 表处理默认值
            $new[0] = [
                "Field" => $tableName . "表",
                "Type" => '',
                "Collation" => '',
                "Null" => '',
                "Key" => '',
                "Default" => '',
                "Extra" => '',
                "Privileges" => '',
                "Comment" => '',
            ];
            $new[1] = $titles;
            $comments = array_merge($new,$comments);
            $array[$tableName] = $comments;
        }

        // 三层数组转换成二层数组
        $data = array_reduce($array,"array_merge",array());

        $fileName = $tableIn . "数据表-" . date("Y-m-d H:i:s").".xlsx";

        $filePath = $this->exportRepository->saveReport($fileName, $data, $titles);

        $headers = array(
            'Content-Type: application/vnd.ms-excel',
        );

        // 下载 Excel 表
        return Response::download($filePath, $fileName, $headers);

    }





}
