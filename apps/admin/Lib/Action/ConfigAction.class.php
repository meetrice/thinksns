<?php
/**
 * 后台，系统配置控制器
 * @author jason <yangjs17@yeah.net> 
 * @version TS3.0
 */
// 加载后台控制器
tsload(APPS_PATH.'/admin/Lib/Action/AdministratorAction.class.php');

class ConfigAction extends AdministratorAction {

	/**
	 * 初始化，页面标题，用于双语
	 */
	public function _initialize() {
		parent::_initialize();
		$this->pageTitle['site'] = L('PUBLIC_WEBSITE_SETTING');
		$this->pageTitle['register'] = L('PUBLIC_REGISTER_SETTING');
		$this->pageTitle['invite'] = L('PUBLIC_INVITE_CONFIG');
		$this->pageTitle['announcement'] = L('PUBLIC_ANNOUNCEMENT_SETTING');
		$this->pageTitle['email'] = L('PUBLIC_EMAIL_SETTING');
		$this->pageTitle['audit'] = L('PUBLIC_FILTER_SETTING');
		$this->pageTitle['footer'] = L('PUBLIC_FOOTER_CONFIG');
		$this->pageTitle['feed'] = L('PUBLIC_WEIBO_SETTING');
		$this->pageTitle['nav'] = L('PUBLIC_NAVIGATION_SETTING');
		$this->pageTitle['footNav'] = L('PUBLIC_NAVIGATION_SETTING');
		$this->pageTitle['navAdd'] = ( $_GET['id'] && !$_GET['type'] ) ? '编辑导航':'增加导航';
		$this->pageTitle['lang'] = L('PUBLIC_LANGUAGE');
		$this->pageTitle['diylist'] = L('PUBLIC_DIYWIDGET');
		$this->pageTitle['notify']  =  L('PUBLIC_MAILTITLE_ADMIN');
		$this->pageTitle['invite'] = '邀请配置';
		$this->pageTitle['inviteEmail'] = '邮件邀请';
		$this->pageTitle['inviteLink'] = '链接邀请';
		$this->pageTitle['getInviteAdminList'] = '已邀请用户列表';
		$this->pageTitle['setSeo'] = 'SEO配置';
		$this->pageTitle['editSeo'] = '编辑SEO';
		parent::_initialize();
	}

	/**
	 * 系统配置 - 站点配置
	 */
	public function site() {
		$this->pageKeyList = array('site_closed','site_name','site_slogan','site_header_keywords','site_header_description',
			'site_company','site_footer','site_logo','login_bg','site_closed_reason','sys_domain',
			'sys_nickname','sys_email','home_page','sys_version','site_online_count','site_rewrite_on','site_analytics_code');
		// 其他额外需要的数据,如checkbox 数组,select选项组的key->value赋值
		$this->opt['site_closed'] = $this->opt['site_online_count'] = $this->opt['site_rewrite_on'] = array('1'=>L('PUBLIC_OPEN'),'0'=>L('PUBLIC_CLOSE'));
		$apps = model('App')->where('status=1')->findAll();
		$this->opt['home_page'][0] = L('PUBLIC_MY_HOME');
		foreach($apps as $k=>$v){
			$this->opt['home_page'][$v['app_id']] = $v['app_alias'];
		}
		$detailData = model('Xdata')->get($this->systemdata_list.":".$this->systemdata_key);
		if(isset($detailData['site_analytics_code']) && !empty($detailData['site_analytics_code'])){
		    $detailData['site_analytics_code'] = base64_decode($detailData['site_analytics_code']);
		}

		$logo = $GLOBALS['ts']['site']['logo'];
		$filesShow['site_logo'] = '<img src="'.$logo.'">';

		$this->assign('filesShow',$filesShow);	
		
		$this->onload[] = 'admin.siteConfigDefault('.$detailData['site_closed'].')';

		$this->displayConfig($detailData);
	}

	/**
	 * 系统配置 - 注册配置
	 */
	public function register() {
		$this->pageKeyList = array('register_type', 'email_suffix', 'captcha', 'register_audit', 'need_active', 'photo_open', 'need_photo', 'tag_open', 'tag_num', 'interester_open', 'interester_rule', 'interester_recommend', 'default_follow', 'each_follow', 'default_user_group','welcome_email');
		// 指定邮箱后缀，任何邮箱后缀，关闭注册
		$this->opt['register_type'] = array('open'=>'开放注册', 'invite'=>'仅邀请注册', 'admin'=>'仅管理员邀请注册', 'other'=>'仅第三方帐号绑定');
		// 开启，关闭
		$this->opt['register_audit'] = $this->opt['captcha'] = array(1=>L('PUBLIC_OPEN'),0=>L('PUBLIC_CLOSE'));
		// 是，否
		$this->opt['need_active'] = array(1=>L('PUBLIC_OPEN'),0=>L('PUBLIC_CLOSE'));
		$this->opt['photo_open'] = array(1=>L('PUBLIC_OPEN'),0=>L('PUBLIC_CLOSE'));
		$this->opt['need_photo'] = array(1=>'是，强制上传 ',0=>'否，可跳过 ');
		$this->opt['tag_open'] = array(1=>L('PUBLIC_OPEN'),0=>L('PUBLIC_CLOSE'));
		$this->opt['interester_open'] = array(1=>L('PUBLIC_OPEN'),0=>L('PUBLIC_CLOSE'));
		//$this->opt['interester_rule'] = array('area'=>'按地区匹配', 'tag'=>'按标签匹配', 'face'=>'过滤无头像用户');
		$this->opt['interester_rule'] = array('area'=>'按地区匹配', 'tag'=>'按标签匹配');
		$this->opt['welcome_email'] = array(1=>L('PUBLIC_OPEN'),0=>L('PUBLIC_CLOSE'));
		// 用户组信息
		$this->opt['default_user_group'] = model('UserGroup')->getHashUsergroup();

		$detailData = model('Xdata')->get($this->systemdata_list.":".$this->systemdata_key);
		$this->onsubmit = 'admin.checkRegisterConfig(this)';
		$this->displayConfig();
	}

	/*** 邀请配置 ***/
	/**
	 * 初始化邀请Tab项目
	 * @return void
	 */
	private function _initTabInvite()
	{
		// Tab选项
		$this->pageTab[] = array('title'=>'邀请配置','tabHash'=>'invite','url'=>U('admin/Config/invite'));
        $this->pageTab[] = array('title'=>'邮件邀请','tabHash'=>'inviteEmail','url'=>U('admin/Config/inviteEmail'));
        $this->pageTab[] = array('title'=>'链接邀请','tabHash'=>'inviteLink','url'=>U('admin/Config/inviteLink'));
        $this->pageTab[] = array('title'=>'已邀请用户列表','tabHash'=>'getInviteAdminList','url'=>U('admin/Config/getInviteAdminList'));
	}

