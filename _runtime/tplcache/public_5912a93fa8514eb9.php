<?php if (!defined('THINK_PATH')) exit();?><div class="attention mb20 clearfix border-b" model-node="related_list">
	<a href="javascript:;" event-node="change_related" event-args="uid=<?php echo ($uid); ?>&limit=<?php echo ($limit); ?>" id="changerelated" class="right">换一换</a><h3><?php echo ($title); ?></h3>
    <?php if(is_array($user)): ?><?php $i = 0;?><?php $__LIST__ = $user?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dl model-node="related_dl">
    		<dt><a event-node="face_card" uid="<?php echo ($vo[userInfo]['uid']); ?>" href="<?php echo ($vo["userInfo"]["space_url"]); ?>" class="face"><img src="<?php echo ($vo["userInfo"]["avatar_small"]); ?>" width="50" height="50"/></a></dt>
            <dd>
                <div class="right"><?php echo W('FollowBtn', array('fid'=>$vo['userInfo']['uid'], 'uname'=>$vo['userInfo']['uname'], 'follow_state'=>$vo['followState'], 'refer'=>'following_right'));?></div>
                <p><span><a event-node="face_card" uid="<?php echo ($vo["userInfo"]["uid"]); ?>" target="_blank" href="<?php echo ($vo["userInfo"]["space_url"]); ?>"><?php echo (getShort($vo["userInfo"]["uname"],7)); ?></a></span></p>
                <p><a class="f3" <?php if(!empty($vo['info']['extendMsg'])): ?> event-node="show_extend_msg"<?php endif; ?>><?php echo ($vo["info"]["msg"]); ?><?php if(!empty($vo['info']['extendMsg'])): ?><i class="arrow-down-grey"></i><?php endif; ?></a></p>
            </dd>
            <dd class="att-box"><i class="arrow-y"></i><p><?php echo ($vo["info"]["extendMsg"]); ?></p></dd>
        </dl><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
</div>

<script type="text/javascript">
// 事件监听
M.addModelFns({
    related_list: {
        load: function() {
            $(this).find('dl').each(function(i, n) {
                if(i != 0) {
                    $(this).find('dd').last().css('display', 'none');
                } else {
                    var extendMsg = $(this).find('dd').last().find('p').html();
                    if(extendMsg === '') {
                        $(this).find('dd').last().css('display', 'none');
                    } else {
                        $(this).find("i").eq(0)[0].className = "arrow-up-grey";
                    }
                }
            });
        }
    }
});
$(function (){
	setTimeout(function (){
		$('#changerelated').click();
	},100)
});
// 事件绑定
M.addEventFns({
    // 换一换操作
    change_related: {
        click: function() {
            var args = M.getEventArgs(this);
            var _model = M.getModels('related_list');
            $.post(U('widget/RelatedUser/changeRelate'), {uid:args.uid, limit:args.limit}, function(data) {
                var html = '<a href="javascript:;" event-node="change_related" event-args="uid=<?php echo ($uid); ?>&limit=<?php echo ($limit); ?>" class="right">换一换</a><h3><?php echo ($title); ?></h3>';
                html += data;
                $(_model).html(html);
                M($(_model)[0]);
            }, 'json');
            return false ;
        }
    },
    // 显示更多信息操作
    show_extend_msg: {
        click: function() {
            var extendMsgObj = $(this.parentModel).find('dd').last();
            if(extendMsgObj.css('display') == 'none') {
                extendMsgObj.css('display', 'block');
                $(this).find("i").eq(0)[0].className = "arrow-up-grey";
            } else {
                extendMsgObj.css('display', 'none');
                $(this).find("i").eq(0)[0].className = "arrow-down-grey";
            }
            return false;
        }
    }
});
</script>