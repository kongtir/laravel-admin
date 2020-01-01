/*
* 并非通用的jS
* */
function AddShopCart (ShopId,ShopNum,cartbs) {
    //alert(ShopId);
    //添加到购物车
    if(ShopNum==undefined)ShopNum=1;
    //  var cartbs='cart';//标识从哪里加的购物车
    var shopis=0;          //0表示不存在  1表示存在
    var Mcartlist=  localStorage.getItem('Cartlist');
    console.log("Mcartlist",Mcartlist);
    if(Mcartlist){
        Mcartlist = JSON.parse(Mcartlist);
    }
    if(ShopId==0 || ShopNum==0){
        //  $cart['code']=1;   //表示添加失败
        // addsuccess('添加失败!');
        //layer.msg("添加失败");
        $.PageDialog.fail("添加失败"  );
    }else{
        if(Mcartlist){
            for(var key in Mcartlist ){
                var val = Mcartlist[key];
                if(key==ShopId){
                    if(cartbs&& cartbs=='cart'){
                        Mcartlist[ShopId]={};
                        Mcartlist[ShopId]['num']=ShopNum;
                    }else{
                        Mcartlist[ShopId]={};
                        Mcartlist[ShopId]['num']=val['num']+ShopNum;
                    }
                    shopis=1;
                }else{
                    Mcartlist[key]['num']=val['num'];
                }
            }
        }else{
            Mcartlist ={};
            Mcartlist[ShopId]={};
            Mcartlist[ShopId]['num']=ShopNum;
        }
        if(shopis==0){
            Mcartlist[ShopId]={};

            Mcartlist[ShopId]['num']=ShopNum;
        }
        // _setcookie('Cartlist',json_encode($Mcartlist),'');
        console.log(Mcartlist);
        Mcartlist = JSON.stringify(Mcartlist);
        localStorage.setItem('Cartlist',Mcartlist);
        //$cart['code']=0;   //表示添加成功
        // addsuccess('添加成功!');
        $.PageDialog.ok("<s></s>添加成功"  );
        //  layer.msg("添加成功");
    }
    //$cart['num']=count($Mcartlist);    //表示现在购物车有多少条记录
    //var_dump($Mcartlist);
    // echo json_encode($cart);




    // $.getJSON(localStorage.getItem('baseUrlServer')+'/index.php/mobile/ajax/addShopCart/'+codeid+'/1',function(data){
    // 	if(data.code==1){
    // 		addsuccess('添加失败');
    // 	}else if(data.code==0){
    // 		addsuccess('添加成功');
    // 	}return false;
    // });


}


function  ClearShopCart() {
    localStorage.removeItem('Cartlist');
}

function  IsExitShopCartList() {
    var Mcartlist =  localStorage.getItem('Cartlist');
    if(Mcartlist) return true;
    return false;
}

function LoginOut() {
    localStorage.removeItem('uid');
    localStorage.removeItem('ushell');
}

function GetCartnum() {
    var Mcartlist =  localStorage.getItem('Cartlist');
    console.log("Mcartlist",Mcartlist);
    if(Mcartlist){
        Mcartlist = JSON.parse(Mcartlist);
    }
    var cartnum = {};
    if(Mcartlist){
        cartnum['code']=0;
        cartnum['num']=0;
        for(var key in Mcartlist){
            cartnum['num']++ ;
        }
    }else{
        cartnum['code']=1;
        cartnum['num']=0;
    }
    //var_dump($Mcartlist);
    //echo json_encode($cartnum);
    $("#btnCart").append('<em>'+cartnum.num+'</em>');
}
/*
* 并非通用的jS - over
* */




function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

//转意符换成普通字符
function escape2Html(str) {
    var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"'};
    return str.replace(/&(lt|gt|nbsp|amp|quot);/ig,function(all,t){return arrEntities[t];});
}

