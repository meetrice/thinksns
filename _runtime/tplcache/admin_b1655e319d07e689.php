<?php if (!defined('THINK_PATH')) exit();?><div>
<?php if(($inForm)  !=  "1"): ?><FORM style='display:inline;padding:0;margin:0;border:0' enctype="multipart/form-data"><?php endif; ?>
 <input type="file" name="<?php echo ($inputname); ?>" inputname="<?php echo ($inputname); ?>" onchange="core.plugInit('uploadFile',this,<?php echo ($callback); ?>,'<?php echo ($uploadType); ?>');" urlquery='<?php echo ($urlquery); ?>' event-node="uploadinput" >
<?php if(($inForm)  !=  "1"): ?></FORM><?php endif; ?>
</div>

<?php if(!empty($attachInfo)){ ?>

<script type="text/javascript">
M.addEventFns({
	uploadinput:{
		load:function(){
			var _this = this;
			core.plugFunc('uploadFile',function(){
				core.uploadFile.init(_this,<?php echo $callback; ?>,'<?php echo $uploadType; ?>');
			});
		}
	}	
});
</script>

<div uploadcontent="file" class="input-content" >
<ul class="weibo-file-list">
<?php if(is_array($attachInfo)): ?><?php $i = 0;?><?php $__LIST__ = $attachInfo?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$a): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><i class="ico-<?php echo ($a["extension"]); ?>-small"></i>
	<a onclick="core.uploadFile.removeAttachId(this,'file',<?php echo ($a["attach_id"]); ?>)" href="javascript:void(0)" class="ico-close right"></a>
	<a href="<?php echo U('widget/Upload/down',array('attach_id'=>$a['attach_id']));?>"><?php echo ($a["name"]); ?></a><span>(<?php echo (byte_format($a["size"])); ?>)</span></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
</ul>
<input type="hidden" id="<?php echo ($inputname); ?>_ids" name="<?php echo ($inputname); ?>_ids" feedtype="file" value="|<?php echo ($attachIds); ?>|" class="attach_ids">
</div>	

<?php } ?>