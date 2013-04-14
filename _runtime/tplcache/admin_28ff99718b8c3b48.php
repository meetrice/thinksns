<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo APPS_URL;?>/admin/_static/admin.css" rel="stylesheet" type="text/css">
<script>
/**
 * 全局变量
 */
var SITE_URL  = '<?php echo SITE_URL; ?>';
var THEME_URL = '__THEME__';
var APPNAME   = '<?php echo APP_NAME; ?>';
var UPLOAD_URL ='<?php echo UPLOAD_URL;?>';
var MID		  = '<?php echo $mid; ?>';
var UID		  = '<?php echo $uid; ?>';
// Js语言变量
var LANG = new Array();
</script>
<script type="text/javascript" src="__THEME__/js/jquery.js"></script>
<script type="text/javascript" src="__THEME__/js/core.js"></script>
<script src="__THEME__/js/module.js"></script>
<script src="__THEME__/js/common.js"></script>
<script src="__THEME__/js/module.common.js"></script>
<script src="__THEME__/js/module.weibo.js"></script>
<script type="text/javascript" src="<?php echo APPS_URL;?>/admin/_static/admin.js?t=11"></script>
<script type="text/javascript" src = "__THEME__/js/ui.core.js"></script>
<script type="text/javascript" src = "__THEME__/js/ui.draggable.js"></script>
<?php /* 非admin应用的后台js脚本统一写在  模板风格对应的app目录下的admin.js中*/
if(APP_NAME != 'admin' && file_exists(APP_PUBLIC_PATH.'/admin.js')){ ?>
<script type="text/javascript" src="<?php echo APP_PUBLIC_URL;?>/admin.js"></script>
<?php } ?>
<?php if(!empty($langJsList)) { ?>
<?php if(is_array($langJsList)): ?><?php $i = 0;?><?php $__LIST__ = $langJsList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><script src="<?php echo ($vo); ?>"></script><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
<?php } ?>
</head>
<body>
<div id="container" class="so_main">
  <div class="page_tit"><?php echo L('PUBLIC_MAILTITLE_ADMIN');?></div>


   <!-- START TAB框 -->
  <?php if(!empty($pageTab)): ?>
  <div class="tit_tab">
    <ul>
    <?php !$_REQUEST['tabHash'] && $_REQUEST['tabHash'] =  $pageTab[0]['tabHash']; ?>
    <?php if(is_array($pageTab)): ?><?php $i = 0;?><?php $__LIST__ = $pageTab?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$t): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><a href="<?php echo ($t["url"]); ?>&tabHash=<?php echo ($t["tabHash"]); ?>" <?php if($t['tabHash'] == $_REQUEST['tabHash']){ echo 'class="on"';} ?>><?php echo ($t["title"]); ?></a></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    </ul>
  </div>
  <?php endif; ?>
  <!-- END TAB框 -->

<div class="list">
  <form action="<?php echo U('admin/Config/saveNotifyNode');?>" method='POST'>
  <input type="hidden" name="tabhash" value="<?php echo ($_REQUEST['tabHash']); ?>"/>
  <input type="hidden" name="type" value="<?php echo ($type); ?>" />
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <th class="line_l" width="20%"><?php echo L('PUBLIC_POINT_NAME');?></th>
        <th class="line_l" width="10%"><?php echo L('PUBLIC_POINT_DETAIL');?></th>
        <th class="line_l" width="10%"><?php echo L('PUBLIC_APP_TO');?></th>
        <th class="line_l"><?php echo L('PUBLIC_SENTTYPE');?></th>
        <th class="line_l"><?php echo L('PUBLIC_OPERATION');?></th>
      </tr>
    <?php if(is_array($nodeList)): ?><?php $i = 0;?><?php $__LIST__ = $nodeList?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><tr>
       <td><?php echo ($vo["node"]); ?></td>
       <td><?php echo ($vo["nodeinfo"]); ?></td>
       <td><?php echo ($vo["appname"]); ?></td>
       <td>
        <input type="hidden" name="sendType[<?php echo ($vo['node']); ?>][type]" value="<?php echo ($vo['node']); ?>">
        <label><input type='checkbox' name="sendType[<?php echo ($vo['node']); ?>][send_email]"  value='1' <?php if(($vo["send_email"])  ==  "1"): ?>checked='checked'<?php endif; ?>><?php echo L('PUBLIC_SNED_EMAIL');?></label> 
        <label><input type='checkbox' name="sendType[<?php echo ($vo['node']); ?>][send_message]" value='1' <?php if(($vo["send_message"])  ==  "1"): ?>checked='checked'<?php endif; ?>><?php echo L('PUBLIC_SEND_SYSTEM_MESSAGE');?></label></td> 
        <td><a href="<?php echo U('admin/Config/notifytpl',array('node'=>$vo['node'],'tabHash'=>'notifytpl','redirectTabHash'=>$_REQUEST['tabHash'],'type'=>$type));?>"><?php echo L('PUBLIC_EDIT_TPL');?></a></td>
    </tr><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
  </table>
    
    <div class="page_btm">
      <input class="btn_b" value="<?php echo L('PUBLIC_SAVE');?>" name='sub' type="submit">
    </div>
  </form>
</div>
</div>
<?php if(!empty($onload)){ ?>
<script type="text/javascript">
/**
 * 初始化对象
 */
//表格样式
$(document).ready(function(){
    <?php foreach($onload as $v){ echo $v,';';} ?>
});
</script>
<?php } ?>
</body>
</html>