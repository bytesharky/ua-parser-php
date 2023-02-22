# UAParser.php

此代码改编自UAParser.js v1.1.34，感谢原作者及其他114位贡献者

用于从用户代理数据中检测浏览器、引擎、操作系统、CPU 和设备类型/型号。

* Author    : frogot fish <<fish@doffish.com>>
* Demo      : https://www.doffish.com/ua/index.php
* Source    : https://github.com/talefish/ua-parser-php

***

# Documentation
### UAParser([user-agent:string][,extensions:array])

您不需要将UserAgent字符串传递给函数，您只需调用函数，它就会自动从$_SERVER['HTTP_USER_AGENT']中获取UserAgent字符串。


## Constructor
当您使用关键字“new”调用“UAParser”时，“UAParser”将返回一个不包含结果对象的新实例，他仅包含了正则表达式的匹配规则，您必须调用一个可用的方法来从用户代理字符串中获取信息。
* `new UAParser([user-agent:string][,extensions:object])`
```php
$uap = new frogotfish\UAParser\UAParser();
var_dump($uap);
/**
object(frogotfish\UAParser\UAParser)#1 (3) {
  ["version"]=>
  string(6) "1.1.34"
  ["uastring"]=>
  string(129) "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.50"
  ["regexmap"]=>
  array(5) {
    ["browser"]=>
    array(80) {
      [0]=>
      array(1) {
        [0]=>
        string(30) "/\b(?:crmo|crios)\/([\w\.]+)/i"
      }
.........
*/
```



## Methods

#### Methods table
下面是所有可用方法的小概述：
*  `getResult()` - 返回所有函数对象调用、用户代理字符串、浏览器信息、cpu、设备、引擎、操作系统：
`{ ua: '', browser: {}, cpu: {}, device: {}, engine: {}, os: {} }`.

 *  `getBrowser()`      - 返回浏览器名称和版本。
 *  `getDevice()`       - 返回设备型号、类型和供应商。
 *  `getEngine()`       - 返回当前浏览器引擎名称和版本。
 *  `getOS()`           - 返回正在运行的操作系统名称和版本。
 *  `getCPU()`          - 返回CPU体系结构设计名称。
 *  `getUA()`           - 返回用户代理字符串。
 *  `setUA(user-agent)` - 设置要解析的自定义用户代理。

---

* `getResult() : UAResult`
    * returns `{ ua: '', browser: UABrowser {}, cpu: UACPU {}, device: UADevice {}, engine: UAEngine {}, os: UAOS {} }`

* `getBrowser() : UABrowser`
    * returns `{ name: '', version: '' }`

```sh
# Possible 'browser.name':
2345Explorer, 360 Browser, Amaya, Android Browser, Arora, Avant, Avast, AVG,
BIDUBrowser, Baidu, Basilisk, Blazer, Bolt, Brave, Bowser, Camino, Chimera,
Chrome Headless, Chrome WebView, Chrome, Chromium, Cobalt, Comodo Dragon, Dillo,
Dolphin, Doris, DuckDuckGo, Edge, Electron, Epiphany, Facebook, Falkon, Fennec, 
Firebird, Firefox [Focus/Reality], Flock, Flow, GSA, GoBrowser, Huawei Browser, 
ICE Browser, IE, IEMobile, IceApe, IceCat, IceDragon, Iceweasel, Instagram, 
Iridium, Iron, Jasmine, Kakao[Story/Talk], K-Meleon, Kindle, Klar, Konqueror, 
LBBROWSER, Line, LinkedIn, Links, Lunascape, Lynx, MIUI Browser, Maemo Browser, 
Maemo, Maxthon, MetaSr Midori, Minimo, Mobile Safari, Mosaic, Mozilla, NetFront, 
NetSurf, Netfront, Netscape, NokiaBrowser, Obigo, Oculus Browser, OmniWeb, 
Opera Coast, Opera [Mini/Mobi/Tablet], PaleMoon, PhantomJS, Phoenix, Polaris, 
Puffin, QQ, QQBrowser, QQBrowserLite, Quark, QupZilla, RockMelt, Safari, 
Sailfish Browser, Samsung Browser, SeaMonkey, Silk, Skyfire, Sleipnir, Slim, 
SlimBrowser, Swiftfox, Tesla, Tizen Browser, UCBrowser, UP.Browser, Viera, 
Vivaldi, Waterfox, WeChat, Weibo, Yandex, baidu, iCab, w3m, Whale Browser...

# 'browser.version' determined dynamically
```