	/**
	 * 系统配置 - 邀请配置
	 * @return void
	 */
	public function invite()
	{
		$this->_initTabInvite();
		$this->pageKeyList = array('send_email_num', 'send_link_num');
		$this->displayConfig();
	}

	/**
	 * 邮件邀请 - 管理员
	 * @return void
	 */
	public function inviteEmail()
	{
		$this->_initTabInvite();
		// 获取已邀请用户信息
		$inviteList = model('Invite')->getInviteUserList($this->mid, 'email', true);
		// 获取邀请人信息
		$uids = getSubByKey($inviteList['data'], 'inviter_uid');
		$userInfos = model('User')->getUserInfoByUids($uids);
		foreach($inviteList['data'] as &$value) {
			$value['inviteInfo'] = $userInfos[$value['inviter_uid']];
		}
		$this->assign('inviteList', $inviteList);

		$this->display('invite_email');
	}

	/**
	 * 管理员邮件邀请操作
	 * @return json 操作后的相关数据
	 */
	public function doInvite()
	{
		$email = t($_POST['email']);
		$detial = !isset($_POST['detial']) ? L('PUBLIC_INVATE_MESSAGE',array('uname'=>$GLOBALS['ts']['user']['uname'])) : h($_POST['detial']);			// Hi，我是 {uname}，我发现了一个很不错的网站，我在这里等你，快来加入吧。
		$map['inviter_uid'] = $this->mid;
		$map['ctime'] =	time();
		// 发送邮件邀请
		$result = model('Invite')->doInvite($email, $detial, $this->mid, true);
		$this->ajaxReturn(null, model('Invite')->getError(), $result);
	}

	/**
	 * 连接邀请 - 管理员
	 * @return void
	 */
	public function inviteLink()
	{
		$this->_initTabInvite();
		// 获取邀请码信息
		$codeList = model('Invite')->getAdminInviteCode('link');
		$this->assign('codeList', $codeList);
		// 获取已邀请用户信息
		$inviteList = model('Invite')->getInviteUserList($this->mid, 'link', true);
		$this->assign('inviteList', $inviteList);

		$this->display('invite_link');
	}

	/**
	 * 获取邀请码接口
	 * @return json 操作后的相关数据
	 */
	public function getInviteCode()
	{
		$res = model('Invite')->createInviteCode($this->mid, 'link', 10, true);
		$result = array();
		if($res) {
			$result['status'] = 1;
			$result['info'] = '邀请码获取成功';
		} else {
			$result['status'] = 0;
			$result['info'] = '邀请码获取失败';
		}

		exit(json_encode($result));
	}

	/**
	 * 已邀请用户列表
	 * @return html 显示已邀请用户列表
	 */
	public function getInviteAdminList()
	{
		$_REQUEST['tabHash'] = 'getInviteAdminList';
		$this->_initTabInvite();
		$this->allSelected = false;

		$this->searchKey = array('invite_type');
		$this->pageButton[] = array('title'=>'筛选列表','onclick'=>"admin.fold('search_form')");
		$this->opt['invite_type'] = array('0'=>'全部','1'=>'邮件邀请',2=>'链接邀请');

		$this->pageKeyList = array('face', 'receiver_uname', 'receiver_email', 'ctime', 'invite_type', 'invite_code', 'inviter_uname');
		$type = '';
		if($_REQUEST['dosearch'] == 1) {
			if(intval($_REQUEST['invite_type']) == 1) {	
				$type = 'email';
			} else if(intval($_REQUEST['invite_type']) == 2) {
				$type = 'link';
			}
		}
		$listData = model('Invite')->getInviteAdminUserList($type);
		foreach($listData['data'] as $key => &$value) {
			$value['face'] = '<img src="'.$value['avatar_small'].'" />';
			$receiverInfo = model('User')->getUserInfo($value['receiver_uid']);
			$value['receiver_uname'] = $receiverInfo['uname'];
			$value['receiver_email'] = $receiverInfo['email'];
			$value['ctime'] = date('Y-m-d H:i:s', $receiverInfo['ctime']);
			$value['invite_type'] = $value['type'] == 'link' ? '链接邀请' : '邮件邀请';
			$value['invite_code'] = $value['code'];
			$inviterInfo = model('User')->getUserInfo($value['inviter_uid']);
			$value['inviter_uname'] = $inviterInfo['uname'];
		}

		$this->displayList($listData);
	}


	/**
	 * 公告配置
	 *
	 */
	public function announcement($type=1){

		//列表key值 DOACTION表示操作
		//$this->pageKeyList = array('id','title','uid','sort','DOACTION');
		$this->pageKeyList = array('id','title','uid','DOACTION');
		$title 	=  $type ==1 ?L('PUBLIC_ANNOUNCEMENT'):L('PUBLIC_FOOTER_ARTICLE');
		//列表分页栏 按钮
		$this->pageButton[] = array('title'=>L('PUBLIC_ADD').$title,'onclick'=>"location.href = '".U('admin/Config/addArticle',array('type'=>$type))."'");
		$this->pageButton[] = array('title'=>L('PUBLIC_STREAM_DELETE').$title,'onclick'=>"admin.delArticle('',{$type})");

		/*数据的格式化 与listKey保持一致 */
		$map['type'] = $type;
		$listData = model('Xarticle')->where($map)->order('sort asc')->findPage(20);

		foreach($listData['data'] as &$v){
			$uinfo = model('User')->getUserInfo($v['uid']);
			$v['uid'] = $uinfo['space_link'];
			//TODO  附件处理
			$v['DOACTION'] = '<a href="'.U('admin/Config/addArticle',array('id'=>$v['id'],'type'=>$type)).'">'.L('PUBLIC_EDIT').'</a>
				 <a href="javascript:admin.delArticle('.$v['id'].','.$type.')" >'.L('PUBLIC_STREAM_DELETE').'</a>';
		}

		$this->displayList($listData);
	}

