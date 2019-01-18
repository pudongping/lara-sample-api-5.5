<?php
/**
 * User: alex
 * Date: 2019-1-17
 */

namespace App\Support;


class Response{

    /**
     * 错误号
     * @var int
     */
    public $code = 0;

    /**
     * 提示信息
     * @var
     */
    public $msg;

    /**
     * 异常
     * @var
     */
    public $exception;

    /**
     * 数据
     * @var
     */
    public $data;

    /**
     * 元信息
     * @var array
     */
    public $meta = [];

    /**
     * 详情
     * @var
     */
    public $detail;

    /**
     * 时间
     * @var
     */
    public $time;

    /**
     * transformer 的名称
     * @var
     */
    public $transformerName;

    /**
     * 头部代码
     * @var
     */
    public $headerCode;

    /**
     * 输出内容
     * @var
     */
    private $_output;






}