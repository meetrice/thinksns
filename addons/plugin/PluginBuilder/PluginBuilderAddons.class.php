<?php
class PluginBuilderAddons extends SimpleAddons {
	protected $version = '1.6';
	protected $author = '杨维杰';
	protected $site = 'http://diandian.com/270687';
	protected $info = '插件制作工具';
	protected $pluginName = '插件生成器';
	protected $tsVersion = "2.5";// ts核心版本号
	protected $hooks; 
	 /**
	 * getHooksInfo
	 * 获得该插件使用了哪些钩子聚合类，哪些钩子是需要进行排序的
	 * @access public
	 * @return void
	 */
	public function getHooksInfo() {}
	
	public function start() {
		return true;
//        $plugins_dir = ADDON_PATH . '/plugins/';
//        $perms = substr(sprintf('%o', fileperms($plugins_dir)), -4);
//        return ($perms == '0777') ? true:false;
	}
	
	public function install() {
		return $this->save_config(array(),'plugins_data.php');
	}

	public function uninstall() {
		parent::uninstall();
	}
	
	/* 后台管理 */
	public function adminMenu() {
		return array('create' => '创建插件','index'=>'插件列表','hooks_manage'=>'添加钩子','view_doc'=>'插件开发文档','view_pdf'=>'钩子说明');
	}
	
	public function window(){
		$this->assign('theme','ambiance');//还可以是monokai代码预览的高亮主题
		$this->assign('url_path',$this->url.'/html/');
		$this->display('window');exit;
	}

	//首页
	public function create() {
		if($_GET['name']) {
			$is_edit = trim($_GET['name']);
			$post = include 'plugins_data.php';
			$post = $post[$is_edit];
		}else{
			$post = array(
				'pluginFile' => 'Example',
				'version' => '1.0',
				'author' => '无名',
				'site' => 'http://diandian.com/270687',
				'pluginName' => '示列',
				'info' => '这是一个简单插件的示列',
				'tsVersion' => '2.5',
				'adminMenu' => 'admin:管理',
			);
			$is_edit = 0;
		}
		$this->assign('post',$post);
		$this->assign('is_edit',$is_edit);
		$tsVersion = 2.5;//希望官方提供个常量可以获取
		//hooks钩子列表来自与官方2011-09-04的THINKSNS钩子说明PDF
		$hooks = include 'hooks_config.php';
		$this->assign('Hooks',$hooks);
		$this->assign('lisence_info','PluginBuilder 简体中文 UTF8 版 20120506');
		$this->assign('theme','ambiance');//还可以是monokai代码预览的高亮主题
		$this->assign('url_path',$this->url.'/html/');
		$this->assign('tsVersion',$tsVersion);
		$this->display('create');
	}

	//创建插件
	public function add(){
		$content = $this->preview(false);
		$filename = $dir = trim($_POST['pluginFile']);
		$dir = ADDON_PATH.'/plugins/'.$dir.'/';
		$dir_mk = mk_dir($dir);
		mk_dir($dir.'html/');
		if(!$dir_mk) $this->error('插件目录无创建权限,请设置权限为0777');
		$filename .= 'Addons.class.php';
		$plugin = include 'plugins_data.php';
		$post = $this->preview(false,true);
		unset($post['__hash__']);
		$plugin[$post['pluginFile']] = $post;
		if($this->save_config($plugin,'plugins_data.php') === true && file_put_contents($dir.$filename,$content)){
			$this->success('插件创建成功！');
		}else{
			$this->error('创建插件文件失败，请检查权限');
		}
	}

	//编辑插件
	public function edit(){
		$content = $this->preview(false);
		$filename = $dir = trim($_POST['pluginFile']);
		$dir = ADDON_PATH.'/plugins/'.$dir.'/';
		$plugin = include 'plugins_data.php';
		if(!is_dir($dir)){
			unset($plugin[$filename]);
			$this->save_config($plugin,'plugins_data.php');
			$this->error('插件不存在');
		}else{
			$post = $this->preview(false,true);
			unset($post['__hash__']);
			$plugin[$post['pluginFile']] = $post;
			$filename .= 'Addons.class.php';
			if($this->save_config($plugin,'plugins_data.php') === true && file_put_contents($dir.$filename,$content)){
				$this->success('插件编辑成功！');
			}else{
				$this->error('插件编辑失败');
			}
		}
	}

