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
  <div class="page_tit">积分配置</div>
  <div class="tit_tab">
    <ul>
    <li><a href="<?php echo U('admin/Global/credit');?>" class="on">积分规则</a></li>
    <li><a href="<?php echo U('admin/Global/creditType');?>">积分类型</a></li>
    <li><a href="<?php echo U('admin/Global/creditUser');?>">设置用户积分</a></li>
    <li><a href="<?php echo U('admin/Global/creditLevel');?>">积分等级</a></li>
    </ul>
  </div>
  <div class="Toolbar_inbox">
  	<div class="page right"><?php echo ($html); ?></div>
	<a href="<?php echo U('admin/Global/addCredit');?>" class="btn_a"><span>添加规则</span></a>
	<a href="javascript:void(0);" class="btn_a" onclick="deleteCredit();"><span>删除规则</span></a>
  </div>
  
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l">ID</th>
    <th class="line_l">名称</th>
    <th class="line_l">别名</th>
    <th class="line_l">类型</th>
    <?php if(is_array($creditType)): ?><?php $i = 0;?><?php $__LIST__ = $creditType?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$ct): ?><?php ++$i;?><?php $mod = ($i % 2 )?><th class="line_l"><?php echo ($ct["alias"]); ?></th><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
    <th class="line_l">操作</th>
  </tr>
  <?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = $data?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><tr overstyle='on' id="credit_<?php echo ($vo['id']); ?>">
	    <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo ($vo["id"]); ?>"></td>
	    <td><?php echo ($vo["id"]); ?></td>
	    <td><?php echo ($vo["name"]); ?></td>
		<td><?php echo ($vo["alias"]); ?></td>
	    <td><?php echo ($vo["type"]); ?></td>
        <?php if(is_array($creditType)): ?><?php $i = 0;?><?php $__LIST__ = $creditType?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$ct): ?><?php ++$i;?><?php $mod = ($i % 2 )?><td><?php echo ($vo[$ct['name']]); ?></td><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
	    <td>
			<a href="<?php echo U('admin/Global/editCredit', array('cid'=>$vo['id']));?>">编辑</a> 
	    	<a href="javascript:void(0);" onclick="deleteCredit(<?php echo ($vo['id']); ?>);">删除</a>
		</td>
	  </tr><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
  </table>

  </div>
  <div class="Toolbar_inbox">
	<div class="page right"><?php echo ($html); ?></div>
	<a href="javascript:void(0);" class="btn_a" onclick="window.open('<?php echo U("admin/Global/addCredit");?>','_self');"><span>添加规则</span></a>
	<a href="javascript:void(0);" class="btn_a" onclick="deleteCredit();"><span>删除规则</span></a>
  </div>
</div>

<script>
	//鼠标移动表格效果
	$(document).ready(function(){
		$("tr[overstyle='on']").hover(
		  function () {
		    $(this).addClass("bg_hover");
		  },
		  function () {
		    $(this).removeClass("bg_hover");
		  }
		);
	});
	
	function checkon(o){
		if( o.checked == true ){
			$(o).parents('tr').addClass('bg_on') ;
		}else{
			$(o).parents('tr').removeClass('bg_on') ;
		}
	}
	
	function checkAll(o){
		if( o.checked == true ){
			$('input[name="checkbox"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="checkbox"]').removeAttr('checked');
			$('tr[overstyle="on"]').removeClass("bg_on");
		}
	}
	
	//获取已选择的ID数组
	function getChecked() {
		var ids = new Array();
		$.each($('table input:checked'), function(i, n){
			ids.push( $(n).val() );
		});
		return ids;
	}
	
	function deleteCredit(ids) {
		var length = 0;
	    if(ids) {
	        length = 1;         
	    }else {
	        ids    = getChecked();
	        length = ids.length;
	        ids    = ids.toString();
	    }
	    if(ids=='') {
	        ui.error('请先选择一个规则');
	        return ;
	    }
		if(ids == '' || !confirm('删除成功后将无法恢复，确认继续？')) return false;
		
		$.post("<?php echo U('admin/Global/doDeleteCredit');?>", {ids:ids}, function(res){
			if(res == '1') {
				ui.success('删除成功');
				setTimeout("location.href = location.href",1000);
				ids = ids.split(',');
				for(i = 0; i < ids.length; i++) {
					$('#credit_'+ids[i]).remove();
				}
			}else {
				ui.error('删除失败');
			}
		});
	}
</script>
</body>
</html>