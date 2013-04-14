<?php if (!defined('THINK_PATH')) exit();?><?php $site['site_name'] = '网站登录';
if($logo['logo_site_title']){
	$sitetitle = $logo['logo_site_title'];
}else{
	$sitetitle = $site_name;
}
if($logo['login_top_title']){
	$sitesolgan = $logo['login_top_title'];
} else {
	$sitesolgan = $site_slogan;
}
$site['site_slogan'] = $sitetitle.$sitesolgan; ?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(($_title)  !=  ""): ?><?php echo ($_title); ?><?php else: ?><?php echo ($site["site_name"]); ?>-<?php echo ($site["site_slogan"]); ?><?php endif; ?></title>
<meta content="<?php if(($_keywords)  !=  ""): ?><?php echo ($_keywords); ?><?php else: ?><?php echo ($site["site_header_keywords"]); ?><?php endif; ?>" name="keywords">
<meta content="<?php if(($_description)  !=  ""): ?><?php echo ($_description); ?><?php else: ?><?php echo ($site["site_header_description"]); ?><?php endif; ?>" name="description">
<?php echo Addons::hook('public_meta');?>
<link href="__THEME__/image/favicon.ico?v=<?php echo ($site["sys_version"]); ?>" type="image/x-icon" rel="shortcut icon">
<link href="__THEME__/css/global.css?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css" />
<link href="__THEME__/css/module.css?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css" />
<link href="__THEME__/css/menu.css?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css" />
<link href="__THEME__/css/form.css?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css" />
<link href="__THEME__/css/jquery.atwho.css?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css" />
<?php if(!empty($appCssList)): ?>
<?php if(is_array($appCssList)): ?><?php $i = 0;?><?php $__LIST__ = $appCssList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$cl): ?><?php ++$i;?><?php $mod = ($i % 2 )?><link href="<?php echo APP_PUBLIC_URL;?>/<?php echo ($cl); ?>?v=<?php echo ($site["sys_version"]); ?>" rel="stylesheet" type="text/css"/><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
<?php endif; ?>
<script>
/**
 * 全局变量
 */
var SITE_URL  = '<?php echo SITE_URL; ?>';
var UPLOAD_URL= '<?php echo UPLOAD_URL; ?>';
var THEME_URL = '__THEME__';
var APPNAME   = '<?php echo APP_NAME; ?>';
var MID		  = '<?php echo $mid; ?>';
var UID		  = '<?php echo $uid; ?>';
var initNums  =  '<?php echo $initNums; ?>';
var SYS_VERSION = '<?php echo $site["sys_version"]; ?>'
// Js语言变量
var LANG = new Array();
</script>
<?php if(!empty($langJsList)) { ?>
<?php if(is_array($langJsList)): ?><?php $i = 0;?><?php $__LIST__ = $langJsList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><script src="<?php echo ($vo); ?>?v=<?php echo ($site["sys_version"]); ?>"></script><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
<?php } ?>
<script src="__THEME__/js/jquery-1.7.1.min.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/jquery.form.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/common.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/core.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/plugins/core.comment.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/module.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/module.common.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/jwidget_1.0.0.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/jquery.atwho.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/jquery.caret.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/ui.core.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<script src="__THEME__/js/ui.draggable.js?v=<?php echo ($site["sys_version"]); ?>"></script>
<?php echo Addons::hook('public_head',array('uid'=>$uid));?>
</head>
<body>


