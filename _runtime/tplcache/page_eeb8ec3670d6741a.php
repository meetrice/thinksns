<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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

<div id="body_page" name='body_page'>
    <div id="body-bg">
    <div id="header" name="header">
    	<?php echo constant(" 未登录时 *");?>
    	<?php if( !isset($_SESSION["mid"])): ?><div class="header-wrap">
        	<div class="head-bd">
                <!-- logo -->
                <div class="reg">
                    <a href="<?php echo U('public/Register');?>"><?php echo L('PUBLIC_REGISTER');?></a>
                    <i class="vline"> | </i>
                    <a href="<?php echo U('public/Passport/login');?>"><?php echo L('PUBLIC_LOGIN');?></a>
                </div>
                <div class="logo" <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false): ?>style="_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo ($site["logo"]); ?>', sizingMethod='crop');_background:none;"<?php else: ?>style="background:url(<?php echo ($site["logo"]); ?>) no-repeat;"<?php endif; ?>><a href="<?php echo SITE_URL;?>"></a></div>
                <!-- logo -->
            </div>
		</div><?php endif; ?>

		<?php echo constant(" 登录后 *");?>
		<?php if(isset($_SESSION["mid"])): ?><div class="header-wrap">
        	<div class="head-bd">
                <!-- logo -->
                <div class="logo" <?php if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false): ?>style="_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo ($site["logo"]); ?>', sizingMethod='crop');_background:none;"<?php else: ?>style="background:url(<?php echo ($site["logo"]); ?>) no-repeat;"<?php endif; ?>>
                    <a href="<?php echo SITE_URL;?>"></a>
                </div>
                <!-- logo -->
                <?php if($user['is_init'] == 1): ?>
                <div class="nav">
                    <ul>
                        <?php if(is_array($site_top_nav)): ?><?php $i = 0;?><?php $__LIST__ = $site_top_nav?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$st): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li <?php if(APP_NAME == $st['app_name'] || $_GET['page'] == $st['app_name']): ?> class="current" <?php endif; ?> ><a href="<?php echo ($st["url"]); ?>" target="<?php echo ($st["target"]); ?>" class="app"><?php echo ($st["navi_name"]); ?></a>
                            <?php if(isset($st['child'])): ?><div model-node="drop_menu_list" class="dropmenu" style="width:100px;display:none;">
                                <dl class="acc-list" >
                                    <?php if(is_array($st["child"])): ?><?php $i = 0;?><?php $__LIST__ = $st["child"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$stc): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo ($stc["url"]); ?>" target="<?php echo ($stc["target"]); ?>"><?php echo (getShort($stc["navi_name"],6)); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                                </dl>
                            </div><?php endif; ?>
                          </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                        <li style="*z-index:100;">
                        <a href="###" class="app">应用</a>
                        <div model-node="drop_menu_list" class="dropmenu" style="width:370px;left:-50px;display:none;z-index:100;">
                            <ul class="acc-list app-list clearfix">
                                <?php if(is_array($site_nav_apps)): ?><?php $i = 0;?><?php $__LIST__ = $site_nav_apps?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$li): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo U($li['app_name']);?>"><img src="<?php echo empty($li['icon_url_large']) ? APPS_URL.'/'.$li['app_name'].'/Appinfo/icon_app_large.png':$li['icon_url_large']; ?>" width="50" height="50" /><?php echo (getShort($li["app_alias"],4)); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                                <li><a href="<?php echo U('public/App/addapp');?>"><img src="__THEME__/image/more.png" width="50" height="50" />更多应用</a></li>
                            </ul>
                        </div>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
                 <?php if(($user["is_init"])  ==  "0"): ?><div class="person">
                    <ul>
                        <li model-node="person" class="dorp-right"><a href="javascript:void(0);" class="app name" style="cursor:default">欢迎，<?php echo ($user['uname']); ?></a></li>
                        <li class="dorp-right"><a href="<?php echo U('public/Passport/logout');?>" class="app name">退出</a></li>
                    </ul>
                  </div>
                <?php else: ?>
                <div class="search">
                    <div id="mod-search" model-node="drop_search">
                    <form name="search_feed" id="search_feed" method="get" action="<?php echo U('public/Search/index');?>">
                        <input name="app" value="public" type="hidden"/>
                        <input name="mod" value="Search" type="hidden"/>
                        <input type="hidden" name="t" value="2"/>
                        <input type="hidden" name="a" value="public"/>
                        <dl>
                            <dt class="clearfix"><input id="search_input" class="s-txt left"  type="text" value="搜微博 / 昵称 / 标签" onfocus="this.value=''" onblur="setTimeout(function(){ $('#search-box').remove();} , 200);if(this.value=='') this.value='搜微博 / 昵称 / 标签';" event-node="searchKey" name='k'  autocomplete="off"><a href="javascript:void(0)" class="ico-search left" onclick="if(getLength($('#search_input').val()) && $('#search_input').val()!=='搜微博 / 昵称 / 标签'){ $('#search_feed').submit(); return false;}"></a>
                            </dt>
                        </dl>
                    </form>
                    </div>
                </div> 
                <div class="person">
                    <ul>
                        <li model-node="person" class="dorp-right">
                            <a href="<?php echo ($user['space_url']); ?>" class="username"><?php echo (getShort($user['uname'],6)); ?></a>
                        </li>                       
                        <li model-node="notice" class="dorp-right"><a href="javascript:void(0);" class="app"><?php echo L('PUBLIC_MESSAGE');?></a>
                            <div  class="dropmenu" model-node="drop_menu_list">
                            	<ul class="message_list_container message_list_new"  style="display:none">
                                    <li rel="new_folower_count" style="display:none">
                                        <span></span>，<a href="<?php echo U('public/Index/follower',array('uid'=>$mid));?>"><?php echo L('PUBLIC_FOLLOWERS_REMIND');?></a></li>
                                    <li rel="unread_comment" style="display:none"><span></span>，<a href="<?php echo U('public/Comment/index',array('type'=>'receive'));?>">
                                        <?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                    <li rel="unread_message" style="display:none"><span></span>，<a href="<?php echo U('public/Message');?>" ><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                    <li rel="unread_atme" style="display:none"><span></span>，<a href="<?php echo U('public/Mention');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                    <li rel="unread_notify" style="display:none"><span></span>，<a href="<?php echo U('public/Message/notify');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                                </ul>
                                <dl class="acc-list W-message" >
                                    <dd><a  href="<?php echo U('public/Mention/index');?>">@提到我的</a></dd>
                                    <dd><a  href="<?php echo U('public/Comment/index', array('type'=>'receive'));?>">收到的评论</a></dd>
                                    <dd><a  href="<?php echo U('public/Comment/index', array('type'=>'send'));?>">发出的评论</a></dd>
                                    <dd><a  href="<?php echo U('public/Message/index');?>">我的私信</a></dd>
                                    <dd><a  href="<?php echo U('public/Message/notify');?>">系统消息</a></dd>
                                    <?php if(CheckPermission('core_normal','send_message')){ ?>
                                <dd class="border"><a event-node="postMsg" href="javascript:void(0)" onclick="ui.sendmessage()"><?php echo L('PUBLIC_SEND_PRIVATE_MESSAGE');?>&raquo;</a></dd>
                                <?php } ?>
                                </dl>
                            </div>
                        </li>
                        <li model-node="account" class="dorp-right"><a href="javascript:void(0);" class="app"><?php echo L('PUBLIC_ACCOUNT');?></a>
                            <div model-node="drop_menu_list" class="dropmenu" style="width:100px">
                                <dl class="acc-list">
                                <dd><a href="<?php echo U('public/Account/index');?>"><?php echo L('PUBLIC_SETTING');?></a></dd>
                                
                                <?php if(CheckTaskSwitch()): ?>
                                <dd><a href="<?php echo U('public/Task/index');?>">任务中心</a></dd>
                                <dd><a href="<?php echo U('public/Medal/index');?>">勋章馆</a></dd>
                                <?php endif; ?>
                                
                                <dd><a href="<?php echo U('public/Rank/index','type=2');?>">排行榜</a></dd>
                                <?php if(isInvite() && CheckPermission('core_normal','invite_user')): ?>
                                <dd><a href="<?php echo U('public/Invite/invite');?>"><?php echo L('PUBLIC_INVITE_COLLEAGUE');?></a></dd>
                                <?php endif; ?>
                                <?php if(CheckPermission('core_admin','admin_login')){ ?>
                                <dd><a href="<?php echo U('admin');?>"><?php echo L('PUBLIC_SYSTEM_MANAGEMENT');?></a></dd>
                                <?php } ?>

                                <dd class="border"><a href="<?php echo U('public/Passport/logout');?>"><?php echo L('PUBLIC_LOGOUT');?>&raquo;</a></dd>
                                <dd></dd>
                                </dl>
                            </div>
                        </li>
                    </ul>
                </div>        
                <?php if(MODULE_NAME !='Register'): ?>
                <div id="message_container" class="layer-massage-box" style="display:none">
                	<ul class="message_list_container" >
                        <li rel="new_folower_count" style="display:none"><span></span>，<a href="<?php echo U('public/Index/follower',array('uid'=>$mid));?>"><?php echo L('PUBLIC_FOLLOWERS_REMIND');?></a></li>
                		<li rel="unread_comment" style="display:none"><span></span>，<a href="<?php echo U('public/Comment/index',array('type'=>'receive'));?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                        <li rel="unread_message" style="display:none"><span></span>，<a href="<?php echo U('public/Message');?>" ><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
 	                    <li rel="unread_atme" style="display:none"><span></span>，<a href="<?php echo U('public/Mention');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
     	                <li rel="unread_notify" style="display:none"><span></span>，<a href="<?php echo U('public/Message/notify');?>"><?php echo L('PUBLIS_MESSAGE_REMIND');?></a></li>
                	</ul>
                <a href="javascript:void(0)" onclick="core.dropnotify.closeParentObj()" class="ico-close1"></a>
                </div>
                <?php endif; ?><?php endif; ?>
        	</div>
        </div>
        <?php if(MODULE_NAME != 'Search'): ?>
        <div id="search"  class="mod-at-wrap search_footer" model-node='search_footer' style="display:none;z-index:-1">
            <div class="search-wrap">
                <div class="input">
                     <form id="search_form" action="<?php echo U('public/Search/index');?>" method="GET">
                        <div class="search-menu" model-node='search_menu' model-args='a=<?php echo ($curApp); ?>&t=<?php echo ($curType); ?>'>
                            <a href="javascript:;" id='search_cur_menu'><?php echo (($curTypeName)?($curTypeName):"全站"); ?><i class="ico-more"></i></a>
                        </div>
                        <input name="app" value="public" type="hidden" />
                        <input name="mod" value="Search" type="hidden" />
                        <input name="a" value="<?php echo ($curApp); ?>" id='search_a' type="hidden"/>
                        <input name="t" value="<?php echo ($curType); ?>" id='search_t' type="hidden"/>
                        <input name="k" value="<?php echo (t($_GET['k'])); ?>" type="text" class="s-txt" onblur="this.className='s-txt'" onfocus="this.className='s-txt-focus'" autocomplete="off">
                        <a class="btn-red left" href="javascript:void(0);" onclick="$('#search_form').submit();"><span class="ico-search"></span></a>
                    </form>
                </div>
            </div>
        </div>
        <div class="mod-at-wrap" id="search_menu" ison='no' style="display:none" model-node="search_menu_ul">
        <div class="mod-at">
            <div class="mod-at-list">
                <ul class="at-user-list">
                    <li onclick="core.search.doShowCurMenu(this)" a='public' t='' typename='<?php echo L('PUBLIC_ALL_WEBSITE');?>'><?php echo L('PUBLIC_ALL_WEBSITE');?></li>
                <?php if(is_array($menuList)): ?><?php $i = 0;?><?php $__LIST__ = $menuList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$m): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php if($m['app_name'] == $curApp && $m['type_id'] == $curType){
                            $curTypeName = $m['type'];
                        } ?>
                    <li onclick="core.search.doShowCurMenu(this)" a='<?php echo ($m["app_name"]); ?>' t='<?php echo ($m["type_id"]); ?>' typename='<?php echo ($m["type"]); ?>'><?php echo ($m["type"]); ?></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>   
                </ul>
            </div>
        </div>
        </div>
       <?php endif; ?> 
    <script type="text/javascript">
    $(document).ready(function(){
        $("#mod-product dd").hover(function() {
            $(this).addClass("hover");
        }, function() {
            $(this).removeClass("hover");
        });
        core.plugInit('search');
    });

    core.plugFunc('dropnotify',function(){
        setTimeout(function(){
            core.dropnotify.init('message_list_container','message_container');
        },320);   
    });

    </script><?php endif; ?>
    </div>