	//添加公告
	public function addArticle(){
		$type  = (empty($_GET['type']) || $_GET['type'] ==1) ? 1 :2;
		$title = $type == 1 ? L('PUBLIC_ANNOUNCEMENT'): L('PUBLIC_FOOTER_ARTICLE');

		if(!empty($_GET['id'])){
			$this->assign('pageTitle',L('PUBLIC_EDIT').$title);
			$detail =  model('Xarticle')->where('id='.intval($_GET['id']))->find();
			$detail['attach'] = str_replace('|', ',', $detail['attach']);
		}else{
			$this->assign('pageTitle',L('PUBLIC_ADD').$title);
			$detail = array();
		}
		$detail['type'] = $type;
		$this->pageKeyList = array('id','title','content','attach','type');
		$this->savePostUrl = U('admin/Config/doaddArticle');
		$this->notEmpty = array('title','content');
		$this->onsubmit = 'admin.checkAddArticle(this)';
		$this->displayConfig($detail);
	}
	//添加公告
	public function doaddArticle(){
		$_POST['type'] = 1;
		
		if(model('Xarticle')->saveArticle($_POST)){
			$data['title'] = t($_POST['title']);
			$data['k']     =  $_POST['type'] == 1 ? L('PUBLIC_TITLE_ACCENT_SAVEEDIT') : L('PUBLIC_TITLE_FILES_SAVEEDIT');
			LogRecord('admin_content','addArticle',$data,true);
			$jumpUrl = $_POST['type'] == 1 ?  U('admin/Config/announcement') : U('admin/Config/footer');
			$this->assign('jumpUrl',$jumpUrl);
			$this->success(L('PUBLIC_ADMIN_OPRETING_SUCCESS'));
		}else{
			$this->error(model('Xarticle')->getError());
		}
	}
	//删除公告
	public function delArticle(){
		$title  = $_POST['type'] == 1 ? L('PUBLIC_ANNOUNCEMENT'):L('PUBLIC_FOOTER_ARTICLE');
		$return = array('status'=>1,'data'=>$title.L('PUBLIC_DELETE_SUCCESS'));
		$id = $_POST['id'];
		if($res = model('Xarticle')->delArticle($id)){
			if($_POST['type'] == 1){
				LogRecord('admin_content','delArticle',array('ids'=>$id,'k'=>L('PUBLIC_STREAM_DELETE').$title),true);
			}else{
				LogRecord('admin_config','delFooter',array('ids'=>$id,'k'=>L('PUBLIC_STREAM_DELETE').$title),true);
			}
		}else{
			$error = model('Xarticle')->getError();
			empty($error) && $error =$title.L('PUBLIC_DELETE_FAIL');
			$return = array('status'=>0,'data'=>$error);
		}
		echo json_encode($return);exit();
	}

	/**
	 * 系统配置 - 邮件配置
	 */
	public function email() {
		$this->pageKeyList = array('email_sendtype','email_host','email_ssl','email_port','email_account','email_password','email_sender_name','email_sender_email','email_test');

		$this->opt['email_sendtype'] = array('smtp'=>'smtp');
		$this->opt['email_ssl'] = array('0'=>L('PUBLIC_SYSTEMD_FALSE'),'1'=>L('PUBLIC_SYSTEMD_TRUE'));
		
		$this->displayConfig();
	}

	/**
	 * 系统配置 - 附件配置
	 */
	public function attach() {
		$this->pageTitle['attach'] = L('PUBLIC_ATTACH_CONFIG');
		// Tab选项
		$this->pageTab[] = array('title'=>L('PUBLIC_ATTACH_CONFIG'),'tabHash'=>'attach','url'=>U('admin/Config/attach'));
		$this->pageTab[] = array('title'=>L('PUBLIC_CLOUDIMAGE_CONFIG'),'tabHash'=>'cloudimage','url'=>U('admin/Config/cloudimage'));
        $this->pageTab[] = array('title'=>L('PUBLIC_CLOUDATTACH_CONFIG'),'tabHash'=>'cloudattach','url'=>U('admin/Config/cloudattach'));

		
		$this->pageKeyList = array('attach_path_rule','attach_max_size','attach_allow_extension');
		$this->displayConfig();
	}

	/**
	 * 系统配置 - 附件配置 - 又拍云图片
	 */
	public function cloudimage() {
		$this->pageTitle['cloudimage'] = L('PUBLIC_ATTACH_CONFIG');
		// Tab选项
		$this->pageTab[] = array('title'=>L('PUBLIC_ATTACH_CONFIG'),'tabHash'=>'attach','url'=>U('admin/Config/attach'));
		$this->pageTab[] = array('title'=>L('PUBLIC_CLOUDIMAGE_CONFIG'),'tabHash'=>'cloudimage','url'=>U('admin/Config/cloudimage'));
        $this->pageTab[] = array('title'=>L('PUBLIC_CLOUDATTACH_CONFIG'),'tabHash'=>'cloudattach','url'=>U('admin/Config/cloudattach'));
		
		$this->opt['cloud_image_open']  = array('1'=>L('PUBLIC_OPEN'),'0'=>L('PUBLIC_CLOSE'));
		
		$this->pageKeyList = array('cloud_image_open','cloud_image_api_url','cloud_image_bucket','cloud_image_form_api_key','cloud_image_prefix_urls','cloud_image_admin','cloud_image_password');

		$this->displayConfig();
	}

	/**
	 * 系统配置 - 附件配置 - 又拍云附件
	 */
	public function cloudattach() {
		$this->pageTitle['cloudattach'] = L('PUBLIC_ATTACH_CONFIG');
		// Tab选项
		$this->pageTab[] = array('title'=>L('PUBLIC_ATTACH_CONFIG'),'tabHash'=>'attach','url'=>U('admin/Config/attach'));
		$this->pageTab[] = array('title'=>L('PUBLIC_CLOUDIMAGE_CONFIG'),'tabHash'=>'cloudimage','url'=>U('admin/Config/cloudimage'));
        $this->pageTab[] = array('title'=>L('PUBLIC_CLOUDATTACH_CONFIG'),'tabHash'=>'cloudattach','url'=>U('admin/Config/cloudattach'));

        $this->opt['cloud_attach_open']  = array('1'=>L('PUBLIC_OPEN'),'0'=>L('PUBLIC_CLOSE'));
		
		$this->pageKeyList = array('cloud_attach_open','cloud_attach_api_url','cloud_attach_bucket','cloud_attach_form_api_key','cloud_attach_prefix_urls','cloud_attach_admin','cloud_attach_password');
		$this->displayConfig();
	}

