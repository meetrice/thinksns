<?php if (!defined('THINK_PATH')) exit();?><div id="listInfo">
   <div class="content">
   	<?php if(empty($list)) { ?>
       <h3>你当前版本已经是最新版本，不需要升级</h3>
       <?php } else { ?>
	    <h3>检测到有以下 <?php echo count($list); ?> 个新的版本可以升级，您可以选择自动升级或者下载升级包手工升级&nbsp;&nbsp;&nbsp;<a href="<?php echo U('admin/Update/upateAll');?>" title="一键自动升级全部升级包">一键升级</a></h3>
	<ul>
       <?php if(is_array($list)): ?><?php $i = 0;?><?php $__LIST__ = $list?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li class="color"><span class="right"> 
	   <?php if($nowkey==$key) { ?>
         <a href="javascript:void(0)" onclick="isDownBefore('<?php echo ($vo["package"]); ?>','<?php echo ($key); ?>')" class="btn_b">升级</a><a href="<?php echo C('TS_UPDATE_URL');?>/<?php echo ($vo["package"]); ?>" class="hand">下载</a>
		 <?php }else{ ?>
         <a href="javascript:void(0)" onclick="needUpateOther('<?php echo ($nowtitle); ?>')" class="btn_b">升级</a><a href="javascript:void(0)" onclick="needUpateOther('<?php echo ($nowtitle); ?>')" class="hand">下载</a>
		 <?php }　 ?>
		 
		 </span><?php echo ($vo["title"]); ?>
		 
          </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>	
	<?php } ?>
	 </ul>
	</div>
</div>
</div>