<?php //出现注册提示的页面
$show_register_tips = array('public/Profile','public/Topic','weiba/Index');
if(!$mid && in_array(APP_NAME.'/'.MODULE_NAME,$show_register_tips)){ ?>
<?php $registerConf = model('Xdata')->get('admin_Config:register'); ?>
<!--未登录前-->
<div class="login-no-bg clearfix">
  <div class="login-no-box">
    <div class="left">
        <dl class="clearfix left">
            <dt><img src="__THEME__/image/smiling-face.jpg" /></dt>
            <dd><p>欢迎来到<?php echo ($site["site_name"]); ?>，</p><p>赶紧注册与朋友们分享快乐点滴吧！</p></dd>
        </dl>
        <?php if($registerConf['register_type'] == 'open'){ ?>
        <a href="<?php echo U('public/Register/index');?>" class="btn-reg">立即注册</a>
    	<?php } ?>
    </div>
    <div class="right">
        <p>已有帐号？<a href="javascript:quickLogin()">立即登录</a></p>
    </div>
  </div>
</div>
<?php } ?>
<script>
function QueryGET(TheName){
    var urlt = window.location.href.split("?");
	
	//如果是rewrite的
	if(typeof(urlt[1]) == 'undefined'){
		var urlt = window.location.href.split("/");
		var temp = new Array();
		var channel = urlt.pop();
		var temp2 = channel.split(".");
		if(typeof(temp2[1]) == 'undefined'){
			temp['page'] = 'index';
		}else{
			temp['page'] = temp2.shift();
		}
		
        var TheValue = temp[TheName];
	}else{
        var gets = urlt[1].split("&");
        
        for (var i = 0; i < gets.length; i++) {
            var get = gets[i].split("=");
            if (get[0] == TheName) {
                var TheValue = get[1];
                break;
            }
        }
	}
    return TheValue;
} 
  var page    = QueryGET('page');
  var template = '<?php echo ($template); ?>';
  $(function(){
  	$.post(SITE_URL+'/index.php?app=page&mod=Diy&act=checkUserRole',{page:page},function(result){
 		if(result == 1){
			$('body').append('<a id="openDiy" href="'+SITE_URL+'/index.php?app=page&mod=Diy&diy&page=<?php echo ($page); ?>" style="display:none"><img src="__APP__/Public/images/btn_diy.gif" /></a>');
			$.getScript('__APP__/Public/js/diy_normal.js');
		}
	 })
  })	
 