	/**
	 * 系统配置 - 过滤配置
	 */
	public function audit() {
		$this->pageKeyList = array('open','keywords','replace');
		$this->opt['open'] = array('0'=>L('PUBLIC_SYSTEMD_FALSE'),'1'=>L('PUBLIC_SYSTEMD_TRUE'));
		$this->savePostUrl = U('admin/Config/doaudit');
		$detail = model('Xdata')->get($this->systemdata_list.":".$this->systemdata_key);
		$detail['keywords'] = model('Xdata')->get('keywordConfig');				// 敏感词的Key
		$this->displayConfig($detail);
	}

	/**
	 * 保存敏感词设置，敏感词单独存放
	 * @return [type] [description]
	 */
	public function doaudit() {
		// 存储敏感词
		$data = $_POST['keywords'];
		if(model('Xdata')->put('keywordConfig', $data)) {
			unset($_POST['keywords']);
			$this->saveConfigData();
		} else {
			$this->error(L('PUBLIC_SENSITIVE_SAVE_FAIL'));
		}
	}

	/**
	 * 系统配置 - 顶部导航配置 - 导航列表 
	 */
	public function nav() {
		$this->pageKeyList = array('navi_id','navi_name','app_name','url','target','status','position','guest','is_app_navi','parent_id','order_sort','DOACTION');
		$this->pageButton[] = array('title'=>L('PUBLIC_ADD'),'onclick'=>"javascript:location.href='".U('admin/Config/navAdd','addtype=1&tabHash=type')."'");
		// Tab选项
		$this->pageTab[] = array('title'=>'顶部导航','tabHash'=>'rule','url'=>U('admin/Config/nav'));
		$this->pageTab[] = array('title'=>'底部导航','tabHash'=>'foot','url'=>U('admin/Config/footNav'));
        $this->pageTab[] = array('title'=>L('PUBLIC_ADD_NAVIGATION'),'tabHash'=>'type','url'=>U('admin/Config/navAdd'));
		// 列表分页栏按钮
        $this->opt['target'] = array('_blank'=>L('PUBLIC_NEW_WINDOW'),'_self'=>L('PUBLIC_CURRENT_WINDOW'),'_parent'=>L('PUBLIC_PARENT_WINDOW'));
        $this->opt['position'] = array('0'=>L('PUBLIC_HEAD_NAVIGATION'),'1'=>L('PUBLIC_BOTTOM_NAVIGATION'),'2'=>L('PUBLIC_INTERNAL_APPLICATION'));
        $this->opt['status'] = array('0'=>L('PUBLIC_CLOSE'),'1'=>L('PUBLIC_OPEN'));
        $this->opt['is_app_navi'] = array('0'=>L('PUBLIC_SYSTEMD_FALSE'),'1'=>L('PUBLIC_SYSTEMD_TRUE'));
        // 数据的格式化与listKey保持一致 
 		$listData = model('Navi')->where('position=0')->order("order_sort asc")->findPage(20);
 		
 		$firstdata = array();
 		$seconddata = array();
 		foreach ( $listData['data'] as $lv ){
 			if ( $lv['parent_id'] == '0' ){
 				$firstdata[] = $lv;
 			} else {
 				$seconddata[$lv['parent_id']][] = $lv;
 			}
 		}
 		$finaldata = array();
 		foreach ( $firstdata as $fv ){
 			$finaldata[] = $fv;
 			if ( $seconddata[intval($fv['navi_id'])] ){
 				foreach ($seconddata[$fv['navi_id']] as $sv){
 					$finaldata[] = $sv;
 				}
 			}
 		}
 		
   		foreach($finaldata as &$v) {
			$v['target'] = $this->opt['target'][$v['target']];
			$v['status'] = $this->opt['status'][$v['status']];
			$v['position'] = $this->opt['position'][$v['position']];
			$v['is_app_navi'] = $this->opt['is_app_navi'][$v['is_app_navi']];
			$v['guest'] = $v['guest'] = '0' ? L('PUBLIC_SYSTEMD_FALSE') : L('PUBLIC_SYSTEMD_TRUE');
			$v['url'] = str_replace('{website}', SITE_URL, $v['url']);
			$v['parent_id'] && $v['navi_name'] = '┗ '.$v['navi_name'];
			// $v['parent_id'] = $v['parent_id'] = '' ? $v['parent_id'] = '无' : $v['guest'] = '有';
   			if($v['parent_id'] <= 0) {
				$v['DOACTION'] = '<a href="'.U('admin/Config/navAdd',array('id'=>$v['navi_id'],'type'=>'son','tabHash'=>'type')).'" >'.L('PUBLIC_ADD_SUBNAVIGATION').'</a>&nbsp;-&nbsp;<a href="'.U('admin/Config/navAdd',array('id'=>$v['navi_id'])).'">'.L('PUBLIC_EDIT').'</a>&nbsp;-&nbsp;<a href="javascript:admin.delnav(\''.$v['navi_id'].'\')">'.L('PUBLIC_STREAM_DELETE').'</a>';
			} else {
				$v['DOACTION'] = '<a href="'.U('admin/Config/navAdd',array('id'=>$v['navi_id'],'tabHash'=>'type')).'">'.L('PUBLIC_EDIT').'</a>&nbsp;-&nbsp;<a href="javascript:admin.delnav(\''.$v['navi_id'].'\')" >'.L('PUBLIC_STREAM_DELETE').'</a>';
			}		
		}
		$listData['data'] = $finaldata;
		$this->allSelected = false;
		$this->displayList($listData);
	}
	/**
	 * 系统配置 - 底部导航配置 - 导航列表
	 */
	public function footNav(){
		$this->pageKeyList = array('navi_id','navi_name','app_name','url','target','status','position','guest','is_app_navi','parent_id','order_sort','DOACTION');
		$this->pageButton[] = array('title'=>L('PUBLIC_ADD'),'onclick'=>"javascript:location.href='".U('admin/Config/navAdd','addtype=2&tabHash=type')."'");
		// Tab选项
		$this->pageTab[] = array('title'=>'顶部导航','tabHash'=>'rule','url'=>U('admin/Config/nav'));
		$this->pageTab[] = array('title'=>'底部导航','tabHash'=>'foot','url'=>U('admin/Config/footNav'));
		$this->pageTab[] = array('title'=>L('PUBLIC_ADD_NAVIGATION'),'tabHash'=>'type','url'=>U('admin/Config/navAdd'));
		// 列表分页栏按钮
		$this->opt['target'] = array('_blank'=>L('PUBLIC_NEW_WINDOW'),'_self'=>L('PUBLIC_CURRENT_WINDOW'),'_parent'=>L('PUBLIC_PARENT_WINDOW'));
		$this->opt['position'] = array('0'=>L('PUBLIC_HEAD_NAVIGATION'),'1'=>L('PUBLIC_BOTTOM_NAVIGATION'),'2'=>L('PUBLIC_INTERNAL_APPLICATION'));
		$this->opt['status'] = array('0'=>L('SSC_CLOSE'),'1'=>L('PUBLIC_OPEN'));
		$this->opt['is_app_navi'] = array('0'=>L('PUBLIC_SYSTEMD_FALSE'),'1'=>L('PUBLIC_SYSTEMD_TRUE'));
		// 数据的格式化与listKey保持一致
		$listData = model('Navi')->where('position=1')->order("order_sort asc")->findPage(20);
		
		$firstdata = array();
		$seconddata = array();
		foreach ( $listData['data'] as $lv ){
			if ( $lv['parent_id'] == '0' ){
				$firstdata[] = $lv;
			} else {
				$seconddata[$lv['parent_id']][] = $lv;
			}
		}
		$finaldata = array();
		foreach ( $firstdata as $fv ){
			$finaldata[] = $fv;
			if ( $seconddata[intval($fv['navi_id'])] ){
				foreach ($seconddata[$fv['navi_id']] as $sv){
					$finaldata[] = $sv;
				}
			}
		}
		foreach($finaldata as &$v) {
			$v['target'] = $this->opt['target'][$v['target']];
			$v['status'] = $this->opt['status'][$v['status']];
			$v['position'] = $this->opt['position'][$v['position']];
			$v['is_app_navi'] = $this->opt['is_app_navi'][$v['is_app_navi']];
			$v['guest'] = $v['guest'] = '0' ? L('PUBLIC_SYSTEMD_FALSE') : L('PUBLIC_SYSTEMD_TRUE');
			$v['url'] = str_replace('{website}', SITE_URL, $v['url']);
			$v['parent_id'] && $v['navi_name'] = '┗ '.$v['navi_name'];
			// $v['parent_id'] = $v['parent_id'] = '' ? $v['parent_id'] = '无' : $v['guest'] = '有';
			if($v['parent_id'] <= 0) {
				$v['DOACTION'] = '<a href="'.U('admin/Config/navAdd',array('id'=>$v['navi_id'],'type'=>'son','tabHash'=>'type','addtype'=>2)).'" >'.L('PUBLIC_ADD_SUBNAVIGATION').'</a>&nbsp;-&nbsp;<a href="'.U('admin/Config/navAdd',array('id'=>$v['navi_id'],'tabHash'=>'type','addtype'=>2)).'">'.L('PUBLIC_EDIT').'</a>&nbsp;-&nbsp;<a href="javascript:admin.delnav(\''.$v['navi_id'].'\')">'.L('PUBLIC_STREAM_DELETE').'</a>';
			} else {
				$v['DOACTION'] = '<a href="'.U('admin/Config/navAdd',array('id'=>$v['navi_id'],'tabHash'=>'type','addtype'=>2)).'">'.L('PUBLIC_EDIT').'</a>&nbsp;-&nbsp;<a href="javascript:admin.delnav(\''.$v['navi_id'].'\')" >'.L('PUBLIC_STREAM_DELETE').'</a>';
			}
		}
		$listData['data'] = $finaldata;
		$this->allSelected = false;
		$this->displayList($listData);
	}
	/**
     * 导航配置的添加和修改
     */
	public function doNav() {
	   	$map['navi_name'] = t($_POST['navi_name']);
		$map['app_name'] = t($_POST['app_name']);
		$map['url'] = t($_POST['url']);
		$map['target'] = t($_POST['target']);
		$map['status'] = intval($_POST['status']);
		$map['position'] = t($_POST['position']);
		$map['guest'] = intval($_POST['guest']);
		$map['is_app_navi'] = intval($_POST['is_app_navi']);
		$map['order_sort'] = intval($_POST['order_sort']);
		$map['navi_name'] = t($_POST['navi_name']);
		$map['app_name'] = t($_POST['app_name']);
		$map['url'] = t($_POST['url']);

		if($map['navi_name'] == '') {
			$this->error(L('PUBLIC_NAVIGATION_NAME_NOEWPTY'));
		}
		if($map['app_name'] == '') {
			$this->error('英文名称不能为空');
		}
		if($map['url'] == '') {
			$this->error(L('PUBLIC_LINK_NOEMPTY'));
		}
		if($map['position'] == '') {
			$this->error(L('PUBLIC_NAVIGATION_POSITION_NOEWPTY'));
		}
		if($map['order_sort'] == '') {
			$this->error(L('PUBLIC_APPLICATION_SORT_NOEMPTY'));
		}

		model('Navi')->cleanCache();
	   	if($_GET['type']) {
	   		$map['parent_id'] = intval($_GET['id']);	
	   		$rel = model('Navi')->add($map);
	   	} else {	
	   		if(!$_GET['id']) {
	   			$map['parent_id'] = 0;
		   		$rel = model('Navi')->add($map);
		   	} else {
		   		$rel = model('Navi')->where('navi_id='.$_GET['id'])->save($map);
		   	}
		   	$rel = true;
	   	}
   		if($rel) {
   			$jumpstr = 'nav';
   			$map['position'] && $jumpstr = "footNav&tabHash=foot"; 
			$this->assign('jumpUrl', U('admin/Config/'.$jumpstr));		
			$this->success(L('PUBLIC_ADMIN_OPRETING_SUCCESS'));
		} else {
			$this->error(model()->getError());
		}
   } 

