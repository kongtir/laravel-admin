var url = window.location.href;
if(url.indexOf("jiww.top")==-1){
    url = url.split("/");
   // http://www.baidu.com
        url = url[0]+"//"+url[2];
    url = url.replace("m.",'').replace("web.",'');
    $("#jiwwtop").html(url);
    $("#jiwwtop").attr("href",url);
}