<?php
/////////////////////////////////////////////////////////////////////////////////
/* UAParser.php v1.1.34
/* 版权所有 ? frogot fish <fish@doffish.com>
/* MIT License *//*
/* 从用户代理数据中检测浏览器、引擎、操作系统、CPU 和设备类型/型号。
/* 源：https://github.com/talefish/ua-parser-php
/*
/* 此代码改编自UAParser.js v1.1.34，感谢源作者及其他114位贡献者
/* 源：https://github.com/faisalman/ua-parser-js
*/////////////////////////////////////////////////////////////////////////////////

namespace  frogotfish\UAParser;

//////////////
// public constants
/////////////
define('LIBVERSION'    , '1.1.34');
define('EMPTY_'        , '');
define('UNKNOWN'       , '?');
//define('FUNC_TYPE'     , 'function');
//define('UNDEF_TYPE'    , 'undefined');
//define('OBJ_TYPE'      , 'object');
//define('STR_TYPE'      , 'string');
define('MAJOR'         , 'major');
define('MODEL'         , 'model');
define('NAME'          , 'name');
define('TYPE'          , 'type');
define('VENDOR'        , 'vendor');
define('VERSION'       , 'version');
define('ARCHITECTURE'  , 'architecture');
define('CONSOLE'       , 'console');
define('MOBILE'        , 'mobile');
define('TABLET'        , 'tablet');
define('SMARTTV'       , 'smarttv');
define('WEARABLE'      , 'wearable');
define('EMBEDDED'      , 'embedded');
define('UA_MAX_LENGTH' , 350);

define('AMAZON'        , 'Amazon');
define('APPLE'         , 'Apple');
define('ASUS'          , 'ASUS');
define('BLACKBERRY'    , 'BlackBerry');
define('BROWSER'       , 'Browser');
define('CHROME'        , 'Chrome');
define('EDGE'          , 'Edge');
define('FIREFOX'       , 'Firefox');
define('GOOGLE'        , 'Google');
define('HUAWEI'        , 'Huawei');
define('LG'            , 'LG');
define('MICROSOFT'     , 'Microsoft');
define('MOTOROLA'      , 'Motorola');
define('OPERA'         , 'Opera');
define('SAMSUNG'       , 'Samsung');
define('SHARP'         , 'Sharp');
define('SONY'          , 'Sony');
define('XIAOMI'        , 'Xiaomi');
define('ZEBRA'         , 'Zebra');
define('FACEBOOK'      , 'Facebook');

///////////////
// String map
//////////////

// Safari < 3.0
define('OLDSAFARIMAP', [
	'1.0'     => '/8',
	'1.2'     => '/1',
	'1.3'     => '/3',
	'2.0'     => '/412',
	'2.0.2'   => '/416',
	'2.0.3'   => '/417',
	'2.0.4'   => '/419',
	'?'       => '/'
]);

define('WINVERMAP', [
	'ME'      => '4.90',
	'NT 3.11' => 'NT3.51',
	'NT 4.0'  => 'NT4.0',
	'2000'    => 'NT 5.0',
	'XP'      => ['NT 5.1', 'NT 5.2'],
	'Vista'   => 'NT 6.0',
	'7'       => 'NT 6.1',
	'8'       => 'NT 6.2',
	'8.1'     => 'NT 6.3',
	'10'      => ['NT 6.4', 'NT 10.0'],
	'RT'      => 'ARM'
]);

define('ARCHEQUMAP', [
	'amd64'   => ['x86-64', 'x64'],
	'ia32'    => ['x86']
]);