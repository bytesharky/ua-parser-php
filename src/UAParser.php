<?php
/////////////////////////////////////////////////////////////////////////////////
/* UAParser.php v1.1.34
/* 版权所有 © frogot fish <fish@doffish.com>
/* MIT License *//*
/* 从用户代理数据中检测浏览器、引擎、操作系统、CPU 和设备类型/型号。
/* 源：https://github.com/talefish/ua-parser-php
/*
/* 此代码改编自UAParser.js v1.1.34，感谢源作者及其他114位贡献者
/* 源：https://github.com/faisalman/ua-parser-js
*/////////////////////////////////////////////////////////////////////////////////

namespace  frogotfish\UAParser;

require_once('Constants.php');
require_once('Regex.map.php');
require_once('Helper.php');


//基类
#[\AllowDynamicProperties]
class BaseClass implements \arrayaccess{
    //以下是实现接口，数组式访问属性
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->$offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->$offset) ? $this->$offset : null;
    }

    public function offsetSet(mixed $offset , mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }
}

//解析器
#[\AllowDynamicProperties]
class UAParser extends BaseClass{

    public function __construct(mixed $uastring = false, mixed $extensions = false){
        $Regexmap = Regexmap::$Regexmap;

        if(is_array($uastring)){
            $extensions = $uastring;
            $uastring = false;
        }
        $this[VERSION] = LIBVERSION;
        $this->uastring = ($uastring)?$uastring:$_SERVER['HTTP_USER_AGENT'];
        $this->regexmap = $extensions ? extend($Regexmap, $extensions) : $Regexmap;

    }

    public function getUA(mixed $default = false){
        return ($default)? $_SERVER['HTTP_USER_AGENT'] : $this->uastring;
    }

    public function setUA(mixed $uastring){
        return $this->uastring = $uastring;
    }

    public function getip() {
        static $ip = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
    
    // public methods
    public function getBrowser () {
        $browser = new UAItem([NAME, VERSION], [[NAME], '/\s?browser$/i']);
        rgxMapper($browser, $this->uastring, $this->regexmap['browser']);
        $browser[MAJOR] = majorize($browser[VERSION]);
        return $browser;
    }

    public function getCPU() {
        $cpu = new UAItem([ARCHITECTURE], [[ARCHITECTURE]]);
        rgxMapper($cpu, $this->uastring, $this->regexmap['cpu']);
        return $cpu;
    }
    
    public function getDevice() {
        $device = new UAItem([VENDOR, MODEL], [[TYPE, MODEL, VENDOR]]);
        rgxMapper($device, $this->uastring, $this->regexmap['device']);

        return $device;
    }
    
    public function getEngine() {
        $engine = new UAItem([NAME, VERSION], [[NAME]]);
        rgxMapper($engine, $this->uastring, $this->regexmap['engine']);
        return $engine;
    }
    
    public function getOS() {
        $os = new UAItem([NAME, VERSION], [[NAME], '/\s?os$/i']);
        rgxMapper($os, $this->uastring, $this->regexmap['os']);
        return $os;
    }

    public function getNet() {
        $netregex = [['/nettype\/([[0-9a-z]+)/i'],["nettype"]];
        $net = new UAItem(["nettype"], [["nettype"]]);
        rgxMapper($net, $this->uastring, $netregex);
        return $net;
    }

    public function getResult() {
        return new UAResult($this);
    }
    
    public function __debugInfo()
    {
        $properties['ua']  = $this->uastring;
        return $properties;
    }
}

//子项
#[\AllowDynamicProperties]
class UAItem  extends BaseClass{
    public function __construct(mixed $propToString = [], mixed $propIs = []){
        $this->propToString = $propToString;
        $this->propIs = $propIs[0]??false;
        $this->rgxIs  = $propIs[1]??false;
    }

    public function is(mixed $strCheck){
        if (!$strCheck) return false;
        $is = false;
        foreach ($this->propIs as $v) {
            if (sanitize($this->$v??"", $this->rgxIs) == sanitize($strCheck, $this->rgxIs)) {
                $is = true;
                break;
            }
        }
        return $is;
    }

    public function toString(mixed $default = false) {
        $str = '';
        foreach ($this->propToString as $v) {
            if (isset($this->$v)) {
                $str .= ($str ? ' ' : '') . $this->$v;
            }
        }
        return $str ? $str : $default;
    }

    public function __debugInfo()
    {
        $properties = [];
        foreach ($this->propToString as $v) {
            if (isset($this->$v)) {
                $properties[$v]  = $this->$v;
            }else{
                $properties[$v] = EMPTY_;
            }
        }
        return $properties;
    }    
}

//结果集合
#[\AllowDynamicProperties]
class UAResult{

    public function __construct(mixed $uap){

        $this->ua = $uap->getUA();
        $this->browser = $uap->getBrowser();
        $this->cpu = $uap->getCPU();
        $this->device = $uap->getDevice();
        $this->engine = $uap->getEngine();
        $this->os = $uap->getOS();
        $this->net = $uap->getNet();

    }
}
