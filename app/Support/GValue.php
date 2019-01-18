<?php

/**
 * 保存临时变量
 * User: alex
 * Date: 2019-1-17
 */

namespace App\Support;

class GValue {

    /**
     * page/ajax
     * @var $ajax
     */
    public static $ajax;

    /**
     * HTTP请求方式：GET/POST
     * @var $httpMethod
     */
    public static $httpMethod;

    /**
     * 菜单
     * @var $menu
     */
    public static $menu;

    /**
     * 是否调试
     * @var $debug
     */
    public static $debug;

    /**
     * 分页信息
     * @var $pageInfo
     */
    public static $pageInfo;

    /**
     * 控制器
     * @var $controller;
     */
    public static $controller;

    /**
     * 方法
     * @var $action
     */
    public static $action;

    /**
     * page
     * @var $page
     */
    public static $page;

    /**
     * nopage 指定不分页
     * @var $nopage
     */
    public static $nopage;

    /**
     * 分页每页显示数量
     * @var $perPage
     */
    public static $perPage;

    /**
     * @var
     */
    public static $orderBy;

    /**
     * @var
     */
    public static $user;

    /**
     * 当前数据库
     * @var
     */
    public static $currentDB;

    /**
     * 内存缓存
     * @var array
     */
    public static $cache = [];


    public static function setCache($key, $value, $group = null){

        if(!empty($group)){
            if(!isset(self::$cache[$group])){
                self::$cache[$group] = [];
            }
            self::$cache[$group][$key] = $value;
        }else{
            self::$cache[$key] = $value;
        }

        return false;
    }

    public static function getCache($key, $group = null){

        if(!empty($group)){
            if(!isset(self::$cache[$group])){
                return false;
            }
            if(!isset(self::$cache[$group][$key])){
                return false;
            }
            return self::$cache[$group][$key];
        }else{
            if(!isset(self::$cache[$key])){
                return false;
            }
            return self::$cache[$key];
        }

    }



}