   /**
    * 系统配置 - 导航配置 - 增加导航
    */
   public function navAdd() {
	   	$addtype = $_GET['addtype'] ? $_GET['addtype'] : 1;
	   	//顶部导航
	   	if ( $addtype == 1 ){
	   		$defaultdata['position'] = 0;
	   	} else {
	   		$defaultdata['position'] = 1;
	   	}
		$this->pageKeyList = array('navi_name','app_name','url','target','status','position','guest','is_app_navi','order_sort');
		$this->pageTab[] = array('title'=>'顶部导航','tabHash'=>'rule','url'=>U('admin/Config/nav'));
		$this->pageTab[] = array('title'=>'底部导航','tabHash'=>'foot','url'=>U('admin/Config/footNav'));
        $this->pageTab[] = array('title'=>L('PUBLIC_ADD_NAVIGATION'),'tabHash'=>'type','url'=>U('admin/Config/navAdd'));
		
        $this->opt['target'] = array('_blank'=>L('PUBLIC_NEW_WINDOW'),'_self'=>L('PUBLIC_CURRENT_WINDOW'),'_parent'=>L('PUBLIC_PARENT_WINDOW'));
        $this->opt['position'] = array('0'=>L('PUBLIC_HEAD_NAVIGATION'),'1'=>L('PUBLIC_BOTTOM_NAVIGATION'),'2'=>L('PUBLIC_INTERNAL_APPLICATION'));
        $this->opt['status'] = array('0'=>L('PUBLIC_CLOSE'),'1'=>L('PUBLIC_OPEN'));
        $this->opt['is_app_navi'] = array('0'=>L('PUBLIC_SYSTEMD_FALSE'),'1'=>L('PUBLIC_SYSTEMD_TRUE'));
        $this->opt['status'] = array('0'=>L('PUBLIC_CLOSE'),'1'=>L('PUBLIC_OPEN'));
		$this->opt['guest'] = array('0'=>L('PUBLIC_SYSTEMD_FALSE'),'1'=>L('PUBLIC_SYSTEMD_TRUE'));
	 	$this->opt['is_app_navi'] = array('0'=>L('PUBLIC_SYSTEMD_FALSE'),'1'=>L('PUBLIC_SYSTEMD_TRUE'));
		$this->opt['target'] = array('_blank'=>L('PUBLIC_NEW_WINDOW'),'_self'=>L('PUBLIC_CURRENT_WINDOW'),'_parent'=>L('PUBLIC_PARENT_WINDOW'));
// 		$this->opt['position'] = array('0'=>L('PUBLIC_HEAD_NAVIGATION'),'1'=>L('PUBLIC_BOTTOM_NAVIGATION'),'2'=>L('PUBLIC_INTERNAL_APPLICATION'));
		$addtitle = $addtype == 1 ? L('PUBLIC_HEAD_NAVIGATION') : L('PUBLIC_BOTTOM_NAVIGATION');
		$this->opt['position'] = isset( $_GET['id'] ) ? array( $defaultdata['position'] => $addtitle ) : array('0'=>L('PUBLIC_HEAD_NAVIGATION'),'1'=>L('PUBLIC_BOTTOM_NAVIGATION'),'2'=>L('PUBLIC_INTERNAL_APPLICATION'));
		$this->notEmpty = array('navi_name','app_name','url','position','order_sort');
		$this->onsubmit = 'admin.checkNavInfo(this)';

		if(!$_GET['type']) {
			if(!empty($_GET['id'])) {
				$editnav = model('Navi')->where('navi_id='.$_GET['id'])->find();
				$this->savePostUrl = U('admin/Config/doNav&id='.$_GET['id']);
				$this->displayConfig($editnav);
			} else {
				$this->savePostUrl = U('admin/Config/doNav');	
				$this->displayConfig($defaultdata);
			}
		} else {
			$this->savePostUrl = U('admin/Config/doNav&id='.$_GET['id'].'&type=son');
			$this->displayConfig($defaultdata);
		}
	}

