<?php if (!defined('THINK_PATH')) exit();?><?php if(is_array($user)): ?><?php $i = 0;?><?php $__LIST__ = $user?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><dl model-node="related_dl">
		<dt><a event-node="face_card" uid="<?php echo ($vo["userInfo"]["uid"]); ?>" href="<?php echo ($vo["userInfo"]["space_url"]); ?>" title="<?php echo ($vo["userInfo"]["uname"]); ?>" class="face"><img src="<?php echo ($vo["userInfo"]["avatar_small"]); ?>" /></a></dt>
        <dd>
            <div class="right"><?php echo W('FollowBtn', array('fid'=>$vo['userInfo']['uid'], 'uname'=>$vo['userInfo']['uname'], 'follow_state'=>$vo['followState'], 'refer'=>'following_right'));?></div>
            <p><span><a event-node="face_card" uid="<?php echo ($vo["userInfo"]["uid"]); ?>" target="_blank" href="<?php echo ($vo["userInfo"]["space_url"]); ?>"><?php echo (getShort($vo["userInfo"]["uname"],7)); ?></a></span></p>
            <p><a class="f3"<?php if(!empty($vo['info']['extendMsg'])): ?> event-node="show_extend_msg"<?php endif; ?>><?php echo ($vo["info"]["msg"]); ?><?php if(!empty($vo['info']['extendMsg'])): ?><i class="arrow-down-grey"></i><?php endif; ?></a></p>
        </dd>
        <dd class="att-box"><i class="arrow-y"></i><p><?php echo ($vo["info"]["extendMsg"]); ?></p></dd>
    </dl><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>