* `getDevice() : UADevice`
    * returns `{ model: '', type: '', vendor: '' }`

```sh
# Possible 'device.type':
console, mobile, tablet, smarttv, wearable, embedded

##########
# NOTE: 'desktop' is not a possible device type. 
# UAParser only reports info directly available from the UA string, which is not the case for 'desktop' device type.
# If you wish to detect desktop devices, you must handle the needed logic yourself.
# You can read more about it in this issue: https://github.com/faisalman/ua-parser-js/issues/182
##########

# Possible 'device.vendor':
Acer, Alcatel, Amazon, Apple, Archos, ASUS, AT&T, BenQ, BlackBerry, Dell,
Essential, Facebook, Fairphone, GeeksPhone, Google, HP, HTC, Huawei, Jolla, Kobo,
Lenovo, LG, Meizu, Microsoft, Motorola, Nexian, Nintendo, Nokia, Nvidia, OnePlus, 
OPPO, Ouya, Palm, Panasonic, Pebble, Polytron, Realme, RIM, Roku, Samsung, Sharp, 
Siemens, Sony[Ericsson], Sprint, Tesla, Vivo, Vodafone, Xbox, Xiaomi, Zebra, ZTE, ...

# 'device.model' determined dynamically
```

* `getEngine() : UAEngine`
    * returns `{ name: '', version: '' }`

```sh
# Possible 'engine.name'
Amaya, Blink, EdgeHTML, Flow, Gecko, Goanna, iCab, KHTML, Links, Lynx, NetFront,
NetSurf, Presto, Tasman, Trident, w3m, WebKit

# 'engine.version' determined dynamically
```

* `getOS() : UAOS`
    * returns `{ name: '', version: '' }`

```sh
# Possible 'os.name'
AIX, Amiga OS, Android[-x86], Arch, Bada, BeOS, BlackBerry, CentOS, Chromium OS,
Contiki, Fedora, Firefox OS, FreeBSD, Debian, Deepin, DragonFly, elementary OS, 
Fuchsia, Gentoo, GhostBSD, GNU, Haiku, HarmonyOS, HP-UX, Hurd, iOS, Joli, KaiOS, 
Linpus, Linspire,Linux, Mac OS, Maemo, Mageia, Mandriva, Manjaro, MeeGo, Minix, 
Mint, Morph OS, NetBSD, NetRange, NetTV, Nintendo, OpenBSD, OpenVMS, OS/2, Palm, 
PC-BSD, PCLinuxOS, Plan9, PlayStation, QNX, Raspbian, RedHat, RIM Tablet OS, 
RISC OS, Sabayon, Sailfish, Series40, Slackware, Solaris, SUSE, Symbian, Tizen, 
Ubuntu, Unix, VectorLinux, Viera, WebOS, Windows [Phone/Mobile], Zenwalk, ...

# 'os.version' determined dynamically
```

* `getCPU() : UACPU`
    * returns `{ architecture: '' }`

```sh
# Possible 'cpu.architecture'
68k, amd64, arm[64/hf], avr, ia[32/64], irix[64], mips[64], pa-risc, ppc, sparc[64]
```

* `getUA() : string`
    * returns UA string of current instance

* `setUA(uastring)`
    * set UA string to be parsed
    * returns current instance

#### * is() utility `since@1.1`

