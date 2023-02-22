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

///////////
// Helper
//////////
function extend($regexes, $extensions) {
	$mergedRegexes = [];
	foreach ($regexes as $key=>$val) {
		if (isset($extensions[$key]) && count($extensions[$key]) % 2 === 0) {
			$mergedRegexes[$key] = array_merge($extensions[$key], $regexes[$key]);
		} else {
			$mergedRegexes[$key] = $regexes[$key];
		}
	}
	return $mergedRegexes;
}

function enumerize($arr) {
	$enums = [];
	for ($i=0; $i<count($arr); $i++) {
		$enums[strtoupper($arr[$i])] = $arr[$i];
	}
	return $enums;
}

function has($str1, $str2) {
	return is_string($str1)? is_int(strripos($str2, $str1)) : false;
}

function lowerize($str) {
	return is_string($str)? strtolower($str) : false;
}

function majorize($version) {
	return is_string($version)? explode(".", preg_replace('/[^\d\.]/', EMPTY_, $version))[0] : false;
}

function sanitize ($str, $rgx) {

    if (!$rgx) return lowerize($str);

    $pos = strripos($rgx,"/");
    $allmode = is_int(strripos(is_int($pos)?substr($rgx,$pos):"", "g"));
    if ($allmode){
        //PHP正则不支持/g，所以这里特殊处理一下
        //第四个参数默认值-1是替换全部
        $mode = str_replace("g", "", substr($rgx,$pos));
        $rgx = substr($rgx,0,$pos).$mode;
        return preg_replace($rgx, EMPTY_, lowerize($str));
    }else{
        //第四个参数1是替换一次
        return preg_replace($rgx, EMPTY_, lowerize($str), 1);
    }
}

function mytrim($str, $len) {
	if (is_string($str)) {
		$str = preg_replace('/^\s\s*/', EMPTY_, $str);
		$len = is_int($len)? $len : UA_MAX_LENGTH;
		$len = ($len >= 0)? $len : 0;
		$len = ($len <= UA_MAX_LENGTH)? $len : UA_MAX_LENGTH;
		return substr($str, 0, $len);
	}
}

function strMapper($str, $map) {

    foreach ($map as $k=>$i) {
        // check if current value is array
        if (is_array($i) && count($i) > 0) {
            for ($j = 0; $j < count($i); $j++) {
                if (has($i[$j], $str)) {
                    return ($k === UNKNOWN) ? false : $k;
                }
            }
        } else if (has($i, $str)) {
            return ($k === UNKNOWN) ? false : $k;
        }
    }
    return $str;
}


function rgxMapper($result, $ua, $arrays) {

    $i = 0; $j; $k; $p; $q;
    $matches = false; $match;
    // loop through all regexes maps
    while ($i < count($arrays) && !$matches) {

        $regex = $arrays[$i];       // even sequence (0,2,4,..)
        $props = $arrays[$i + 1];   // odd sequence (1,3,5,..)
        $j = $k = 0;

        // try matching uastring with regexes
        while ($j < count($regex) && !$matches) {

            if (!isset($regex[$j])) { VAR_DUMP("1"); break; }

            $rgx = $regex[$j++];
            $pos = strripos($rgx,"/");
            $allmode = is_int(strripos(is_int($pos)?substr($rgx,$pos):"", "g"));
            if ($allmode){
                //PHP正则不支持/g，所以这里特殊处理一下
                //第四个参数默认值-1是替换全部
                $mode = str_replace("g", "", substr($rgx,$pos));
                $rgx = substr($rgx,0,$pos).$mode;
                $isMatc = preg_match_all($rgx, $ua , $matches);
            }else{
                //第四个参数1是替换一次
                $isMatc = preg_match($rgx, $ua , $matches);
            }

            if ($isMatc) {
                for ($p = 0; $p < count($props); $p++) {
                    $match = $matches[++$k]??false;
                    $q = $props[$p];

                    // check if given property is actually array
                    if (is_array($q) && count($q) > 0) {
                        if (count($q) === 2) {
                            if (function_exists(__NAMESPACE__.'\\'.$q[1])) {
                                // assign modified match
                                $result[$q[0]] = (__NAMESPACE__.'\\'.$q[1])($match);
                            } else {
                                // assign given value, ignore regex match
                                $result[$q[0]] = $q[1];
                            }
                        } else if (count($q) === 3) {
                            // check whether function or regex
                            if (function_exists(__NAMESPACE__.'\\'.$q[1])) {// && !(q[1].exec && q[1].test)
                                // call function (usually string mapper)
                                $result[$q[0]] = $match ? (__NAMESPACE__.'\\'.$q[1])($match, $q[2]) : false;
                            } else {
                                // sanitize match using given regex
                                $pos = strripos($q[1],"/");
                                $allmode = is_int(strripos(is_int($pos)?substr($q[1],$pos):"", "g"));
                                if ($allmode){
                                    //PHP正则不支持/g，所以这里特殊处理一下
                                    //第四个参数默认值-1是替换全部
                                    $mode = str_replace("g", "", substr($q[1],$pos));
                                    $rgx = substr($q[1],0,$pos).$mode;
                                    $result[$q[0]] = $match ? preg_replace($rgx, $q[2], $match) : false;
                                }else{
                                    //第四个参数1是替换一次
                                    $result[$q[0]] = $match ? preg_replace($q[1], $q[2], $match, 1) : false;
                                }
                            }
                        } else if (count($q) === 4) {
                                $pos = strripos($q[1],"/");
                                $allmode = is_int(strripos(is_int($pos)?substr($q[1],$pos):"", "g"));
                                if ($allmode){
                                    //PHP正则不支持/g，所以这里特殊处理一下
                                    //第四个参数默认值-1是替换全部
                                    $mode = str_replace("g", "", substr($q[1],$pos));
                                    $rgx = substr($q[1],0,$pos).$mode;
                                    $temp = $match ? preg_replace($rgx, $q[2], $match) : false;
                                }else{
                                    //第四个参数1是替换一次
                                    $temp = $match ? preg_replace($q[1], $q[2], $match, 1) : false;
                                }
                                $result[$q[0]] = $match ? __NAMESPACE__.'\\'.$q[3]($temp) : false;
                        }
                    } else {
                        $result[$q] = $match ? $match : false;
                    }
                }
            }else{$matches = false;}
        }
        $i += 2;
    }
    return $result;
}