<script>
function focuslogin(type){
	if(type==1){
		$('#email').hide();
	}else{
		$('#password').hide();
	}
}
function blurlogin(type){
	if(type==1){
		if($('#account_input').val()==''){
			$('#email').show();
		}
	}else{
		if($('#pwd_input').val()==''){
			$('#password').show();
		}
	}
}
function rememberlogin(){
	if($('#login_remember').val()==1){
		$('#login_remember').val(0)
	}else{
		$('#login_remember').val(1)
	}
}
$(function() {
var interval = 4000;
var slide    =  setInterval(slideIt,interval);
function slideIt() {
  var obj = $('#ts_content .feed_list');
  obj.last().hide().prev().hide();
  obj.last().insertBefore(obj.first()).slideDown(1000);
  obj.last().prev().fadeOut(500);	
};

$('#ts_content').mouseover(function() {
	clearInterval(slide);//当鼠标移上去的时候停止下滑
}).mouseout(function() {
	slide = setInterval(slideIt,interval);//当鼠标移开的时候继续下滑
});

slideIt();

});
</script>
<div class="logo-bg"><div class="logo"><a href=""><img src="<?php if($logo['logo']){ ?><?php echo ($logo['logo']); ?><?php }elseif($site_logo){ ?><?php echo ($site_logo); ?><?php }else{ ?>__APP__/image/logo-b.png<?php } ?>" /></a><span><?php if($logo['login_top_title']){ ?><?php echo ($logo['login_top_title']); ?><?php }else{ ?><?php echo ($site_slogan); ?><?php } ?></span></div></div>
<div class="login-c">
    <div class="login-top">
      <div class="wid">
      <div class="login-bg">
       <?php if($banner){ ?>
       <div class="flashNews" id="logobanner">
            	<?php $i = 0; ?>
            	<?php foreach($banner as $vo){
            	$i++; ?>
            			<div <?php if($i!=1){ ?>style="display:none;"<?php } ?>>
						            <p>
                <a href="<?php echo ($vo['bannerlink']); ?>" target="_blank">
                  <img src="<?php echo (getImageUrl($vo['bannerurl'])); ?>" />
                </a>
            </p>
						</div>
                <?php } ?>
                <ul></ul> 
          </div><?php }else{ ?> 
         <ul>
           <li><a href=""><img src="__APP__/image/img1.jpg"/></a></li>
           <li style="display:none;"><a href=""><img src="__APP__/image/img2.jpg" /></a></li>
        </ul> 
        <?php } ?>
      </div>
      <form id="ajax_login_form" method="POST" action="<?php echo U('public/Passport/doLogin');?>" autocomplete="off">
      <div class="login-box">
        <h4>欢迎来到<?php if($logo['logo_site_title']){ ?><?php echo ($logo['logo_site_title']); ?><?php }else{ ?><?php echo ($site_name); ?><?php } ?></h4>

            <div id="js_login_input" style="display:none" class="error-box"></div>
        <ul>
           <li class="input">
              <label id="email">邮箱：</label>
              <input type="text" id="account_input" onfocus="focuslogin(1)" onblur="blurlogin(1)" name="login_email" class="text"/>
           </li>
           <li class="input">
              <label id="password">密码：</label>
              <input type="password" id="pwd_input" onfocus="focuslogin(2)" onblur="blurlogin(2)" name="login_password" class="text" />
           </li>
           <li><a href="<?php echo U('public/Passport/findPassword');?>" class="right">忘记密码？</a><span class="left f3">
           <input type="hidden" id="login_remember" name="login_remember" value="0" />
           <input type="checkbox" class="checkbox" autocomplete="off" onclick="rememberlogin()"/>下次自动登录</span></li>
           <li>
            <input type="submit" value="登录" class="left btn-login" style="border:0px;" />
            <?php if($register_type == 'open'){ ?>
            <a href="javascript:window.open('<?php echo U('public/Register');?>','_self')" class="right btn-reg">立即注册</a>
            <?php } ?>
           </li>
        </ul>
        <?php if(Addons::requireHooks('login_input_footer')): ?>
        <div class="account-others">
            <?php echo Addons::hook('login_input_footer_title');?>
            <div class="login-ft">
              <?php echo Addons::hook('login_input_footer');?>
            </div>
        </div>
        <?php endif; ?>
       </div>
      </form>
      <!--<div class="login-page">
        <ul>
           <li class="current"><a href=""></a></li>
           <li><a href=""></a></li>
           <li><a href=""></a></li>
        </ul>
      </div>-->
     </div>
    </div>
    <div class="login-main clearfix">
      <div class="login-r">
          <div class="news mb20">
              <h3>系统公告</h3>
              <ul>
              <?php if(is_array($announcement)): ?><?php $i = 0;?><?php $__LIST__ = $announcement?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$pv): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><i class="icon-notice left"></i><a target="_blank" href="<?php echo U('public/Index/announcement','id='.$pv['id']);?>"><?php echo ($pv["title"]); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
              </ul>
          </div> 
          <div class="active-user attention clearfix">
              <h3><?php echo ($user["user_title"]); ?></h3>
              <ul>
              <?php if(is_array($userlist)): ?><?php $i = 0;?><?php $__LIST__ = $userlist?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$user): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo ($user["space_url"]); ?>" class="face"><img src="<?php echo ($user["avatar_middle"]); ?>" width="50" height="50"/></a><a href="<?php echo ($user["space_url"]); ?>" class="face"><span><?php echo ($user["uname"]); ?></span></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
              </ul>
          </div>
          <div class="hot-topic mb20">
             <?php echo W('TopicList',array('type'=>1, 'limit'=>10));?>
          </div>
          <div class="mobi mb20">
          <?php echo (html_entity_decode($logo['login_foot_content'])); ?>
          </div>
      </div>
      <div class="login-l">
        <h3><?php if($feed['feed_title']){ ?><?php echo ($feed["feed_title"]); ?><?php }else{ ?>正在发生的<?php } ?></h3>
        <div class="feed_lists" id="ts_content">
        <?php if(is_array($loginlastfeed)): ?><?php $i = 0;?><?php $__LIST__ = $loginlastfeed?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vl): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dl class="feed_list"  id ='feed<?php echo ($vl["feed_id"]); ?>' model-node='feed_list'>
  <dt class="face">
  <a href="<?php echo ($vl['user_info']['space_url']); ?>"><img src="<?php echo ($vl['user_info']['avatar_small']); ?>"  event-node="face_card" uid='<?php echo ($vl['user_info']['uid']); ?>'></a></dt>
  <dd class="content">
  <p class="hd"><?php echo ($vl["title"]); ?>
  <?php if(is_array($vl['GroupData'][$vl['uid']])): ?><?php $i = 0;?><?php $__LIST__ = $vl['GroupData'][$vl['uid']]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$v2): ?><?php ++$i;?><?php $mod = ($i % 2 )?><img style="width:auto;height:auto;display:inline;cursor:pointer;" src="<?php echo ($v2['user_group_icon_url']); ?>" title="<?php echo ($v2['user_group_name']); ?>" />&nbsp;<?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
  </p>
  <span class="contents"><?php echo (format($vl["body"],true)); ?></span>
  <p class="info">
  <span class="right">
  </span>
     <span>
  <a class="date" href="<?php echo U('public/Profile/feed',array('feed_id'=>$vl['feed_id'],'uid'=>$vl['uid']));?>"><?php echo (friendlyDate($vl["publish_time"])); ?></a>
  <span><?php echo ($vl['from']); ?></span>
    </span>