	/**
	 * 删除导航操作
	 */
	public function delNav() {
    	$rel = model('Navi')->where('navi_id='.intval($_POST['id']).' OR parent_id='.intval($_POST['id']))->delete();   
    	if($rel) {
    		$return = array('status'=>1,'data'=>L('PUBLIC_DELETE_SUCCESS'));
		} else {
			$error = model('Navi')->getError();
			$return = array('status'=>0,'data'=>$error);
		}
		exit(json_encode($return));
	}

   /**
	 * 页脚文章配置
	 * 与公告数据存在同一张表中
	 */
	public function footer(){
		$this->announcement(2);
	}
	
	/**
	 * 系统配置 - 微博配置
	 */
	public function feed() {
		$this->pageKeyList = array('weibo_nums','weibo_type','weibo_premission','weibo_send_info','weibo_default_topic','weibo_at_me');
		$this->opt['weibo_type'] 	= array('face'=>'表情','at'=>'好友','image'=>L('PUBLIC_IMAGE_STREAM'),'video'=>'视频','file'=>L('PUBLIC_FILE_STREAM'),'topic'=>'话题','contribute'=>'投稿');
		$this->opt['weibo_premission'] = array('repost'=>L('PUBLIC_SHARE_WEIBO'),'comment'=>L('PUBLIC_CONCENT_WEIBO'),'audit'=>'先审后发');
		$this->opt['weibo_at_me'] = array(0=>'全站用户',1=>'关注用户');
		$this->displayConfig();	
	}
	
	/**
	 * 系统配置 - 地区配置
	 */
	public function area()
	{
		$this->pageTitle['area'] = '地区配置';
		$_GET['pid'] = intval($_GET['pid']);
		$treeData = model('CategoryTree')->setTable('area')->getNetworkList();

		$this->displayTree($treeData, 'area', 3);
	}
	
	/**
	 * 添加地区页面
	 */
	public function addArea() {
		$this->assign('pid', intval($_GET['pid']));
		$this->display('editArea');
	}
	
	/**
	 * 编辑地区页面
	 */
	public function editArea() {
		$_GET['area_id'] = intval($_GET['area_id']);
		$area = model('Area')->where('area_id='.$_GET['area_id'])->find();
		$area['area_id'] = $_GET['area_id'];
		$this->assign('area', $area);
		$this->display();
	}
	
	/**
	 * 添加地区操作
	 */
	public function doAddArea() {
		$_POST['title']	= t($_POST['title']);
		$_POST['pid'] = intval($_POST['pid']);
		if(empty($_POST['title'])) {
			echo 0;
			return ;
		}
		echo ($res =model('Area')->add($_POST)) ? $res : '0';
		model('Area')->remakeCityCache();
	}
	
	/**
	 * 编辑地区操作
	 */
	public function doEditArea() {
		$_POST['title'] = t($_POST['title']);
		$_POST['area_id'] = intval($_POST['area_id']);
		if(empty($_POST['title'])) {
			echo 0;
			return ;
		}
		echo model('Area')->where('`area_id`='.$_POST['area_id'])->setField('title', $_POST['title']) ? '1' : '0';
		model('Area')->remakeCityCache();
	}

	/**
	 * 删除地区操作
	 */
	public function doDeleteArea() {
		$_POST['ids'] = explode(',', t($_POST['ids']));
		if(empty($_POST['ids'])) {
			echo 0;
			return ;
		}
		$map['area_id'] = array('IN', $_POST['ids']);
		echo model('Area')->where($map)->delete() ? '1' : '0';
		model('Area')->remakeCityCache();
	}
	