	//删除插件
	public function del(){
		$name = trim($_GET['name']);
		$model = model('Addons');
		//获取所有的插件名
		$result = $model->getAddonAllList();
		$result = array_merge($result['valid']['data'],$result['invalid']['data']);
		$this->addons = $result;
		$result = array();
		foreach ($this->addons as $value){
			$result[] = $value['name'];
		}
		if(!in_array($name, $result))	$this->error('插件不存在');
		$dir = ADDON_PATH.'/plugins/'.$name.'/';
		$plugin = include 'plugins_data.php';
		if($this->rmdirr($dir)){
			unset($plugin[$name]);
			$this->save_config($plugin,'plugins_data.php');

			$this->success('插件删除成功');
		}else{
			$this->error('无法删除插件目录，请检查其目录权限');
		}
	}

	//插件列表
	public function index(){
		$list = include 'plugins_data.php';
		$this->assign('list',$list);
		$this->display('index');
	}

	//添加钩子页面
	public function hooks_manage(){
		$hooks = include 'hooks_config.php';
		$this->assign('hooks',$hooks);
		$this->display('hooks_manage');
	}
	
	//添加钩子
	public function hooks_add(){
		$o_hooks = $hooks = include 'hooks_config.php';
		unset($_POST['__hash__']);
		foreach ($_POST as $key => $value) {
			if(array_key_exists($key, $hooks)){
				foreach ($value as $val) {
					if(!array_search($val, $hooks[$key])){
						$hooks[$key][] = $val;
						Addons::hook($val,$param = array());//添加到addons类里去
					}
				}
			}
		}
		if($o_hooks == $hooks){
			$flag = true;
		}else{
			//清除所有缓存，直接用的cleancache.php的方法
			$_GET['all'] = 1;
			include 'cleancache.php';
			ob_clean();
			$this->save_config($hooks,'hooks_config.php');
		}
		if($flag === true)
			$this->success('新增钩子成功');
		else
			$this->error('新增钩子失败');
	}

	//查看插件开发pdf
	public function view_doc(){
			$filename = '120501025933-f12fadefc26a436cbe70851b0eed10a8';
			$this->assign('filename',$filename);
			$this->display('view_pdf');
	}

	//钩子pdf 文件id
	public function view_pdf(){
			$filename = '120501032138-b484345e98ce448a8aa700150769f9f8';
			$this->assign('filename',$filename);
			$this->display('view_pdf');
	}

	// 保存配置
	public function save_config($config=array(), $config_file='custom.php'){
			// 检测目录是否存在
			$dirname =  ADDON_PATH.'/plugins/PluginBuilder/';
			if(!is_dir($dirname)){
					return $dirname.'不存在';
			}
			// 整理内容
			$config_content = "<?php\nreturn ".var_export($config, true).";";
			$config_content = str_replace('  ', "\t", $config_content);
			if(!file_put_contents($dirname.$config_file, $config_content)){
					return '写入'.$config_file.'失败';
			}
			// 保存成功
			return true;
	}

