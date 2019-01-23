<?php

if(!function_exists('isMobile')){
    /**
     * 用正则表达式验证手机号码(中国大陆区)
     * @param integer $mobile    所要验证的手机号
     * @return boolean
     */
    function isMobile($mobile) {
        if (!$mobile) {
            return false;
        }
        return preg_match('/^1[34578]\d{9}$/', $mobile) ? true : false;
    }
}

if(!function_exists('checkCreateDir')) {
    function checkCreateDir($dir) {
        if(!is_dir($dir)) {
            return @mkdir($dir, 0777, true);
        }
        return true;
    }
}