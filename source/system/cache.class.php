<?php
if(!defined('IN_ROOT')){exit('Access denied');}
class cache_lite{
	public $_dir;
	public $_time;
	public $_id;
	function __construct($options=array(NULL)){
		if(is_array($options)){
			$available_options = array('_dir', '_time');
			foreach($options as $key => $value){
				if(in_array($key, $available_options)){
					$this->$key = $value;
				}
			}
		}
	}
	function get($id){
		$this->_id = md5(md5($id));
		if(file_exists($this->_dir.$this->_id) && ((time() - filemtime($this->_dir.$this->_id)) < $this->_time)){
			if(PHP_VERSION >= '4.3.0'){
				$data = file_get_contents($this->_dir.$this->_id);
			}else{
				$handle = fopen($this->_dir.$this->_id, 'rb');
				$data = fread($handle, filesize($this->_dir.$this->_id));
				fclose($handle);
			}
			return $data;
		}else{
			return false;
		}
	}
	function save($data){
		if(!is_writable($this->_dir)){
			if(!@mkdir($this->_dir, 0777, true)){
				exit('Cache directory not writable');
			}
		}
		if(PHP_VERSION >= '5'){
			file_put_contents($this->_dir.$this->_id, $data);
		}else{
			$handle = fopen($this->_dir.$this->_id, 'wb');
			fwrite($handle, $data);
			fclose($handle);
		}
		return true;
	}
	function start($id){
		$data = $this->get($id);
		if(IN_CACHEOPEN == 1 && !checkmobile() && $data !== false){
			echo $data;
			return true;
		}
		ob_start();
		ob_implicit_flush(false);
		return false;
	}
	function end(){
		$data = ob_get_contents();
		ob_end_clean();
		if(IN_CACHEOPEN == 1 && !checkmobile()){
			$this->save($data);
		}
		echo $data;
	}
}
$cache = new cache_lite(array('_dir' => IN_ROOT.'./data/cache/', '_time' => IN_CACHETIME));
?>