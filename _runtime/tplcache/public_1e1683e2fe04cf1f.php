<?php if (!defined('THINK_PATH')) exit();?><!--评论框-->
<?php if(($cancomment)  ==  "1"): ?><div class="action clearfix">
<div class="action clearfix mb10">
  <div class="num"  model-node="numsLeft"><?php echo L('PUBLIC_INPUT_CHARACTER_LIMIT',array('num'=>'<span>'.$initNums.'</span>'));?></div>
</div>
<div class="input" model-node="comment_textarea">
<div class="input_before1" model-node="mini_editor">
<textarea class="input_tips" id="comment_inputor" event-node="mini_editor_textarea" hidefocus="true"  model-args='t=comment'></textarea>
</div>
<div class="mt10">
    <a class="btn-green-small right" href="javascript:void(0);"  event-node="do_comment"  event-args='row_id=<?php echo ($row_id); ?>&app_uid=<?php echo ($app_uid); ?>&app_row_id=<?php echo ($app_row_id); ?>&app_name=<?php echo ($app_name); ?>&table=<?php echo ($table); ?>&canrepost=<?php echo ($canrepost); ?>' to_comment_id="0" to_uid="0" to_comment_uname="" addtoend='0' ><span><?php echo L('PUBLIC_STREAM_REPLY');?></span></a>
    <div class="acts">
      <a class="face-block" href="javascript:;" event-node="comment_insert_face"><i class="face"></i>表情</a>
    </div>

    <ul class="commoned_list">
    	<?php if(($canrepost)  ==  "1"): ?><li><label><input type="checkbox"  name="shareFeed" value="1" class="checkbox"><?php echo L('PUBLIC_SHARETO_STREAM');?></label></li><?php endif; ?>
      <div class="clear"></div>
      <div model-node="faceDiv"></div> 
      <?php if($feedtype == 'repost' && $cancomment_old == 1): ?>
        <li><label><input type="checkbox" class="checkbox" name="comment" value="1" />同时评论给原文作者&nbsp;<?php echo ($user_info["space_link_no"]); ?></label></li>
      <?php endif; ?>
    </ul>
    
    </div>
</div>
</div>
<?php else: ?>
<?php echo L('PUBLIC_CONCENT_ISNULL');?><?php endif; ?>

<!--评论列表-->
<?php if(($showlist)  ==  "1"): ?><div class="comment_lists">
        <?php if(is_array($list["data"])): ?><?php $i = 0;?><?php $__LIST__ = $list["data"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dl class="comment_list" model-node="comment_list">        
		<dt><a href="<?php echo ($vo["user_info"]["space_url"]); ?>"><img width="30" height="30" src="<?php echo ($vo["user_info"]["avatar_middle"]); ?>"></a></dt>        
		<dd>
    <p class="cont">
		    <?php echo ($vo["user_info"]["space_link"]); ?>
        <?php if(is_array($vo['user_info']['groupData'][$vo['user_info']['uid']])): ?><?php $i = 0;?><?php $__LIST__ = $vo['user_info']['groupData'][$vo['user_info']['uid']]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$v2): ?><?php ++$i;?><?php $mod = ($i % 2 )?><img style="width:auto;height:auto;display:inline;cursor:pointer" src="<?php echo ($v2['user_group_icon_url']); ?>" title="<?php echo ($v2['user_group_name']); ?>" />&nbsp;<?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
		    ：<em><?php if($vo['is_audit'] || $vo['uid'] == $GLOBALS['ts']['mid']){ ?><?php echo ($vo["content"]); ?><?php }else{ ?>内容正在审核<?php } ?><span class="time">(<?php echo (friendlyDate($vo["ctime"])); ?>)</span></em></p>
		<p class="info right"><span>
		<?php $isdel = 0;
		if(($vo['uid'] == $GLOBALS['ts']['mid'] && CheckPermission('core_normal','comment_del')) || CheckPermission('core_admin','comment_del')){
		$isdel = 1; ?>
		<a href="javascript:void(0);" event-node="comment_del" event-args="comment_id=<?php echo ($vo["comment_id"]); ?>" <?php if($vo['user_info']['uid'] != $GLOBALS['ts']['mid'] && CheckPermission('core_admin','comment_del')){ ?>style="color:red;"<?php } ?>><?php echo L('PUBLIC_STREAM_DELETE');?></a>
		<?php } ?>
		    <?php if( $isdel && $cancomment){ ?>
    		<i class="vline">|</i>
    		<?php } ?>
  <?php if(($cancomment)  ==  "1"): ?><a href="javascript:void(0)" event-args='row_id=<?php echo ($vo["row_id"]); ?>&app_uid=<?php echo ($vo["app_uid"]); ?>&to_comment_id=<?php echo ($vo["comment_id"]); ?>&to_uid=<?php echo ($vo["uid"]); ?>&to_comment_uname=<?php echo ($vo["user_info"]["uname"]); ?>&app_name=<?php echo ($app_name); ?>&table=<?php echo ($table); ?>' 
			event-node="reply_comment"><?php echo L('PUBLIC_STREAM_REPLY');?></a><?php endif; ?>
    </span></p>
		</dd>
    <span class="floor"><?php echo ($vo["storey"]); ?>楼</span>
		</dl><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?> 
   
    <!--页码-->
   <?php if(($list["html"])  !=  ""): ?><div id="page" class="page">
      <?php echo ($list["html"]); ?>
   </div><?php endif; ?>
   <!--页码/end-->
</div><?php endif; ?>

<script>
var initNums = '<?php echo ($initNums); ?>';
atWho($("#comment_inputor"));
</script>