//普通字符转换成转意符
function html2Escape(sHtml) {
    return sHtml.replace(/[<>&"]/g,function(c){return {'<':'<','>':'>','&':'&','"':'"'}[c];});
}
//js 读取文件  <input type="file" onchange="jsReadFiles(this.files)"/>
var jsReadFiles_data =null;
function jsReadFiles(files) {
    if (files.length) {
        var file = files[0];
        var reader = new FileReader();//new一个FileReader实例
        if (/text+/.test(file.type)) {//判断文件类型，是不是text类型
            reader.onload = function () {
               // $('body').append('<pre>' + this.result + '</pre>');
                jsReadFiles_data =this.result;
            };
            reader.readAsText(file);
        } else if (/image+/.test(file.type)) {//判断文件是不是imgage类型
            reader.onload = function () {
              // $('body').append('<img src="' + this.result + '"/>');
              //  jsReadFiles_data =this.result;
            };
            reader.readAsDataURL(file);
        }
    }
}
/**
 * 通用的打开下载对话框方法，没有测试过具体兼容性
 * @param url 下载地址，也可以是一个blob对象，必选
 * @param saveName 保存文件名，可选
 */
function openDownloadDialog(url, saveName)
{
    if(typeof url == 'object' && url instanceof Blob)
    {
        url = URL.createObjectURL(url); // 创建blob地址
    }
    var aLink = document.createElement('a');
    aLink.href = url;
    aLink.download = saveName || ''; // HTML5新增的属性，指定保存文件名，可以不要后缀，注意，file:///模式下不会生效
    var event;
    if(window.MouseEvent) event = new MouseEvent('click');
    else
    {
        event = document.createEvent('MouseEvents');
        event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    }
    aLink.dispatchEvent(event);
}

/**
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

String.prototype.Rep=function(f,e){//吧f替换成e
    var reg=new RegExp(f,"g"); //创建正则RegExp对象
    return this.replace(reg,e);
}

function  NumToBCode(Number) {
    var BCode = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    var JinZhi = BCode.length;
    var Code ="";
    var TempCode = [];
    var mi = 0;
    while (Number>0){
        var TempNum =Number % JinZhi ;
        Code +=BCode[TempNum];
        Number = (Number - TempNum) / JinZhi ;
    }
    Code = Code. split('').reverse().join("");
    switch (Code.length) {
        case 1: Code = "OOO" + Code;break;
        case 2: Code = "OO" + Code;break;
        case 3: Code = "O" + Code;break;
    }
    return Code ;
}
function  BCodeToNum(Code) {
    Code =Code.toUpperCase();
    // var val = "这是一个变量，这是一个变量".replace(eval("/变量/g"),"替换");
    Code = Code.replace(eval("/0/g"),"");
    Code = Code.replace(eval("/O/g"),"");
    var BCode = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    var JinZhi = BCode.length;
    var TempCode = [];
    var Number = 0;
    Code =   Code. split(''). reverse(). join("");
    for(var i=0;i<Code.length;i++){
        var CuurrNum = BCode.indexOf(Code[i]);
        TempCode.push({num:CuurrNum,mi:i});
    }
    for(var i=0;i<TempCode.length;i++){
        Number+= TempCode[i].num *  Math.pow(JinZhi,TempCode[i].mi );
    }
    return Number;
}
function CheckNUMCode(num){
    var Code =  NumToBCode(num);
    var Num2 =  BCodeToNum(Code);
    var Success = Num2 == num? "Success":"fail";
    console.log(Success,Num2,Code);
}
function CheckDataStart(){
    var CheckData =[1000,1,45,2134,999999];
    for(var i=0;i<CheckData.length;i++){
        CheckNUMCode(CheckData[i]);
    }
}
//loadScript("http://js.xiaowawa.top/Content/SendJS/a1.js", function() {});
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
/*  原生异步参数调用法
    不自动转换为json
* */
function XMLDoc_AJAX(url, method,fnt) {
    var XMLDoc_AJAX_http;
    if (window.XMLHttpRequest) {
        XMLDoc_AJAX_http = new XMLHttpRequest();
    } else {
        XMLDoc_AJAX_http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    XMLDoc_AJAX_http.onreadystatechange = function () {
        if (XMLDoc_AJAX_http.readyState === 4 && XMLDoc_AJAX_http.status === 200) {
            //var outresult = JSON.parse(XMLDoc_AJAX_http.responseText);
            fnt(XMLDoc_AJAX_http.responseText);
        }
    };
    XMLDoc_AJAX_http.open(method, url, true);
    XMLDoc_AJAX_http.send();
}
// 判断是否在微信中
function is_wx_Coustback() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) === "micromessenger") {
        return true;
    } else {
        return false;
    }
}