</p>
  </dd>
  </dl><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
        </div>
      </div>
    </div>
</div>
<div class="footer">
   <div class="login-footer">
      <div class="foot clearfix">
         <?php if(is_array($navilist)): ?><?php $i = 0;?><?php $__LIST__ = $navilist?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$nv): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dl>
            <dt><a href="<?php echo ($nv["url"]); ?>"><?php echo ($nv['navi_name']); ?></a></dt>
            <?php if(is_array($nv["child"])): ?><?php $i = 0;?><?php $__LIST__ = $nv["child"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$cv): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo ($cv["url"]); ?>" target="<?php echo ($cv["target"]); ?>"><?php echo ($cv['navi_name']); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
         </dl><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
      </div>
    <p>
      <span class="right">Powered By <a href="http://www.thinksns.com" title="开源微博系统,开源微社区" target="_blank">ThinkSNS</a></span>
      <?php echo ($GLOBALS["ts"]["site"]["site_footer"]); ?>
    </p>
  </div>
</div>
<?php if(($GLOBALS["ts"]["site"]["site_online_count"])  ==  "1"): ?><script src="<?php echo SITE_URL;?>/online_check.php?uid=<?php echo ($mid); ?>&uname=<?php echo ($user["uname"]); ?>&mod=<?php echo MODULE_NAME;?>&app=<?php echo APP_NAME;?>&act=<?php echo ACTION_NAME;?>&action=trace"></script><?php endif; ?>
<script>
new fSwitchPic( "logobanner" );
</script>
<script src="__THEME__/js/jquery.form.js" type="text/javascript"></script>
<script src="__APP__/login.js" type="text/javascript"></script>
</body>
</html>