	/**
	 * 系统配置 - 语言配置
	 */
	public function lang() {
		$this->_listpk = 'lang_id';	
		// 列表key值 DOACTION表示操作
		$pageKey = array('lang_id', 'key', 'appname', 'filetype');
		$langType = model('Lang')->getLangType();
		$pageKeyList = array_merge($pageKey, $langType);
		array_push($pageKeyList, 'DOACTION');
		$this->pageKeyList = $pageKeyList;
		// 添加语言配置内容按钮
		$this->pageButton[] = array('title'=>L('PUBLIC_ADD'),'onclick'=>"admin.updateLangContent(0)");
		// 删除语言配置内容按钮
		$this->pageButton[] = array('title'=>L('PUBLIC_STREAM_DELETE'), 'onclick'=>"admin.deleteLangContent(this)");
		// 搜索key值 - 列表分页栏 按钮 搜索
		$this->searchKey = array('key', 'appname', 'filetype','content');
		$this->opt['filetype'] = array(0 => L('PUBLIC_PHP_FILE'), 1 => L('PUBLIC_JAVASCRIPT_FILE'));
		$this->pageButton[] = array('title'=>L('PUBLIC_SEARCH_INDEX'),'onclick'=>"admin.fold('search_form')");
		$listData = $this->_getLangContent();
		$this->displayList($listData);
	}

	/**
	 * 添加，编辑语言配置内容
	 */
	public function updateLangContent() {
		$sid = intval($_GET['sid']);
		if($sid == 0) {
			$this->pageTitle[ACTION_NAME] = L('PUBLIC_ADD_LANGUAGE_CONFIGURATION');
		} else {
			$this->pageTitle[ACTION_NAME] = L('PUBLIC_EDIT_LANGUAGE_CONFIGURATION');
			// 获取内容
			$detail = model('Lang')->getLangSetInfo($sid);
		}
		// 列表key值 DOACTION表示操作
		$pageKey = array('key', 'appname', 'filetype');
		$langType = model('Lang')->getLangType();
		$pageKeyList = array_merge($pageKey, $langType);
		$this->pageKeyList = $pageKeyList;
		// 配置选项数据
		$this->opt['filetype'] = array(0 => L('PUBLIC_PHP_FILE'), 1 => L('PUBLIC_JAVASCRIPT_FILE'));
		// 表单链接设置
		$this->savePostUrl = U('admin/Config/doUpdateLangContent').'&sid='.$sid;
		$this->displayConfig($detail);
	}

	/**
	 * 编辑语言配置内容
	 */
	public function doUpdateLangContent() {
		$sid = intval($_GET['sid']);
		$postData = $_POST;

		unset($postData['systemdata_list']);
		unset($postData['systemdata_key']);
		unset($postData['pageTitle']);

		$result = model('Lang')->updateLangData($postData, $sid);
		$jumpUrl = U('admin/Config/lang');
		$this->assign('jumpUrl', $jumpUrl);
		switch($result) {
			case 0:
				$this->error(L('PUBLIC_ADMIN_OPRETING_ERROR'));
				break;
			case 1:
				$this->success(L('PUBLIC_ADMIN_OPRETING_SUCCESS'));
				break;
			case 2:
				$this->error(L('PUBLIC_LANGUAGE_CONFIGURATION_ALREADY_EXIST'));
				break;
		}
	}

	/**
	 * 删除语言配置内容
	 */
	public function deleteLangContent() {
		$ids = t($_POST['lang_id']);
		$id = explode(',', $ids);
		$result = model('Lang')->deleteLangData($id);
		if($result === false) {
			$data['status'] = 0;
			$data['data'] = L('PUBLIC_DELETE_FAIL');
		} else {
			$data['status'] = 1;
			$data['data'] = L('PUBLIC_DELETE_SUCCESS');
		}
		exit(json_encode($data));
	}

	/**
	 * 获取语言列表数据
	 */
	private function _getLangContent() {
		$langType = model('Lang')->getLangType();
		// 获取查询条件
		$map = $this->getSearchPost();
		// 组装查询条件
		!empty($map['key']) && $_map['key'] = array('LIKE', '%'.$map['key'].'%');
		!empty($map['appname']) && $_map['appname'] = array('LIKE', '%'.$map['appname'].'%');
		isset($map['filetype']) && $_map['filetype'] = intval($map['filetype']);
		if(!empty($map['content'])){
			$where['_logic'] = 'OR';
			foreach ($langType as $k) {
				$where[$k] =  array('LIKE', '%'.t($map['content']).'%');
			}
			$_map['_complex'] = $where;
		}

		$listData = model('Lang')->getLangContent($_map);

		foreach($listData['data'] as &$value) {
			foreach($langType as &$v){
				$value[$v] = t($value[$v]);
			}
			$value['filetype'] = ($value['filetype'] == 1) ? L('PUBLIC_JAVASCRIPT_FILE'): L('PUBLIC_PHP_FILE');
			$value['DOACTION'] = '<a href="'.U('admin/Config/updateLangContent', array('sid'=>$value['lang_id'])).'">'.L('PUBLIC_EDIT').'</a><a href="javascript:void(0)" onclick="admin.deleteLangContent('.$value['lang_id'].')">'.L('PUBLIC_STREAM_DELETE').'</a>';
		}

		return $listData;
	}

	public  function  diylist(){
		
		$this->pageKeyList = array('id', 'desc', 'widget_list', 'DOACTION');

		// 添加语言配置内容按钮
		$this->pageButton[] = array('title'=>L('PUBLIC_UPDATE_WIDGET'),'onclick'=>"admin.updateWidget()");

		$this->allSelected = false;
		$data = model('Widget')->getDiyList();

		foreach($data as &$v){
			$widget_list = unserialize($v['widget_list']);
			$v['widget_list'] = '';
			foreach($widget_list as $vv){
				$v['widget_list'] .= $vv['appname'].':'.$vv['name'].'Widget<br/>';
			}
			$v['DOACTION'] = '<a href="javascript:admin.configWidget('.$v['id'].')">'.L('PUBLIC_SETTING').'</a>';
		}

		$listData['data'] = $data;

		$this->displayList($listData);
	}

