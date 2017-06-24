<?php
class ftp{
        protected $conn_id;
        public function __construct($host, $port, $out, $user, $pw, $pasv){
                $this->conn_id = @ftp_connect($host, $port, 20) or die('0');
                $out && $this->set_option(FTP_TIMEOUT_SEC, $out);
                @ftp_login($this->conn_id, $user, $pw) or die('0');
                @ftp_pasv($this->conn_id, $pasv ? true : false);
        }
        public function f_put($src, $dst, $path){
                $dst && $this->m_kdir($dst);
                return @ftp_put($this->conn_id, $dst.$path, $src, intval(FTP_BINARY));
        }
	function set_option($cmd, $value){
		if(function_exists('ftp_set_option')){
			@ftp_set_option($this->conn_id, $cmd, $value);
		}
	}
        function m_kdir($dir){
                $array = explode('/', $dir);
                $count = count($array);
                foreach($array as $val){
                        if(!@ftp_chdir($this->conn_id, $val)){
                                @ftp_mkdir($this->conn_id, $val) or die('0');
                                @ftp_chdir($this->conn_id, $val);
                        }
                }
                for($i = 1; $i <= $count; $i++){
                        @ftp_cdup($this->conn_id);
                }
        }
        public function c_lose(){
                @ftp_close($this->conn_id);
        }
}
?>