```php
//只是检查指定的某个财产是否具有相等值的速记
//因此，不必像这样使用“==”运算符来编写它：

$uap = new frogotfish\UAParser\UAParser('Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 635) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537');

$uap->getBrowser()->name;               // "IEMobile"
$uap->getBrowser()->is("IEMobile");     // true
$uap->getCPU()->is("ARM");              // true

$uap->getOS()->name;                    // "Windows Phone"
$uap->getOS()->is("Windows Phone");     // true

$uap->getDevice();                      // { vendor: "Nokia", model: "Lumia 635", type: "mobile" }
$uap->getResult()->device;              // { vendor: "Nokia", model: "Lumia 635", type: "mobile" }

$uap->getDevice()->is("mobile");        // true
$uap->getDevice()->is("Lumia 635");     // true
$uap->getDevice()->is("Nokia");         // true
$uap->getDevice()->is("iPhone");        // false
$uap->getResult()->device->is("Nokia"); // true
$uap->getResult()->device->model;       // "Lumia 635"

$uap->setUA("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36");

$browser = $uap->getBrowser();
$browser->is("IEMobile");               // false 
$browser->is("Chrome");                 // true

$uap->getResult()->browser->is("Edge"); // false
$uap->getResult()->os->name;            // "Mac OS"
$uap->getResult()->os->is("Mac OS");    // true
$uap->getResult()->os->version;         // "10.6.8"

$engine = $uap->getEngine();
$engine->is("Blink");                   // true
```

#### * toString() utility `since@1.1`

```php
// 以字符串形式检索全名值

/*
    * 属性值将按照此模式连接:
    * browser : name + version
    * cpu : architecture 
    * device : vendor + model
    * engine : name + version
    * os : name + version
*/

// 用法示例

$uap = new frogotfish\UAParser\UAParser('Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 635) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537');


$uap->getDevice()->toString();         // "Nokia Lumia 635"

$uap->getResult()->os.name;            // "Windows Phone"
$uap->getResult()->os.version;         // "8.1"
$uap->getResult()->os.toString();      // "Windows Phone 8.1"

$uap->setUA("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36");
$uap->getBrowser()->name;              // "Chrome"
$uap->getBrowser()->version;           // "28.0.1500.95"
$uap->getBrowser()->major;             // "28"
$uap->getBrowser()->toString();        // "Chrome 28.0.1500.95"

$engine = $uap.getEngine();
$engine->name;                         // "Blink"
$engine->version;                      // "28.0.1500.95"
$engine->toString();                   // "Blink 28.0.1500.95"
```

## Extending Regex

如果您想检测UAParser.php当前未提供的内容（例如：bot、特定应用程序等），可以传递一个正则表达式列表，用自己的正则表达式扩展内部UAParser.php正则表达式。

* `UAParser([uastring,] extensions)`

```php
// 用法示例一
use frogotfish\UAParser\UAParser;
$myOwnListOfBrowsers = [
    ['/(mybrowser)\/([\w\.]+)/i'], [NAME, VERSION]
];
$myParser = new UAParser(['browser'=> $myOwnListOfBrowsers]);
$myUA = 'Mozilla/5.0 MyBrowser/1.3';
$myParser->setUA($myUA);
echo($myParser->getBrowser()->toString());      // "MyBrowser 1.3"

// 用法示例二
$myOwnListOfDevices = [
    ['/(mytab) ([\w ]+)/i'], [VENDOR, MODEL, [TYPE, TABLET]],
    ['/(myphone)/i'], [VENDOR, [TYPE, MOBILE]]
];
$myParser2 = new UAParser([
    'browser'=> $myOwnListOfBrowsers,
    'device'=> $myOwnListOfDevices
]);
$myUA2 = 'Mozilla/5.0 MyTab 14 Pro Max';
$myParser2->setUA($myUA2);
echo($myParser2->getDevice()->toString());      // MyTab 14 Pro Max
```

# Contributors（UAParser.js）

<a href="https://github.com/faisalman/ua-parser-js/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=faisalman/ua-parser-js" />
</a>



# Contributors（UAParser.php）

<a href="https://github.com/talefish/ua-parser-php/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=talefish/ua-parser-php" /></a>

# License

MIT License

Copyright (c) 2012-2021 frogot fish <fish@doffish.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.