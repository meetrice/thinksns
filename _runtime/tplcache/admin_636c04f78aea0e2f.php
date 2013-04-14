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
<div class="so_main">
<script>
function sureSearchDenounce(){
	var id = $('#id').val();
	var uid = $('#uid').val();
	var fuid = $('#fuid').val();
    var from = $('#from').val();
	var state = $('#state').val();
    var str_get = '&id='+id+'&uid='+uid+'&fuid='+fuid+'&state='+state;
	var url = "<?php echo U('admin/Content/denounce');?>";
	location.href = url + str_get;
}
</script>
  <div class="page_tit"><?php echo L('PUBLIC_REPORT_MANAGEMENT');?></div>
  <div class="tit_tab">
    <ul>
    <li><a <?php if(($state)  ==  "0"): ?>class="on"<?php endif; ?> href="<?php echo U('admin/Content/denounce','state=0');?>"><?php echo L('PUBLIC_WAIT_OPERATION');?></a></li>
    <li><a <?php if(($state)  ==  "1"): ?>class="on"<?php endif; ?> href="<?php echo U('admin/Content/denounce','state=1');?>"><?php echo L('PUBLIC_RECYCLE_BIN');?></a></li>
    </ul>
  </div>
  <div id="search_div" <?php if(($isSearch)  !=  "1"): ?>style="display:none;"<?php endif; ?>>
    <div class="page_tit"><?php echo L('PUBLIC_SEARCH_REPORT');?> [ <a href="javascript:void(0);" onclick="searchDenounce();"><?php echo L('PUBLIC_HIDDEN');?></a> ]</div>
    <div class="form2">
    <input type="hidden" name="isSearch" value="1" class="s-txt" style="width:300px"/>
    <dl class="lineD">
      <dt>ID：</dt>
      <dd>
        <input id="id" type="text" value="<?php echo ($id); ?>" class="s-txt" style="width:300px">
        <p><?php echo L('PUBLIC_MULTIPLE_TIPS');?></p>
      </dd>
    </dl>
    
    <?php if($isSearch != 1) $uid = ''; ?>
    <dl class="lineD">
      <dt><?php echo L('PUBLIC_STREAM_REPORT_ID');?>：</dt>
      <dd>
        <input id="uid" type="text" value="<?php echo ($uid); ?>" class="s-txt" style="width:300px">
        <p><?php echo L('PUBLIC_STREAM_REPORT_ID');?>，<?php echo L('PUBLIC_MULTIPLE_TIPS');?></p>
      </dd>
    </dl>
    
    <dl class="lineD">
      <dt>被举报人ID：</dt>
      <dd>
      	<input type="text" id="fuid" value="<?php echo ($fuid); ?>"  class="s-txt" style="width:300px"/>
        <p>被举报人ID，多个时使用英文的“,”分割</p>
      </dd>
    </dl>
    <input type="hidden" value="<?php echo ($state); ?>" id="state" />
    <div class="page_btm">
      <input type="submit" class="btn_b" value="<?php echo L('PUBLIC_CONFIRM');?>" onclick="sureSearchDenounce();"/>
    </div>
  </div>
  </div>
  <div class="Toolbar_inbox">
    <div class="page right"><?php echo ($html); ?></div>
    <a href="javascript:void(0);" class="btn_a" onclick="searchDenounce();">
        <span class="search_action"><?php if(($isSearch)  !=  "1"): ?><?php echo L('PUBLIC_SEARCH_REPORT');?><?php else: ?><?php echo L('PUBLIC_SEARCH_FINISHIED');?><?php endif; ?></span>
    </a>
    <a href="javascript:void(0);" class="btn_a" onclick="passReview();"><span><?php echo L('PUBLIC_REVOKE_REPORT');?></span></a>
    <a href="javascript:void(0);" class="btn_a" onclick="deleteRecord('', '<?php echo ($state); ?>');"><span>删除内容</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">ID</th>
    <th class="line_l"><?php echo L('PUBLIC_STREAM_REPORT_ID');?></th>
    <th class="line_l"><?php echo L('PUBLIC_FORMANTS_USER_NAME');?></th>
    <th class="line_l"><?php echo L('PUBLIC_COME_FROM');?></th>
    <th class="line_l" width="350"><?php echo L('PUBLIC_FORMANTS_USER_INFO');?></th>
    <th class="line_l" width="200"><?php echo L('PUBLIC_REPORT_REASON');?></th>
    <th class="line_l"><?php echo L('PUBLIC_FORMANTS_USER_TIME');?></th>
    <th class="line_l"><?php echo L('PUBLIC_OPERATION');?></th>
  </tr>
  <?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = $data?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php $fuserInfo = model('User')->getUserInfo($vo['fuid']);
  	$userInfo = model('User')->getUserInfo($vo['uid']); ?>
      <tr overstyle='on' id="Denounce_<?php echo ($vo["id"]); ?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo ($vo["id"]); ?>"></td>
        <td><?php echo ($vo["id"]); ?></td>
        <td><?php echo ($vo["uid"]); ?></td>
        <td><?php if( $vo['uid']=='0' ){ echo '<font color=red>'.L('PUBLIC_SYSTEM_AUTOMATIC').'</font>'; }else{ echo( $userInfo['uname'] ); } ?></td>
        <td><?php echo ($vo["from"]); ?></td>
        <td><?php echo L('PUBLIC_STREAM_REPORT_UID');?>：<?php echo ($vo["fuid"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo L('PUBLIC_INFORMANTS_USER_NAME');?>：<?php echo ($fuserInfo["uname"]); ?><hr /><?php echo L('PUBLIC_REPORT_FRONT_WORDS');?>：<?php echo ($vo["content"]); ?>
        <a href="<?php echo ($vo["source_url"]); ?>" target="_blank"><?php echo L('PUBLIC_ORIGINAL_INFORMATION');?></a>
        </td>
        <td><?php echo ($vo["reason"]); ?></td>
        <td><?php echo (date("Y-m-d H:i:s",$vo["ctime"])); ?></td>
        <td>
        <?php if(($state)  ==  "0"): ?><a href="javascript:void(0);" onclick="passReview('<?php echo ($vo["id"]); ?>');"><?php echo L('PUBLIC_REVOKE_REPORT');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	        <a href="javascript:void(0);" onclick="deleteRecord('<?php echo ($vo["id"]); ?>')">删除内容</a><?php endif; ?>
	    <?php if(($state)  ==  "1"): ?><a href="javascript:void(0);" onclick="passReview('<?php echo ($vo["id"]); ?>');"><?php echo L('PUBLIC_REVOKE_REPORT');?></a><?php endif; ?>
	    <?php if(($state)  ==  "2"): ?><a href="javascript:void(0);" onclick="deleteRecord('<?php echo ($vo["id"]); ?>')">删除内容</a><?php endif; ?>
        </td>
      </tr><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
  </table>
  </div>
  <div class="Toolbar_inbox">
    <div class="page right"><?php echo ($html); ?></div>
    <a href="javascript:void(0);" class="btn_a" onclick="searchDenounce();">
        <span class="search_action"><?php if(($isSearch)  !=  "1"): ?><?php echo L('PUBLIC_SEARCH_REPORT');?><?php else: ?><?php echo L('PUBLIC_SEARCH_FINISHIED');?><?php endif; ?></span>
    </a>
    <a href="javascript:void(0);" class="btn_a" onclick="passReview();"><span><?php echo L('PUBLIC_REVOKE_REPORT');?></span></a>
    <a href="javascript:void(0);" class="btn_a" onclick="deleteRecord('', '<?php echo ($state); ?>');"><span>删除内容</span></a>
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

    //获取已选择用户的ID数组
    function getChecked() {
        var ids = new Array();
        $.each($('table input:checked'), function(i, n){
            ids.push( $(n).val() );
        });
        return ids;
    }
    
    function deleteRecord(ids, state) {
        var length = 0;
    	if(ids) {
    		length = 1;    		
    	}else {
    		ids    = getChecked();
    		length = ids.length;
            ids    = ids.toString();
    	}
    	
    	if(ids=='') {
    		ui.error('<?php echo L('PUBLIC_STREAM_REPORT_PLEASE_SELECT');?>');
    		return ;
    	}
    	if(confirm(L('PUBLIC_DELETE_NUMBER_TIPES',{'num':length}))) {
    		$.post("<?php echo U('admin/Content/doDeleteDenounce');?>",{ids:ids, state:state},function(res){
    			if(res=='1') {
    				ui.success('<?php echo L('PUBLIC_DELETE_SUCCESS');?>');
    				removeItem(ids);
    			}else {
    				ui.error('<?php echo L('PUBLIC_DELETE_FAIL');?>');
    			}
    		});
    	}
    }
    
    function passReview(ids){
    	var length = 0;
    	if(ids) {
    		length = 1;    		
    	}else {
    		ids    = getChecked();
    		length = ids.length;
            ids    = ids.toString();
    	}
    	
    	if(ids=='') {
    		ui.error('<?php echo L('PUBLIC_STREAM_REPORT_PLEASE_SELECT');?>');
    		return ;
    	}
    	if(confirm(L('PUBLIC_UNSET_TIPES',{'num':length}))) {
    		$.post("<?php echo U('admin/Content/doReviewDenounce');?>",{ids:ids},function(res){
    			if(res=='1') {
    				ui.success('<?php echo L('PUBLIC_ADMIN_OPRETING_SUCCESS');?>');
    				removeItem(ids);
    			}else {
    				ui.error('<?php echo L('PUBLIC_ADMIN_OPRETING_ERROR');?>');
    			}
    		});
    	}
    }
    
    function removeItem(ids) {
    	ids = ids.split(',');
        for(i = 0; i < ids.length; i++) {
            $('#Denounce_'+ids[i]).remove();
        }
    }
    
    //搜索用户
    var isSearchHidden = <?php if(($isSearch)  !=  "1"): ?>1<?php else: ?>0<?php endif; ?>;
    function searchDenounce() {
        if(isSearchHidden == 1) {
            $("#search_div").slideDown("fast");
            $(".search_action").html("<?php echo L('PUBLIC_SEARCH_FINISHIED');?>");
            isSearchHidden = 0;
        }else {
            $("#search_div").slideUp("fast");
            $(".search_action").html("<?php echo L('PUBLIC_SEARCH_REPORT');?>");
            isSearchHidden = 1;
        }
    }
</script>

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