</script>
<?php if($admin && $openDiy){ ?>
<div id="diy_layout_list" style="display:none;">
    <div class="diy_1">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_1_C line_E">
        </div>
    </div>
    <div class="diy_1_1 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>布局框架
        </div>
        <div class="diy_1_1_L line_E">
        </div>
        <div class="diy_1_1_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_1_2 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>布局框架
        </div>
        <div class="diy_1_2_L line_E">
        </div>
        <div class="diy_1_2_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_2_1 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_2_1_L line_E">
        </div>
        <div class="diy_2_1_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_1_3 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_1_3_L line_E">
        </div>
        <div class="diy_1_3_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_3_1 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_3_1_L line_E">
        </div>
        <div class="diy_3_1_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_1_2_1 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_1_2_1_L line_E">
        </div>
        <div class="diy_1_2_1_C line_E">
        </div>
        <div class="diy_1_2_1_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_1_1_1 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_1_1_1_L line_E">
        </div>
        <div class="diy_1_1_1_C line_E">
        </div>
        <div class="diy_1_1_1_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_15_15_1 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_15_15_1_L line_E">
        </div>
        <div class="diy_15_15_1_C line_E">
        </div>
        <div class="diy_15_15_1_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div class="diy_1_15_15 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_1_15_15_L line_E">
        </div>
        <div class="diy_1_15_15_C line_E">
        </div>
        <div class="diy_1_15_15_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
   <div class="diy_1_12_12_1 bg_eee">
        <div class="bg_diy_tit">
            <a href="#" class="ico_diydel R mt5 mr5" title="删除" onclick='deleteDiy($(this).attr("rel"))'>删除</a>
            布局框架
        </div>
        <div class="diy_1_12_12_1_L line_E">
        </div>
        <div class="diy_1_12_12_1_C line_E">
        </div>
         <div class="diy_1_12_12_1_P line_E">
        </div>
        <div class="diy_1_12_12_1_R line_E">
        </div>
        <div class="C">
        </div>
    </div>
    <div id="placeholder" class="bg_p">
    </div>
</div>
<div id="tempDiyData" style="display:none;">
    <?php echo ($tempData); ?>
</div>
<div id="diy_adaptable" style="left:10px;top:60px;display:none;">
    <div id="diy_tab">
        <span>
            <a href="javascript:void(0)" onclick="saveLayout()"><img src="__APP__/Public/images/btn_bc.gif" /></a><a href="javascript:void(0)" onclick="previewLayout()"><img src="__APP__/Public/images/btn_yl.gif" /></a><a href="<?php echo U('page/Diy/index' , array('page'=>$page));?>"><img src="__APP__/Public/images/btn_x.gif" /></a>
        </span>
        <!--<ul>
            <li>
                自定义:
            </li>
            <li>
            	<a href="#" class="on diy_tab_list">页面排版</a>
            </li>
        </ul>-->
    </div>
    <div id="controlcontent">
        <div id="diy_nav">
            <a href="javascript:void(0);" rel="div_addFrame" class="on"><img src="__APP__/Public/images/layout.gif" />
                <br/>
                添加框架
            </a>
            <a href="javascript:void(0);" rel="div_addModel"><img src="__APP__/Public/images/module.gif" />
                <br/>
                添加模块
            </a>
        </div>
        <div id="diy_nav2">
            <div id="div_addFrame">
                <a href="javascript:void(0)" class="addFrame" rel="1"><img src="__APP__/Public/images/layout-1.gif" />
                    <br/>
                    100%框架
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="1_1"><img src="__APP__/Public/images/layout-1-1.gif" />
                    <br/>
                    1：1
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="1_2"><img src="__APP__/Public/images/layout-1-2.gif" />
                    <br/>
                    1：2
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="2_1"><img src="__APP__/Public/images/layout-2-1.gif" />
                    <br/>
                    2：1
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="3_1"><img src="__APP__/Public/images/layout-3-1.gif" />
                    <br/>
                    3：1
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="1_3"><img src="__APP__/Public/images/layout-1-3.gif" />
                    <br/>
                    1：3
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="1_2_1"><img src="__APP__/Public/images/layout-1-2-1.gif" />
                    <br/>
                    1：2：1
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="1_1_1"><img src="__APP__/Public/images/layout-1-1-1.gif" />
                    <br/>
                    1：1：1
                </a>
                 <a href="javascript:void(0)" class="addFrame" rel="15_15_1"><img src="__APP__/Public/images/layout-15-15-1.gif" />
                    <br/>
                    3：3：2
                </a>
                 <a href="javascript:void(0)" class="addFrame" rel="1_15_15"><img src="__APP__/Public/images/layout-1-15-15.gif" />
                    <br/>
                    2：3：3
                </a>
                <a href="javascript:void(0)" class="addFrame" rel="1_12_12_1"><img src="__APP__/Public/images/layout-1-12-12-1.gif" />
                    <br/>
                    5：6：6：5
                </a>
            </div>
            <div id="div_addModel" style="display:none">
                <a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiyUser">用户模块</a>
            	<a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiyWeibo">微博模块</a>
                <!-- <a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiyTopic">话题模块</a> -->
                <a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiySendFrame">发布框</a>
                <!-- <a href="javascript:void(0)" class="addModel" rel="false" namespace="W:DiyComment">评论框</a> -->
				<a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiyImage">图片模块</a>
				<a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiyVideo">视频模块</a>
				<a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiyCustom">自定义模块</a>
				<a href="javascript:void(0)" class="addModel" rel="false" namespace="w:DiyTab">tab框架</a>
            </div>
        </div>
        <div class="C">
        </div>
    </div>
</div>
<script>
var saveLayoutData = new Array();
<?php if(is_array($layoutData)): ?><?php $i = 0;?><?php $__LIST__ = $layoutData?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?>saveLayoutData['<?php echo ($key); ?>'] = new Array();
	<?php $voKey = $key; ?>
	<?php if(is_array($vo)): ?><?php $i = 0;?><?php $__LIST__ = $vo?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$so): ?><?php ++$i;?><?php $mod = ($i % 2 )?>if('object' != typeof(saveLayoutData['<?php echo ($voKey); ?>']['<?php echo ($key); ?>'])){
			saveLayoutData['<?php echo ($voKey); ?>']['<?php echo ($key); ?>'] = new Array();
		}
		<?php $soKey = $key; ?>
		<?php if(is_array($so)): ?><?php $i = 0;?><?php $__LIST__ = $so?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$no): ?><?php ++$i;?><?php $mod = ($i % 2 )?>saveLayoutData['<?php echo ($voKey); ?>']['<?php echo ($soKey); ?>'][<?php echo ($key); ?>] = '<?php echo ($no); ?>';
			var id = '<?php echo ($voKey); ?>-<?php echo ($soKey); ?>-'+parseInt(<?php echo ($key); ?>+1);<?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
