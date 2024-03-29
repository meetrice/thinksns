<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.weather .today,.weather .t{padding:0 0 10px 0;}
.today li{padding:0 0 5px 0;}
</style>

<div id="weather"></div>

<script type="text/javascript"> 
var sina={init:function(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}},isIE:navigator.appVersion.indexOf("MSIE")!=-1?true:false,addEvent:function(l,i,I){if(l.attachEvent){l.attachEvent("on"+i,I)}else{l.addEventListener(i,I,false)}},delEvent:function(l,i,I){if(l.detachEvent){l.detachEvent("on"+i,I)}else{l.removeEventListener(i,I,false)}},readCookie:function(O){var o="",l=O+"=";if(document.cookie.length>0){var i=document.cookie.indexOf(l);if(i!=-1){i+=l.length;var I=document.cookie.indexOf(";",i);if(I==-1)I=document.cookie.length;o=unescape(document.cookie.substring(i,I))}};return o},writeCookie:function(i,l,o,c){var O="",I="";if(o!=null){O=new Date((new Date).getTime()+o*3600000);O="; expires="+O.toGMTString()};if(c!=null){I=";domain="+c};document.cookie=i+"="+escape(l)+O+I},readStyle:function(I,l){if(I.style[l]){return I.style[l]}else if(I.currentStyle){return I.currentStyle[l]}else if(document.defaultView&&document.defaultView.getComputedStyle){var i=document.defaultView.getComputedStyle(I,null);return i.getPropertyValue(l)}else{return null}}};

/**
 * 天气对象Js类
 * @type {Object}
 */
var weather = {};
/**
 * 站内URL，代理模式，调用新浪天气API
 * @type {String}
 */
weather.url = "<?php echo U('public/Widget/addonsRequest',array('addon'=>'Weather','hook'=>'proxy'));?>";
/**
 * 城市信息
 * @type {Object}
 */
weather.city = sina.readCookie('SINA_NEWS_CUSTOMIZE_city') || '';
/**
 * 天气图片信息
 * @param string figure
 * @param integer type
 * @param integer size
 * @param string title
 * @type {Object}
 */
weather.getFigureImg = function(figure, title, size, type)
{
	return '<img width="'+size+'" src="http://i2.sinaimg.cn/dy/weather/images/yb2/60_60/' + figure + '_' + type + '.gif" title="' + title + '" />';
};
/**
 * 天气插件显示
 * @type {Object}
 */
weather.show = function(wObj)
{
	if(wObj.w) {
		for(var i in wObj.w) {
			weather.city = i;
			var w = wObj.w[i];
		}
		// HTML页面
		var html = '<div class="weather mb20 border-b">\
					<a class="right" href="javascript:;">'+weather.city+'</a><h3>今天天气预报</h3>\
					<div class="today clearfix">\
                 <div class="left" style="width:30%">'+weather.getFigureImg(w[0].f1,w[0].s1,60,0)+'</div>\
                 <div>\
                   <ul>\
                      <li><span>' + w[0].t1+'℃</span>～<span class="th">' + w[0].t2+'℃</span></li>\
                      <li>' + w[0].s1 + '</li>\
                      <li>风力：' + w[0].d1+w[0].p1+'</li>\
                   </ul>\
                 </div>\
               </div>\
               <div class="t clearfix"><div class="left" style="width:30%;line-height:30px">明天</div><div class="left" style="width:40%;line-height:30px"><span>' + w[1].t1+'℃</span>～<span class="th">' + w[1].t2+'℃</span></div><div class="left">' + weather.getFigureImg(w[1].f1,w[1].s1,30,0) + '</div>\
               </div>\
               <div class="t clearfix"><div class="left" style="width:30%;line-height:30px">后天</div><div class="left" style="width:40%;line-height:30px"><span class="tl">'+ w[2].t1+'℃</span>～<span class="th">'+ w[2].t2+'℃</span></div><div class="left">'+weather.getFigureImg(w[2].f1,w[2].s1,30,0) + '</div>\
               </div>\
             </div>';
		// 插入页面
		sina.init('weather').innerHTML = html;
	}
};
/**
 * 加载API接口文件
 * @type {Object}
 */
weather.loadJs = function(url, dispose)
{
	var sNode = document.createElement("script");
	sNode.type = "text/javascript";
	sNode.language = "javascript";
	sNode.defer = true;
	// 超时操作
	sNode.timeout = setTimeout(function() {
		document.getElementsByTagName("head")[0].removeChild(sNode);
	}, 10000);
	// 加载操作
	sNode[sNode.onreadystatechange === null ? "onreadystatechange" : "onload"] = function() {
		if(this.onreadystatechange) {
			if(this.readyState != "loaded" && this.readyState != "complete") {
				return null;
			}
		}

		if(dispose) {
			setTimeout(dispose, 100);
		}

		this[this.onreadystatechange ? "onreadystatechange" : "onload"] = null;
		clearTimeout(sNode.timeout);
		setTimeout(function() {
			sNode.parentNode.removeChild(sNode);
		}, 1000);
	};

	sNode.src = url;
	document.getElementsByTagName("head")[0].appendChild(sNode);
};
/**
 * 设置天气地址
 */
weather.setCity = function(cityCode)
{
	this.city = cityCode || this.city;
	this.loadJs(weather.url+'&city='+weather.city);
};
// 调用接口
var show = weather.show;
weather.setCity("<?php echo ($cityCode); ?>");
</script>