	//预览
	public function preview($output = true,$get_post=false){
		$post = $_POST;
		$br = PHP_EOL;
		$br2 = ';'.$br.'	';
		$str=<<<eo
<?php
/*本插件由thinksns 插件生成器 生成*/
class {$post['pluginFile']}Addons extends SimpleAddons {
	
eo;
		$str.='protected $version    = \''.$post['version'].'\''.$br2;
		$str.='protected $author     = \''.$post['author'].'\''.$br2;
		$str.='protected $site       = \''.$post['site'].'\''.$br2;
		$str.='protected $info       = \''.$post['info'].'\''.$br2;
		$str.='protected $pluginName = \''.$post['pluginName'].'\''.$br2;
		$str.='protected $tsVersion  = \''.$post['tsVersion'].'\''.$br2.$br;
		$hooks =<<<eo
	/**
	* getHooksInfo
	* 获得该插件使用了哪些钩子聚合类，哪些钩子是需要进行排序的
	* @access public
	* @return void
	*/
	public function getHooksInfo() {
eo;
		foreach ($post['hooks'] as $key => $value) {
			if($value['method'] && $value['hook']){
				$hooks .= $br.'		$this->apply(\''.$value['method'].'\',\''.$value['hook'].'\');';
			}else{
				unset($post['hooks'][$key]);
			}
		}
		//钩子
		$hooks .= ($post['hooks'])?$br:$br.$br;
		$hooks .= '	}'.$br;
		//方法
		$method ='';
		foreach ($post['hook_method'] as $key => $value) {
			if($value['name']){
				$method .= $br.'	//'.$value['comment'];
				$method .= $br.'	'.'public function '.$value['name'].'($param){';
				$method .= $br.$value['content'].$br.'	}'.$br;
			}else{
				unset($post['hook_method'][$key]);
			}
		}
		$method .= $br;
		//start函数
		$init = $br.'	public function start(){'.$br;
		$init .= ($post['start'])? $post['start']:'		return true;';
		$init .= $br.'	}'.$br;
		//install函数
		$install = $br.'	public function install(){'.$br;
		$install .= ($post['install'])? $post['install']:'		return parent::install();';
		$install .= $br.'	}'.$br;
		//uninstall函数
		$uninstall = $br.'	public function uninstall(){'.$br;
		$uninstall .= ($post['uninstall'])? $post['uninstall']:'		return parent::uninstall();';
		$uninstall .= $br.'	}'.$br;
		//后台菜单
		$adminMenu ='';
		$adminMenu .= $br.'	public function adminMenu(){'.$br.'		';
		$adminMenu .= ($post['adminMenu'])? 'return '.$this->format_arr($this->parse_str2arr($post['adminMenu']),$br) : '';
		$adminMenu .= $br.'	}'.$br; 
		$end = '}';
		$content = $str.$hooks.$method.$init.$install.$uninstall.$adminMenu.$end;
		if($get_post)	return $post;
		if($output){ 
			echo $content;
			exit;
		}else{	
			return $content;
		}
	}

	//表单检测
	public function checkForm($name){
		$model = model('Addons');
		//获取所有的插件名
		$result = $model->getAddonAllList();
		$result = array_merge($result['valid']['data'],$result['invalid']['data']);
		$this->addons = $result;
		$result = array();
		foreach ($this->addons as $value){
			$result[] = $value['name'];
		}
		$status = 0;
		//检测插件名
		$error = array();
		if($_POST['pluginFile'] ==''){
			$error['pluginFile'] = '插件名为空';
		}
		if(!$_POST['is_edit'] && in_array($_POST['pluginFile'],$result)){
			$error['pluginFile'] = '该插件名已被占用';
		}

		if($_POST['version'] == ''){
			$error['version'] = '请写插件版本';
		}

		if($_POST['author'] == ''){
			$error['author'] = '请写插件作者';
		}

		if($_POST['site'] == ''){
			$error['site'] = '请写个人站点，方便自我宣传';
		}

		if($_POST['pluginName'] == ''){
			$error['pluginName'] = '请填写插件名，做个有头有脸的插件';
		}

		if($_POST['info'] == ''){
			$error['info'] = '插件信息写详细点，让大家知道你是干哈的';
		}

		if(!$error) $status = 1;
		$this->ajaxReturn($error,$info,$status);
	}

	public function ajaxReturn($data,$info,$status){
		$result  =  array();
		$result['status']  =  $status;
		$result['info'] =  $info;
		$result['data'] = $data;
		// 返回JSON数据格式到客户端 包含状态信息
		header("Content-Type:text/html; charset=utf-8");
		exit(json_encode($result));
	}

	//解析0:管理,1:菜单这种字符串
	private function parse_str2arr($str){
		$list = array();
		$array = explode(',', $str);
		foreach ($array as $item) {
				$temp = explode(':', $item);
				$list[$temp[0]] = $temp[1];
		}
		return $list;
	}

	private function format_arr($arr,$br){
		$return ='array(';
		foreach ($arr as $key => $value) {
			$return .=$br.'			\''.$key.'\'=>\''.$value.'\',';
		}
		$return .=$br.'		);';
		return $return;
	}

	private function rmdirr($dirname) {
		if (!file_exists($dirname)) {
			return false;
		}
		if (is_file($dirname) || is_link($dirname)) {
			return unlink($dirname);
		}
		$dir = dir($dirname);
		while (false !== $entry = $dir->read()) {
			if ($entry == '.' || $entry == '..') {
				continue;
			}
			$this->rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
		}
		$dir->close();
		return rmdir($dirname);
	}
}