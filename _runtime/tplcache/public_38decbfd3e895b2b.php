<?php if (!defined('THINK_PATH')) exit();?><a href="javascript:void(0);" id="change_contribute">投稿</a>
<div class="contribute_box" type="weibotab" rel="weibotab_contribute" style="display:none; border-top:2px solid #ddd; padding:10px 0;overflow:hidden;">
<span style="display:block; padding-bottom:10px;">选择频道：</span>
	<ul class="clearfix">
	<?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = $data?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li><input type="checkbox" value="<?php echo ($vo["channel_category_id"]); ?>" id="ck<?php echo ($vo["channel_category_id"]); ?>" onclick="selectcategory()" class="check_category"><label for="ck<?php echo ($vo["channel_category_id"]); ?>"><?php echo ($vo["title"]); ?></label></li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
	</ul>
</div>
<script>
$(function (){
	$('#change_contribute').click(function (){
		$('#change_weibo_tab').removeClass('on');
		$(this).addClass('on');
		
		$('div[type="weibotab"][rel="weibotab_contribute"]').show();
		$('div[type="weibotab"][rel!="weibotab_contribute"]').hide();
	});

	$('#change_weibo_tab').click(function() {
		$('#change_contribute').removeClass('on');
		$(this).addClass('on');
	});
});
function selectcategory(){
	var cData = [];
	$('.check_category').live('click', function() {
		$('#contribute').val('');
		$('input:checked').filter('.check_category').each(function() {
			cData.push(this.value);
		});
		if(cData.length>0){
			$('#contribute').val(cData.join(','));
		}
	});
}
</script>