var targetPage = '<?php echo ($page); ?>';
                    	
</script>
<script type="text/javascript" src="__APP__/Public/js/diy.js"></script>
<script type="text/javascript" src="__THEME__/js/ui.draggable.js"></script>
<script type="text/javascript" src="__THEME__/js/jquery-ui-1.7.2/selectable.js"></script>
<script type="text/javascript" src="__THEME__/js/jquery-ui-1.7.2/sortale.js"></script>
<script type="text/javascript" src="__THEME__/js/tsjs.json2select.js" ></script>	
<?php } ?>
<script type="text/javascript" src="__THEME__/js/jquery-ui-1.7.2/tabs.js"></script>
<script type="text/javascript" src="__THEME__/js/jquery-ui-1.7.2/accordion.js"></script>
<script type="text/javascript" src="__APP__/Public/js/tbox/tbox.js"></script>
<link type="text/css" href="__APP__/Public/js/tbox/tbox.css" rel="stylesheet"  />

<div style="height:50px"></div>
<link href="__APP__/Public/css/diy_adaptable.css" rel="stylesheet" type="text/css" />
<link href="__APP__/Public/css/index.css" rel="stylesheet" type="text/css" />
<link href="__APP__/Public/css/pop_up.css" rel="stylesheet" type="text/css" />
<div class="diy_content bg_diy">
<?php echo ($data); ?>
<div class="C"></div>
</div>
<div class="footer">
   <div class="login-footer">
      <div class="foot clearfix">
         <?php if(is_array($site_bottom_nav)): ?><?php $i = 0;?><?php $__LIST__ = $site_bottom_nav?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$nv): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dl>
            <dt><a href="<?php echo ($nv["url"]); ?>" target="<?php echo ($nv["target"]); ?>"><?php echo ($nv['navi_name']); ?></a></dt>
            <?php if(is_array($nv["child"])): ?><?php $i = 0;?><?php $__LIST__ = $nv["child"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$cv): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dd><a href="<?php echo ($cv["url"]); ?>" target="<?php echo ($cv["target"]); ?>"><?php echo ($cv['navi_name']); ?></a></dd><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
         </dl><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
      </div>
    <p>
      <span class="right">Powered By <a href="http://www.thinksns.com" title="开源微博系统,开源微社区" target="_blank">ThinkSNS</a></span>
      <?php echo ($GLOBALS["ts"]["site"]["site_footer"]); ?>
    </p>
  </div>
</div><!--footer end-->
</div><!--page end-->
<?php echo Addons::hook('public_footer');?>
<!-- 统计代码-->
<div id="site_analytics_code" style="display:none;">
<?php echo (base64_decode($site["site_analytics_code"])); ?>
</div>
<?php if(($site["site_online_count"])  ==  "1"): ?><script src="<?php echo SITE_URL;?>/online_check.php?uid=<?php echo ($mid); ?>&uname=<?php echo ($user["uname"]); ?>&mod=<?php echo MODULE_NAME;?>&app=<?php echo APP_NAME;?>&act=<?php echo ACTION_NAME;?>&action=trace"></script><?php endif; ?>
</body>
</html>