	/**
	 * 系统配置 - 消息配置
	 */
	public function notify() {
		$type = isset($_GET['type'])?intval($_GET['type']):1;
		//echo $type;exit;
		$this->pageTab[] = array('title'=>'用户消息配置','tabHash'=>'notify_user','url'=>U('admin/Config/notify',array('type'=>1)));
		$this->pageTab[] = array('title'=>'管理员消息配置','tabHash'=>'notify_admin','url'=>U('admin/Config/notify',array('type'=>2)));
		//$this->pageTab[] = array('title'=>L('PUBLIC_MESSING_SENTTO'),'tabHash'=>'notifyEmail','url'=>U('admin/Config/sendNotifyEmail'));
        //$d['nodeList']   = model('Notify')->getNodeList($type);    通过缓存读取列表，务必保留，以后会用到
		$d['nodeList'] = D('notify_node')->where('type='.$type)->findAll();
		$this->assign('type',$type);
        $this->assign($d);
		$this->display();	
	}

	/**
	 * 保存消息配置节点
	 */
	public function saveNotifyNode() {
		model('Notify')->saveNodeList($_POST['sendType']);
		$this->assign('jumpUrl',U('admin/Config/notify','type='.$_POST['type'].'&tabHash='.$_POST['tabhash']));
		$this->success();
	}

	/**
	 * 消息模板页面
	 */
	public function notifytpl() {
		$type = isset($_GET['type'])?intval($_GET['type']):1;
		$this->pageTab[] = array('title'=>'用户消息配置','tabHash'=>'notify_user','url'=>U('admin/Config/notify',array('type'=>1)));
		$this->pageTab[] = array('title'=>'管理员消息配置','tabHash'=>'notify_admin','url'=>U('admin/Config/notify',array('type'=>2)));
        $this->pageTab[] = array('title'=>L('PUBLIC_MAIL_TPL_SET'),'tabHash'=>'notifytpl','url'=>'#');

        $d['langType'] = model('Lang')->getLangType();
        $d['nodeInfo'] = model('Notify')->getNode(t($_REQUEST['node'])); 

        $new['appname'] = 'PUBLIC';
        $new['filetype'] = 0; 
      	$map['key'] = $d['nodeInfo']['content_key'];
        if(!$d['lang']['content'] = model('Lang')->where($map)->find()) {
        	$new['key'] = $map['key'];
        	model('Lang')->add($new);
        	$d['lang']['content'] = $new;
        }

        $map['key']  = $d['nodeInfo']['title_key'];
        if(!$d['lang']['title'] = model('Lang')->where($map)->find()) {
        	$new['key'] = $map['key'];
        	model('Lang')->add($new);
        	$d['lang']['title'] = $new;
        }

        $this->assign('type',$type);
        
        $this->assign($d);
		$this->display();	
	}

	/**
	 * 保存消息模板操作
	 */
	public function saveNotifyTpl() {
		model('Notify')->saveTpl($_POST);
		$this->assign('jumpUrl',U('admin/Config/notify','type='.$_POST['type'].'&tabHash='.$_POST['tabhash']));
		$this->success();	
	}

	/**
	 * 发送消息邮件页面
	 */
	public function sendNotifyEmail() {
		$this->pageTab[] = array('title'=>L('PUBLIC_MAILTITLE_ADMIN'),'tabHash'=>'notify','url'=>U('admin/Config/notify'));
		$this->pageTab[] = array('title'=>L('PUBLIC_MESSING_SENTTO'),'tabHash'=>'notifyEmail','url'=>U('admin/Config/sendNotifyEmail'));
		$d = model('Notify')->sendEmailList();
		$this->assign($d);
		$this->display('sendNotifyEmail');
	}

	/**
	 * 发送消息邮件操作
	 */
	public function dosendEmail() {
		$d = model('Notify')->sendEmailList();
		// "此次发送{$d['count']}条邮件，其中成功发送{$d['nums']}条。"
		exit(L('PUBLIC_SENT_EMAIL_TIPES_NUM',array('num'=>"{$d['count']}",'sum'=>"{$d['nums']}")));
	}

	/**
	 * SEO配置
	 */
	public function setSeo(){
		$this->pageTab[] = array('title'=>'SEO配置','tabHash'=>'setSeo','url'=>U('admin/Config/setSeo'));

       $this->pageKeyList = array('name', 'title', 'keywords', 'des', 'DOACTION');
        $keys = array('login','feed_topic','feed_detail','user_profile');
        $names = array('登录页','话题页','微博详情页','个人主页');
        foreach($keys as $k=>$v){
        	$data= model('Xdata')->get("admin_Config:"."seo_".$v);
        	$list[$k]['name'] = $names[$k];
        	$list[$k]['title'] = $data['title'];
        	$list[$k]['keywords'] = $data['keywords'];
        	$list[$k]['des'] = $data['des'];
        	$list[$k]['DOACTION'] = '<a href="'.U('admin/Config/editSeo',array('key'=>$v,'name'=>$names[$k],'tabHash'=>'editSeo')).'">'.L('PUBLIC_EDIT').'</a>';
        }
        $listData['data'] = $list;
        $this->allSelected = false;
        $this->displayList($listData);
	}

	/**
	 * 编辑SEO项
	 */
	public function editSeo(){
		$key = $_GET['key'];
		$name = $_GET['name'];
		$this->systemdata_key = 'seo_'.$key;
		$this->pageTab[] = array('title'=>'SEO设置','tabHash'=>'setSeo','url'=>U('admin/Config/setSeo'));
		$this->pageTab[] = array('title'=>'SEO编辑','tabHash'=>'editSeo','url'=>U('admin/Config/editSeo',array('key'=>$key,'name'=>$name)));

		$this->pageKeyList = array('key','name','title','keywords','des');
		$data= model('Xdata')->get("admin_Config:".$this->systemdata_key);
		$detail['systemdata_key'] = $this->systemdata_key;
		$detail['key'] = $key;
		$detail['name'] = $name;
		$detail['title'] = $data['title'];
		$detail['keywords'] = $data['keywords'];
		$detail['des'] = $data['des'];
		switch ($key) {
			case 'feed_topic':
				$detail['note'] = '{topicName}:话题名称，{topicNote}:话题注释，{topicDes}:话题描述，{lastTopic}:最近一条话题';
				break;
			case 'feed_detail':
				$detail['note'] = '{content}:微博内容，{uname}:用户昵称';
				break;
			case 'user_profile':
				$detail['note'] = '{uname}:用户昵称，{lastFeed}:最后一条微博';
				break;
			default:
				$detail['note'] = '';
				break;
		}
		$this->assign($detail);
		$this->display();
		//$this->displayConfig($detail);
	}

}