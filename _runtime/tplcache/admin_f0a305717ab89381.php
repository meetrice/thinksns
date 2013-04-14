<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo ($ts['site']['site_name']); ?>管理后台</title>
<link href="__APP__/admin.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/ts2/js/tbox/box.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	var _UID_ = "<?php echo ($uid); ?>";
	var _PUBLIC_ = "__PUBLIC__";	
</script>
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/ts2/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/ts2/js/tbox/box.js"></script>
</head>
<body>

<div class="so_main">
<div class="page_tit">在线升级</div>
<div id="listInfo">
  <div class="form2">
  	 <p><b>自动升级：</b>升级功能会自动下载升级包到/data/upate目录下，并自动完成解压、文件可写权限判断、文件覆盖、数据库更新等操作。优点是一键完成，方便快捷。缺点是如果文件写权限不足，会有些文件覆盖失败。</p>
  	 <p><b>手工下载：</b>需要站长自行下载升级包，并按升级包中的readme.txt文件中操作步骤自行操作更新。</p>
  	 <p><b>注意事项：</b>升级前请注意备份好文件和数据库，特别是配置文件和/data目录下的用户数据。
	 <?php if(!empty($noWritable)) { ?>
	 以下目录没有可写权限，可能无法使用自动升级功能：
	 
	 <?php if(is_array($noWritable)): ?><?php $i = 0;?><?php $__LIST__ = $noWritable?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php echo ($vo); ?>&nbsp;<?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
	 <?php } ?>
	 
	 </p>
  </div>
</div>

<div id="showInfomation"></div>

</div>

<script type="text/javascript">
function showMsg(msg){
        $('#showInfomation').html('<div id="listInfo"><div class="content"><h3 class="center"><img src="__APP__/image/loading2.gif" class="mr10"/>'+msg+'...</h3></div></div>');
}
function needUpateOther(title){
    ui.error('您需要先升级 ' + title + ' 这个升级包后才能更新此升级包', 10);
}
function checkVersion(){
    showMsg('更新版本查询中');
    var postURL = "<?php echo U('admin/Update/step01_checkVersionByAjax');?>";
	$.post(postURL, {id:1}, function(res){
	    $('#showInfomation').html(res);
	});
}
function isDownBefore(packageName, key){
	showMsg('判断是否已经手工下载更新包');    
    var postURL = "<?php echo U('admin/Update/step02_isDownBefore');?>&packageName=" + packageName + "&key=" + key;
	$.post(postURL, {id:1}, function(res){
	    if(res==0){
		   showMsg('您还没有下载更新包，正在自动下载更新包中');    
		   downloadPackage(packageName, key);
		}else{
		   showMsg('您已经下载更新包，正在升级中');   
		   window.location.href="<?php echo U('admin/Update/index');?>&step=dealsql";
		}
	});
}
function downloadPackage(packageName, key){
	showMsg('下载更新包中...请稍等');    
    var postURL = "<?php echo U('admin/Update/step03_download');?>&packageName=" + packageName + "&key=" + key;
	$.post(postURL, {id:1}, function(res){
	    if(res==0){
		   $('#showInfomation').html('<div id="listInfo"><div class="content"><h3 class="center">更新包下载失败，请检查你的网络连接是否正常</h3></div></div>');
		}else{
		   window.location.href="<?php echo U('admin/Update/index');?>&step=unzipPackage&packageName=" + packageName;
		}
	});
}
function unzipPackage(){
    showMsg('更新包解压中');
    var packageName = "<?php echo $_GET['packageName'];?>";
	var postURL = "<?php echo U('admin/Update/step04_unzipPackage');?>&packageName=" + packageName;
	$.post(postURL, {id:1}, function(res){
	    if(res!=1){
		   $('#showInfomation').html(res);
		}else{
		   window.location.href="<?php echo U('admin/Update/index');?>&step=checkFileIsWritable&packageName=" + packageName;
		}
	});	
}
function checkFileIsWritable(){
    showMsg('判断系统文件的可写权限');
	var packageName = "<?php echo $_GET['packageName'];?>";
	var postURL = "<?php echo U('admin/Update/step05_checkFileIsWritable');?>&packageName=" + packageName;
	$.post(postURL, {id:1}, function(res){
         if(res!=1){
		   $('#showInfomation').html(res);
		}else{
		   window.location.href="<?php echo U('admin/Update/index');?>&step=copyFileToProject";
		}
	});	
}
function copyFileToProject(){
    showMsg('更新系统文件中');    
	var postURL = "<?php echo U('admin/Update/step06_overWritten');?>";
	$.post(postURL, {id:1}, function(res){
         if(res!=1){
		   $('#showInfomation').html(res);
		}else{
		   window.location.href="<?php echo U('admin/Update/index');?>&step=dealsql";
		}
	});	
}

function dealsql(){
    showMsg('更新数据库数据中');    
	var postURL = "<?php echo U('admin/Update/step07_dealSQL');?>";
	$.post(postURL, {id:1}, function(res){
	    window.location.href="<?php echo U('admin/Update/index');?>&step=finishUpate";
	});	
}

function finishUpate(){
    showMsg('正在完成升级操作');    
	var postURL = "<?php echo U('admin/Update/step08_finishUpate');?>";
	$.post(postURL, {id:1}, function(res){
	    if(res==1){
		   window.location.href="<?php echo U('admin/Update/upateAll');?>";
		}else{
		   window.location.href="<?php echo U('admin/Update/index');?>";
		}
	});
}
var step = "<?php echo $_GET['step'];?>";

if(step=='isDownBefore'){
    var packageName = "<?php echo $_GET['packageName'];?>";
    var key = "<?php echo $_GET['key'];?>";
    isDownBefore(packageName, key)
}else if(step=='unzipPackage'){
    unzipPackage();
}else if(step=='checkFileIsWritable'){
    checkFileIsWritable();
}else if(step=='copyFileToProject'){
    copyFileToProject();
}else if(step=='dealsql'){
    dealsql();
}else if(step=='finishUpate'){
    finishUpate();	
}else{
    checkVersion();
}
</script>
</body>
</html>