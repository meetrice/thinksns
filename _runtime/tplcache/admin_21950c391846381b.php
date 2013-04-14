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
  <!-- 备份选项 -->
  <div id="begin_backup" style="display:none;">
    <div class="page_tit">备份选项 [ <a href="javascript:void(0);" onclick="$('#begin_backup').slideUp();">隐藏</a> ]</div>
    
    <div class="form2">
    <form method="post" action="<?php echo U('admin/Tool/doBackUp');?>">
    <dl class="lineD">
      <dt>选项: </dt>
      <dd>
        <input name="backup_type" type="radio" value="all" checked onclick="$('#backup_size').removeClass('lineD');$('#backup_table').slideUp();">全部备份<br/>
        <input name="backup_type" type="radio" value="custom" onclick="$('#backup_size').addClass('lineD');$('#backup_table').slideDown();">选择备份
      </dd>
    </dl>
    <dl class="" id="backup_size">
      <dt>分卷大小: </dt>
      <dd>
        <input type="text" name="sizelimit" value="10000"> K
      </dd>
    </dl>
    <dl class="" id="backup_table" style="display:none">
        <dt>数据库表: </dt>
        <dd>
        <?php if(is_array($table)): ?><?php $i = 0;?><?php $__LIST__ = $table?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><input type="checkbox" name="backup_table[]" value="<?php echo ($vo["Name"]); ?>"><?php echo ($vo["Name"]); ?> ( <?php echo (formatsize($vo['Data_length'])); ?> )<br/><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
        </dd>
    </dl>
    <div class="page_btm">
      <input type="submit" class="btn_b" value="确定" />
    </div>
    </form>
  </div>
  </div>
  
  <div class="page_tit">数据备份</div>
  <div class="Toolbar_inbox">
    <a href="javascript:void(0);" class="btn_a" onclick="$('#begin_backup').slideDown();"><span>开始备份</span></a>
    <a href="javascript:void(0);" class="btn_a" onclick="delsql();"><span>删除备份</span></a>
  </div>
  
  <div class="list">
  <table id="backup_list" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">文件名(data/database/...)</th>
    <th class="line_l">备份时间</th>
    <th class="line_l">文件大小</th>
    <th class="line_l">操作</th>
  </tr>
  <?php if(is_array($log)): ?><?php $i = 0;?><?php $__LIST__ = $log?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php $filename = substr($vo['filename'], 0, -4); ?>
      <tr overstyle='on' id="backup_<?php echo ($filename); ?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo ($filename); ?>"></td>
        <td><a href="<?php echo DATA_URL.'/database/'.$vo['filename']; ?>" target="_blank"><?php echo ($vo["filename"]); ?></a></td>
        <td><?php echo ($vo["addtime"]); ?></td>
        <td><?php echo ($vo["filesize"]); ?></td>
        <td>
          <a href="<?php echo U('admin/Tool/doDownload', array('filename'=>$vo['filename']));?>">下载</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" onclick="importsql('<?php echo ($vo['filename']); ?>');">导入</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delsql('<?php echo ($filename); ?>');">删除</a>
        </td>
      </tr><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
  </table>

  </div>
  <div class="Toolbar_inbox">
    <a href="javascript:void(0);" class="btn_a" onclick="$('#begin_backup').slideDown();"><span>开始备份</span></a>
    <a href="javascript:void(0);" class="btn_a" onclick="delsql();"><span>删除备份</span></a>
  </div>
</div>

<script>
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

    //获取已选择用户的ID数组
    function getChecked() {
        var gids = new Array();
        $.each($('input:checked'), function(i, n){
            gids.push( $(n).val() );
        });
        return gids;
    }

    //删除备份文件
    function delsql(bid) {
        var bid = bid ? bid : getChecked();
        bid = bid.toString();
        if(bid == 'all' || bid =="all,0"){
            ui.error("请选择要删除的备份文件");
        	return false;
        }
        if(confirm('删除后无法恢复，确定删除？')){
            //提交删除
            $.post("<?php echo U('admin/Tool/doDeleteBackUp');?>", {selected:bid}, function(res){
                if(res == '1') {
                    bid = bid.split(',');
                    $.each(bid, function(i,n){
                        $('#backup_'+n).remove();
                    });
                    ui.success('删除成功');
                }else {
                    ui.error('删除失败');
                }
            });
        }
    }
    
    function importsql( filename ){
    	if(!confirm('导入后数据库数据将被完全覆盖，确定导入？'))
        	return false;

    	window.location.href = "<?php echo U('admin/Tool/import');?>&filename=" + filename;
    }

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
</script>

</body>
</html>