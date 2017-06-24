<?php
if(!defined('OSS_API_PATH'))
define('OSS_API_PATH',dirname(__FILE__));
require_once OSS_API_PATH.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'requestcore'.DIRECTORY_SEPARATOR.'requestcore.class.php';
require_once OSS_API_PATH.DIRECTORY_SEPARATOR.'util'.DIRECTORY_SEPARATOR.'mimetypes.class.php';
try{
if(file_exists(OSS_API_PATH.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.LANG.'.inc.php')){
require_once OSS_API_PATH.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.LANG.'.inc.php';
}else{
throw new OSS_Exception(OSS_LANG_FILE_NOT_EXIST);
}
}catch (OSS_Exception $e){
die($e->getMessage());
}
define('OSS_NAME','oss-sdk-php');
define('OSS_VERSION','1.1.5');
define('OSS_BUILD','201210121010245');
define('OSS_AUTHOR','xiaobing.meng@alibaba-inc.com');
class OSS_Exception extends Exception {}
if(function_exists('get_loaded_extensions')){
$extensions = get_loaded_extensions();
if($extensions){
if(!in_array('curl',$extensions)){
throw new OSS_Exception(OSS_CURL_EXTENSION_MUST_BE_LOAD);
}
}else{
throw new OSS_Exception(OSS_NO_ANY_EXTENSIONS_LOADED);
}
}else{
throw new OSS_Exception('Function get_loaded_extensions has been disabled,Pls check php config.');
}
class ALIOSS{
const DEFAULT_OSS_HOST = 'oss.aliyuncs.com';
const NAME = OSS_NAME;
const BUILD = OSS_BUILD;
const VERSION = OSS_VERSION;
const AUTHOR = OSS_AUTHOR;
const OSS_BUCKET = 'bucket';
const OSS_OBJECT = 'object';
const OSS_HEADERS = 'headers';
const OSS_METHOD = 'method';
const OSS_QUERY = 'query';
const OSS_BASENAME = 'basename';
const OSS_MAX_KEYS = 'max-keys';
const OSS_UPLOAD_ID = 'uploadId';
const OSS_MAX_KEYS_VALUE = 100;
const OSS_MAX_OBJECT_GROUP_VALUE = 1000;
const OSS_FILE_SLICE_SIZE = 8192;
const OSS_PREFIX = 'prefix';
const OSS_DELIMITER = 'delimiter';
const OSS_MARKER = 'marker';
const OSS_CONTENT_MD5 = 'Content-Md5';
const OSS_CONTENT_TYPE = 'Content-Type';
const OSS_CONTENT_LENGTH = 'Content-Length';
const OSS_IF_MODIFIED_SINCE = 'If-Modified-Since';
const OSS_IF_UNMODIFIED_SINCE = 'If-Unmodified-Since';
const OSS_IF_MATCH = 'If-Match';
const OSS_IF_NONE_MATCH = 'If-None-Match';
const OSS_CACHE_CONTROL = 'Cache-Control';
const OSS_EXPIRES = 'Expires';
const OSS_PREAUTH = 'preauth';
const OSS_CONTENT_COING = 'Content-Coding';
const OSS_CONTENT_DISPOSTION = 'Content-Disposition';
const OSS_RANGE = 'Range';
const OS_CONTENT_RANGE = 'Content-Range';
const OSS_CONTENT = 'content';
const OSS_BODY = 'body';
const OSS_LENGTH = 'length';
const OSS_HOST = 'Host';
const OSS_DATE = 'Date';
const OSS_AUTHORIZATION = 'Authorization';
const OSS_FILE_DOWNLOAD = 'fileDownload';
const OSS_FILE_UPLOAD = 'fileUpload';
const OSS_PART_SIZE = 'partSize';
const OSS_SEEK_TO = 'seekTo';
const OSS_SIZE = 'size';
const OSS_QUERY_STRING = 'query_string';
const OSS_SUB_RESOURCE = 'sub_resource';
const OSS_DEFAULT_PREFIX = 'x-oss-';
const OSS_URL_ACCESS_KEY_ID = 'OSSAccessKeyId';
const OSS_URL_EXPIRES = 'Expires';
const OSS_URL_SIGNATURE = 'Signature';
const OSS_HTTP_GET = 'GET';
const OSS_HTTP_PUT = 'PUT';
const OSS_HTTP_HEAD = 'HEAD';
const OSS_HTTP_POST = 'POST';
const OSS_HTTP_DELETE = 'DELETE';
const OSS_ACL = 'x-oss-acl';
const OSS_OBJECT_GROUP = 'x-oss-file-group';
const OSS_MULTI_PART = 'uploads';
const OSS_MULTI_DELETE = 'delete';
const OSS_OBJECT_COPY_SOURCE = 'x-oss-copy-source';
const OSS_ACL_TYPE_PRIVATE = 'private';
const OSS_ACL_TYPE_PUBLIC_READ = 'public-read';
const OSS_ACL_TYPE_PUBLIC_READ_WRITE = 'public-read-write';
static $OSS_ACL_TYPES = array(
self::OSS_ACL_TYPE_PRIVATE,
self::OSS_ACL_TYPE_PUBLIC_READ,
self::OSS_ACL_TYPE_PUBLIC_READ_WRITE
);
protected $use_ssl = false;
private $debug_mode = true;
private $max_retries = 3;
private   $redirects = 0;
private $vhost;
private $enable_domain_style = false;
private  $request_url;
private $access_id;
private $access_key;
private $hostname;
private $port;
public function __construct($access_id = NULL,$access_key = NULL,$hostname = NULL  ){
if(!$access_id &&!defined('OSS_ACCESS_ID')){
throw new OSS_Exception(NOT_SET_OSS_ACCESS_ID);
}
if(!$access_key &&!defined('OSS_ACCESS_KEY')){
throw new OSS_Exception(NOT_SET_OSS_ACCESS_KEY);
}
if($access_id &&$access_key){
$this->access_id = $access_id;
$this->access_key = $access_key;
}elseif (defined('OSS_ACCESS_ID') &&defined('OSS_ACCESS_KEY')){
$this->access_id = OSS_ACCESS_ID;
$this->access_key = OSS_ACCESS_KEY;
}else{
throw new OSS_Exception(NOT_SET_OSS_ACCESS_ID_AND_ACCESS_KEY);
}
if(empty($this->access_id) ||empty($this->access_key)){
throw new OSS_Exception(OSS_ACCESS_ID_OR_ACCESS_KEY_EMPTY);
}
if(NULL === $hostname){
$this->hostname = self::DEFAULT_OSS_HOST;
}else{
$this->hostname = $hostname;
}
}
public function set_debug_mode($debug_mode = true){
$this->debug_mode = $debug_mode;
}
public function set_max_retries($max_retries = 3){
$this->max_retries = $max_retries;
}
public function get_max_retries(){
return $this->max_retries;
}
public function set_host_name($hostname,$port = null){
$this->hostname = $hostname;
if($port){
$this->port = $port;
$this->hostname .= ':'.$port;
}
}
public function set_vhost($vhost){
$this->vhost = $vhost;
}
public function set_enable_domain_style($enable_domain_style = true){
$this->enable_domain_style = $enable_domain_style;
}
public function auth($options){
$msg = "---LOG START---------------------------------------------------------------------------\n";
if(!( ('/'== $options[self::OSS_OBJECT]) &&(''== $options[self::OSS_BUCKET]) &&('GET'== $options[self::OSS_METHOD])) &&!$this->validate_bucket($options[self::OSS_BUCKET])){
throw new OSS_Exception('"'.$options[self::OSS_BUCKET].'"'.OSS_BUCKET_NAME_INVALID);
}
if(isset($options[self::OSS_OBJECT]) &&!$this->validate_object($options[self::OSS_OBJECT])){
throw  new OSS_Exception($options[self::OSS_OBJECT].OSS_OBJECT_NAME_INVALID);
}
if($this->is_gb2312($options[self::OSS_OBJECT])){
$options[self::OSS_OBJECT] = iconv('GB2312',"UTF-8",$options[self::OSS_OBJECT]);
}elseif($this->check_char($options[self::OSS_OBJECT],true)){
$options[self::OSS_OBJECT] = iconv('GBK',"UTF-8",$options[self::OSS_OBJECT]);
}
if(isset($options[self::OSS_HEADERS][self::OSS_ACL]) &&!empty($options[self::OSS_HEADERS][self::OSS_ACL])){
if(!in_array(strtolower($options[self::OSS_HEADERS][self::OSS_ACL]),self::$OSS_ACL_TYPES)){
throw new OSS_Exception($options[self::OSS_HEADERS][self::OSS_ACL].':'.OSS_ACL_INVALID);
}
}
$scheme = $this->use_ssl ?'https://': 'http://';
if($this->enable_domain_style){
$hostname = $this->vhost ?$this->vhost : (($options[self::OSS_BUCKET] =='')?$this->hostname:($options[self::OSS_BUCKET].'.').$this->hostname);
}else{
$hostname = (isset($options[self::OSS_BUCKET]) &&''!==$options[self::OSS_BUCKET])?$this->hostname.'/'.$options[self::OSS_BUCKET]:$this->hostname;
}
$resource = '';
$sub_resource = '';
$signable_resource = '';
$query_string_params = array();
$signable_query_string_params = array();
$string_to_sign = '';
$headers = array (
self::OSS_CONTENT_MD5 =>'',
self::OSS_CONTENT_TYPE =>isset($options[self::OSS_CONTENT_TYPE])?$options[self::OSS_CONTENT_TYPE]:'application/x-www-form-urlencoded',
self::OSS_DATE =>isset($options[self::OSS_DATE])?$options[self::OSS_DATE]: gmdate('D, d M Y H:i:s \G\M\T'),
self::OSS_HOST =>$this->enable_domain_style?$hostname:$this->hostname,
);
if(isset ( $options [self::OSS_OBJECT] ) &&'/'!== $options [self::OSS_OBJECT]){
$signable_resource = '/'.str_replace('%2F','/',rawurlencode($options[self::OSS_OBJECT]));
}
if(isset($options[self::OSS_QUERY_STRING])){
$query_string_params = array_merge($query_string_params,$options[self::OSS_QUERY_STRING]);
}
$query_string = $this->to_query_string($query_string_params);
$signable_list = array(
'partNumber',
'uploadId',
);
foreach ($signable_list as $item){
if(isset($options[$item])){
$signable_query_string_params[$item] = $options[$item];
}
}
$signable_query_string = $this->to_query_string($signable_query_string_params);
if (isset ( $options [self::OSS_HEADERS] )) {
$headers = array_merge ( $headers,$options [self::OSS_HEADERS] );
}
$conjunction = '?';
$non_signable_resource = '';
if (isset($options[self::OSS_SUB_RESOURCE])){
$signable_resource .= $conjunction .$options[self::OSS_SUB_RESOURCE];
$conjunction = '&';
}
if($signable_query_string !== ''){
$signable_query_string = $conjunction.$signable_query_string;
$conjunction = '&';
}
if($query_string !== ''){
$non_signable_resource .= $conjunction .$query_string;
$conjunction = '&';
}
$this->request_url = 	 $scheme .$hostname .$signable_resource .$signable_query_string .$non_signable_resource;
$msg .= "--REQUEST URL:----------------------------------------------\n".$this->request_url."\n";
$request = new RequestCore($this->request_url);
if (isset($options[self::OSS_FILE_UPLOAD])){
if (is_resource($options[self::OSS_FILE_UPLOAD])){
$length = null;
if (isset($options[self::OSS_CONTENT_LENGTH])){
$length = $options[self::OSS_CONTENT_LENGTH];
}elseif (isset($options[self::OSS_SEEK_TO])){
$stats = fstat($options[self::OSS_FILE_UPLOAD]);
if ($stats &&$stats[self::OSS_SIZE] >= 0){
$length = $stats[self::OSS_SIZE] -(integer) $options[self::OSS_SEEK_TO];
}
}
$request->set_read_stream($options[self::OSS_FILE_UPLOAD],$length);
if ($headers[self::OSS_CONTENT_TYPE] === 'application/x-www-form-urlencoded'){
$headers[self::OSS_CONTENT_TYPE] = 'application/octet-stream';
}
}else{
$request->set_read_file($options[self::OSS_FILE_UPLOAD]);
$length = $request->read_stream_size;
if (isset($options[self::OSS_CONTENT_LENGTH])){
$length = $options[self::OSS_CONTENT_LENGTH];
}elseif (isset($options[self::OSS_SEEK_TO]) &&isset($length)){
$length -= (integer) $options[self::OSS_SEEK_TO];
}
$request->set_read_stream_size($length);
if (isset($headers[self::OSS_CONTENT_TYPE]) &&($headers[self::OSS_CONTENT_TYPE] === 'application/x-www-form-urlencoded')){
$extension = explode('.',$options[self::OSS_FILE_UPLOAD]);
$extension = array_pop($extension);
$mime_type = MimeTypes::get_mimetype($extension);
$headers[self::OSS_CONTENT_TYPE] = $mime_type;
}
}
$options[self::OSS_CONTENT_MD5] = '';
}
if (isset($options[self::OSS_SEEK_TO])){
$request->set_seek_position((integer) $options[self::OSS_SEEK_TO]);
}
if (isset($options[self::OSS_FILE_DOWNLOAD])){
if (is_resource($options[self::OSS_FILE_DOWNLOAD])){
$request->set_write_stream($options[self::OSS_FILE_DOWNLOAD]);
}else{
$request->set_write_file($options[self::OSS_FILE_DOWNLOAD]);
}
}
if(isset($options[self::OSS_METHOD])){
$request->set_method($options[self::OSS_METHOD]);
$string_to_sign .= $options[self::OSS_METHOD] ."\n";
}
if (isset ( $options [self::OSS_CONTENT] )) {
$request->set_body ( $options [self::OSS_CONTENT] );
if ($headers[self::OSS_CONTENT_TYPE] === 'application/x-www-form-urlencoded'){
$headers[self::OSS_CONTENT_TYPE] = 'application/octet-stream';
}
$headers[self::OSS_CONTENT_LENGTH] = strlen($options [self::OSS_CONTENT]);
$headers[self::OSS_CONTENT_MD5] = $this->hex_to_base64(md5($options[self::OSS_CONTENT]));
}
uksort($headers,'strnatcasecmp');
foreach ( $headers as $header_key =>$header_value ) {
$header_value = str_replace ( array ("\r","\n"),'',$header_value );
if ($header_value !== '') {
$request->add_header ( $header_key,$header_value );
}
if (
strtolower($header_key) === 'content-md5'||
strtolower($header_key) === 'content-type'||
strtolower($header_key) === 'date'||
(isset($options['self::OSS_PREAUTH']) &&(integer) $options['self::OSS_PREAUTH'] >0)
){
$string_to_sign .= $header_value ."\n";
}elseif (substr(strtolower($header_key),0,6) === self::OSS_DEFAULT_PREFIX){
$string_to_sign .= strtolower($header_key) .':'.$header_value ."\n";
}
}
$string_to_sign .= '/'.$options[self::OSS_BUCKET];
$string_to_sign .=  $this->enable_domain_style ?($options[self::OSS_BUCKET]!=''?($options[self::OSS_OBJECT]=='/'?'/':'') :'') : '';
$string_to_sign .= rawurldecode($signable_resource) .urldecode($signable_query_string);
$msg .= "STRING TO SIGN:----------------------------------------------\n".$string_to_sign."\n";
$signature = base64_encode(hash_hmac('sha1',$string_to_sign,$this->access_key,true));
$request->add_header('Authorization','OSS '.$this->access_id .':'.$signature);
if (isset($options[self::OSS_PREAUTH]) &&(integer) $options[self::OSS_PREAUTH] >0){
return $this->request_url .$conjunction .self::OSS_URL_ACCESS_KEY_ID.'='.$this->access_id .'&'.self::OSS_URL_EXPIRES.'='.$options[self::OSS_PREAUTH] .'&'.self::OSS_URL_SIGNATURE.'='.rawurlencode($signature);
}elseif (isset($options[self::OSS_PREAUTH])){
return $this->request_url;
}
if ($this->debug_mode){
$request->debug_mode = $this->debug_mode;
}
$msg .= "REQUEST HEADERS:----------------------------------------------\n".serialize($request->request_headers)."\n";
$request->send_request();
$response_header = $request->get_response_header();
$response_header['x-oss-request-url'] = $this->request_url;
$response_header['x-oss-redirects'] = $this->redirects;
$response_header['x-oss-stringtosign'] = $string_to_sign;
$response_header['x-oss-requestheaders'] = $request->request_headers;
$msg .= "RESPONSE HEADERS:----------------------------------------------\n".serialize($response_header)."\n";
$data =  new ResponseCore ( $response_header ,$request->get_response_body (),$request->get_response_code () );
if((integer)$request->get_response_code() === 400  ||(integer)$request->get_response_code() === 500  ||(integer)$request->get_response_code() === 503 ){
if($this->redirects <= $this->max_retries ){
$delay = (integer) (pow(4,$this->redirects) * 100000);
usleep($delay);
$this->redirects++;
$data = $this->auth($options);
}
}
$msg .= "RESPONSE DATA:----------------------------------------------\n".serialize($data)."\n";
$msg .= date('Y-m-d H:i:s').":---LOG END---------------------------------------------------------------------------\n";
$this->log($msg);
$this->redirects = 0;
return $data;
}
public function list_bucket($options = NULL) {
$this->validate_options($options);
if (!$options) {
$options = array ();
}
$options[self::OSS_BUCKET] = '';
$options[self::OSS_METHOD] = 'GET';
$options[self::OSS_OBJECT] = '/';
$response = $this->auth ( $options );
return $response;
}
public function create_bucket($bucket,$acl = self::OSS_ACL_TYPE_PRIVATE,$options = NULL){
$this->validate_options($options);
if (!$options) {
$options = array ();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'PUT';
$options[self::OSS_OBJECT] = '/';
$options[self::OSS_HEADERS] = array(self::OSS_ACL =>$acl);
$response = $this->auth ( $options );
return $response;
}
public function delete_bucket($bucket,$options = NULL){
$this->validate_options($options);
if (!$options) {
$options = array ();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'DELETE';
$options[self::OSS_OBJECT] = '/';
$response = $this->auth ( $options );
return $response;
}
public function get_bucket_acl($bucket ,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'GET';
$options[self::OSS_OBJECT] = '/';
$options[self::OSS_SUB_RESOURCE] = 'acl';
$response = $this->auth ( $options );
return $response;
}
public function set_bucket_acl($bucket ,$acl ,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'PUT';
$options[self::OSS_OBJECT] = '/';
$options[self::OSS_HEADERS] = array(self::OSS_ACL =>$acl);
$response = $this->auth ( $options );
return $response;
}
public function list_object($bucket,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'GET';
$options[self::OSS_OBJECT] = '/';
$options[self::OSS_HEADERS] = array(
self::OSS_DELIMITER =>isset($options[self::OSS_DELIMITER])?$options[self::OSS_DELIMITER]:'/',
self::OSS_PREFIX =>isset($options[self::OSS_PREFIX])?$options[self::OSS_PREFIX]:'',
self::OSS_MAX_KEYS =>isset($options[self::OSS_MAX_KEYS])?$options[self::OSS_MAX_KEYS]:self::OSS_MAX_KEYS_VALUE,
self::OSS_MARKER =>isset($options[self::OSS_MARKER])?$options[self::OSS_MARKER]:'',
);
$response = $this->auth ( $options );
return $response;
}
public function create_object_dir($bucket,$object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'PUT';
$options[self::OSS_OBJECT] = $object.'/';
$options[self::OSS_CONTENT_LENGTH] = array(self::OSS_CONTENT_LENGTH =>0);
$response = $this->auth ( $options );
return $response;
}
public function upload_file_by_content($bucket,$object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$this->validate_content($options);
$objArr = explode('/',$object);
$basename = array_pop($objArr);
$extension = explode ( '.',$basename );
$extension = array_pop ( $extension );
$content_type = MimeTypes::get_mimetype(strtolower($extension));
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'PUT';
$options[self::OSS_OBJECT] = $object;
if(!isset($options[self::OSS_LENGTH])){
$options[self::OSS_CONTENT_LENGTH] = strlen($options[self::OSS_CONTENT]);
}else{
$options[self::OSS_CONTENT_LENGTH] = $options[self::OSS_LENGTH];
}
if(!isset($options[self::OSS_CONTENT_TYPE]) &&isset($content_type) &&!empty($content_type) ){
$options[self::OSS_CONTENT_TYPE] = $content_type;
}
$response = $this->auth ( $options );
return $response;
}
public function upload_file_by_file($bucket,$object,$file,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($file,OSS_FILE_PATH_IS_NOT_ALLOWED_EMPTY);
if($this->chk_chinese($file)){
$file = iconv('utf-8','gbk',$file);
}
$options[self::OSS_FILE_UPLOAD] = $file;
if(!file_exists($options[self::OSS_FILE_UPLOAD])){
throw new OSS_Exception($options[self::OSS_FILE_UPLOAD].OSS_FILE_NOT_EXIST);
}
$filesize = filesize($options[self::OSS_FILE_UPLOAD]);
$partsize = 1024 * 1024 ;
$extension = explode ( '.',$file );
$extension = array_pop ( $extension );
$content_type = MimeTypes::get_mimetype(strtolower($extension));
$options[self::OSS_METHOD] = self::OSS_HTTP_PUT;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = $object;
$options[self::OSS_CONTENT_TYPE] = $content_type;
$options[self::OSS_CONTENT_LENGTH] = $filesize;
$response = $this->auth($options);
return $response;
}
public function copy_object($from_bucket,$from_object,$to_bucket,$to_object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($from_bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($to_bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($from_object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($to_object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $to_bucket;
$options[self::OSS_METHOD] = 'PUT';
$options[self::OSS_OBJECT] = $to_object;
$options[self::OSS_HEADERS] = array(self::OSS_OBJECT_COPY_SOURCE =>'/'.$from_bucket.'/'.$from_object);
$response = $this->auth ( $options );
return $response;
}
public function get_object_meta($bucket,$object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'HEAD';
$options[self::OSS_OBJECT] = $object;
$response = $this->auth ( $options );
return $response;
}
public function delete_object($bucket,$object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'DELETE';
$options[self::OSS_OBJECT] = $object;
$response = $this->auth ( $options );
return $response;
}
public function delete_objects($bucket,$objects,$options = null){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
if(!is_array($objects) ||!$objects){
throw new OSS_Exception('The '.__FUNCTION__ .' method requires the "objects" option to be set as an array.');
}
$options[self::OSS_METHOD] = self::OSS_HTTP_POST;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = '/';
$options[self::OSS_SUB_RESOURCE] = 'delete';
$options[self::OSS_CONTENT_TYPE] = 'application/xml';
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Delete></Delete>');
if (isset($options['quiet'])){
$quiet = 'false';
if (is_bool($options['quiet'])) {
$quiet = $options['quiet'] ?'true': 'false';
}elseif (is_string($options['quiet'])){
$quiet = ($options['quiet'] === 'true') ?'true': 'false';
}
$xml->addChild('Quiet',$quiet);
}
foreach ($objects as $object){
$xobject = $xml->addChild('Object');
$object = $this->s_replace($object);
$xobject->addChild('Key',$object);
}
$options[self::OSS_CONTENT] = $xml->asXML();
return $this->auth($options);
}
public function get_object($bucket,$object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
if(isset($options[self::OSS_FILE_DOWNLOAD]) &&$this->chk_chinese($options[self::OSS_FILE_DOWNLOAD])){
$options[self::OSS_FILE_DOWNLOAD] = iconv('utf-8','gbk',$options[self::OSS_FILE_DOWNLOAD]);
}
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'GET';
$options[self::OSS_OBJECT] = $object;
if(isset($options['lastmodified'])){
$options[self::OSS_HEADERS][self::OSS_IF_MODIFIED_SINCE] = $options['lastmodified'];
unset($options['lastmodified']);
}
if(isset($options['etag'])){
$options[self::OSS_HEADERS][self::OSS_IF_NONE_MATCH] = $options['etag'];
unset($options['etag']);
}
if(isset($options['range'])){
$options[self::OSS_HEADERS][self::OSS_RANGE] = 'bytes='.$options['range'];
unset($options['range']);
}
return $this->auth ( $options );
}
public function is_object_exist($bucket,$object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'GET';
$options[self::OSS_OBJECT] = $object;
$response = $this->get_object_meta($bucket,$object,$options);
return $response;
}
public function get_multipart_counts($filesize,$part_size = 5242880 ){
$i = 0;
$sizecount = $filesize;
$values = array();
if((integer)$part_size <= 5242880){
$part_size = 5242880;
}elseif ((integer)$part_size >524288000){
$part_size = 524288000;
}else{
$part_size = 52428800;
}
while ($sizecount >0)
{
$sizecount -= $part_size;
$values[] = array(
self::OSS_SEEK_TO =>($part_size * $i),
self::OSS_LENGTH =>(($sizecount >0) ?$part_size : ($sizecount +$part_size)),
);
$i++;
}
return $values;
}
public function initiate_multipart_upload($bucket,$object,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_METHOD] = self::OSS_HTTP_POST;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = $object;
$options[self::OSS_SUB_RESOURCE] = 'uploads';
$options[self::OSS_CONTENT] = '';
$options[self::OSS_HEADERS] = array(self::OSS_CONTENT_TYPE =>'application/octet-stream');
$response = $this->auth ( $options );
return $response;
}
public function upload_part($bucket,$object,$upload_id,$options = null){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
if (!isset($options[self::OSS_FILE_UPLOAD]) ||!isset($options['partNumber'])){
throw new OSS_Exception('The `fileUpload` and `partNumber` options are both required in '.__FUNCTION__ .'().');
}
$options[self::OSS_METHOD] = self::OSS_HTTP_PUT;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = $object;
$options[self::OSS_UPLOAD_ID] = $upload_id;
if(isset($options[self::OSS_LENGTH])){
$options[self::OSS_CONTENT_LENGTH] =  $options[self::OSS_LENGTH];
}
return $this->auth($options);
}
public function list_parts($bucket,$object,$upload_id,$options = null){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_METHOD] = self::OSS_HTTP_GET;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = $object;
$options[self::OSS_UPLOAD_ID] = $upload_id;
$options[self::OSS_QUERY_STRING] = array();
foreach (array('max-parts','part-number-marker') as $param){
if (isset($options[$param])){
$options[self::OSS_QUERY_STRING][$param] = $options[$param];
unset($options[$param]);
}
}
return $this->auth($options);
}
public function abort_multipart_upload($bucket,$object,$upload_id,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_METHOD] = self::OSS_HTTP_DELETE;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = $object;
$options[self::OSS_UPLOAD_ID] = $upload_id;
return $this->auth($options);
}
public function complete_multipart_upload($bucket,$object,$upload_id,$parts,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_METHOD] = self::OSS_HTTP_POST;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = $object;
$options[self::OSS_UPLOAD_ID] = $upload_id;
$options[self::OSS_CONTENT_TYPE] = 'application/xml';
if(is_string($parts)){
$options[self::OSS_CONTENT] = $parts;
}else if($parts instanceof SimpleXMLElement){
$options[self::OSS_CONTENT] = $parts->asXML();
}else if((is_array($parts) ||$parts instanceof ResponseCore)){
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><CompleteMultipartUpload></CompleteMultipartUpload>');
if (is_array($parts)){
foreach ($parts as $node){
$part = $xml->addChild('Part');
$part->addChild('PartNumber',$node['PartNumber']);
$part->addChild('ETag',$node['ETag']);
}
}elseif ($parts instanceof ResponseCore){
foreach ($parts->body->Part as $node){
$part = $xml->addChild('Part');
$part->addChild('PartNumber',(string) $node->PartNumber);
$part->addChild('ETag',(string) $node->ETag);
}
}
$options[self::OSS_CONTENT] = $xml->asXML();
}
return $this->auth($options);
}
public function list_multipart_uploads($bucket,$options = null){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_METHOD] = self::OSS_HTTP_GET;
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = '/';
$options[self::OSS_SUB_RESOURCE] = 'uploads';
foreach (array('key-marker','max-uploads','upload-id-marker') as $param){
if (isset($options[$param])){
$options[self::OSS_QUERY_STRING][$param] = $options[$param];
unset($options[$param]);
}
}
return $this->auth($options);
}
public function create_mpu_object($bucket,$object,$options = null){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
if(isset($options[self::OSS_LENGTH])){
$options[self::OSS_CONTENT_LENGTH] = $options[self::OSS_LENGTH];
unset($options[self::OSS_LENGTH]);
}
if(isset($options[self::OSS_FILE_UPLOAD])){
if($this->chk_chinese($options[self::OSS_FILE_UPLOAD])){
$options[self::OSS_FILE_UPLOAD] = mb_convert_encoding($options[self::OSS_FILE_UPLOAD],'UTF-8');
}
}
if(!isset($options[self::OSS_FILE_UPLOAD])){
throw new OSS_Exception('The `fileUpload` option is required in '.__FUNCTION__ .'().');
}elseif (is_resource($options[self::OSS_FILE_UPLOAD])){
$upload_position = isset($options[self::OSS_SEEK_TO]) ?(integer) $options[self::OSS_SEEK_TO] : ftell($options[self::OSS_FILE_UPLOAD]);
$upload_filesize = isset($options[self::OSS_CONTENT_LENGTH]) ?(integer) $options[self::OSS_CONTENT_LENGTH] : null;
if (!isset($upload_filesize) &&$upload_position !== false){
$stats = fstat($options[self::OSS_FILE_UPLOAD]);
if ($stats &&$stats[self::OSS_SIZE] >= 0){
$upload_filesize = $stats[self::OSS_SIZE] -$upload_position;
}
}
}else{
$upload_position = isset($options[self::OSS_SEEK_TO]) ?(integer) $options[self::OSS_SEEK_TO] : 0;
if (isset($options[self::OSS_CONTENT_TYPE])){
$upload_filesize = (integer) $options[self::OSS_CONTENT_TYPE];
}
else{
$upload_filesize = filesize($options[self::OSS_FILE_UPLOAD]);
if ($upload_filesize !== false){
$upload_filesize -= $upload_position;
}
}
}
if ($upload_position === false ||!isset($upload_filesize) ||$upload_filesize === false ||$upload_filesize <0){
throw new OSS_Exception('The size of `fileUpload` cannot be determined in '.__FUNCTION__ .'().');
}
if (isset($options[self::OSS_PART_SIZE])){
if ((integer) $options[self::OSS_PART_SIZE] <= 5242880){
$options[self::OSS_PART_SIZE] = 5242880;
}
elseif ((integer) $options[self::OSS_PART_SIZE] >524288000){
$options[self::OSS_PART_SIZE] = 524288000;
}
}
else{
$options[self::OSS_PART_SIZE] = 52428800;
}
if ($upload_filesize <$options[self::OSS_PART_SIZE] &&!isset($options['uploadId'])){
return $this->upload_file_by_file($bucket,$object,$options[self::OSS_FILE_UPLOAD]);
}
if (isset($options['uploadId'])){
$upload_id = $options['uploadId'];
}else{
$upload = $this->initiate_multipart_upload($bucket,$object);
if (!$upload->isOK()){
throw new OSS_Exception('Init multi-part upload failed...');
}
$xml = new SimpleXmlIterator($upload->body);
$uploadId = (string)$xml->UploadId;
}
$pieces = $this->get_multipart_counts($upload_filesize,(integer) $options[self::OSS_PART_SIZE]);
$response_upload_part = array();
foreach ($pieces as $i =>$piece){
$response_upload_part[] = $this->upload_part($bucket,$object,$uploadId,array(
self::OSS_FILE_UPLOAD =>$options[self::OSS_FILE_UPLOAD],
'partNumber'=>($i +1),
self::OSS_SEEK_TO =>$upload_position +(integer) $piece[self::OSS_SEEK_TO],
self::OSS_LENGTH =>(integer) $piece[self::OSS_LENGTH],
));
}
$upload_parts = array();
$upload_part_result = true;
foreach ($response_upload_part as $i=>$response){
$upload_part_result = $upload_part_result &&$response->isOk();
}
if(!$upload_part_result){
throw new OSS_Exception('any part upload failed...,pls try again');
}
foreach ($response_upload_part as $i=>$response){
$upload_parts[] = array(
'PartNumber'=>($i +1),
'ETag'=>(string) $response->header['etag']
);
}
return $this->complete_multipart_upload($bucket,$object,$uploadId,$upload_parts);
}
public function create_mtu_object_by_dir($bucket,$dir,$recursive = false,$exclude = ".|..|.svn",$options = null){
$this->validate_options($options);
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
if($this->chk_chinese($dir)){
$dir = iconv('utf-8','gbk',$dir);
}
if(!is_dir($dir)){
throw new OSS_Exception($dir.' is not a directory...,pls check it');
}
$file_list_array = $this->read_dir($dir,$exclude,$recursive);
if(!$file_list_array){
throw new OSS_Exception($dir.' is empty...');
}
$index = 1;
foreach ($file_list_array as $item){
$options = array(
self::OSS_FILE_UPLOAD =>$item['path'],
self::OSS_PART_SIZE =>5242880,
);
echo $index++.". ";
$response = $this->create_mpu_object($bucket,$item['file'],$options);
if($response->isOK()){
echo "Upload file {".$item['path']." } successful..\n";
}else{
echo "Upload file {".$item['path']." } failed..\n";
continue;
}
}
}
public function batch_upload_file($options = NULL){
if((NULL == $options) ||!isset($options['bucket']) ||empty($options['bucket']) ||!isset($options['directory']) ||empty($options['directory']) ) {
throw new OSS_Exception('Bad Request',400);
}
$bucket = $options['bucket'];unset($options['bucket']);
$directory = $options['directory'];unset($options['directory']);
if($this->chk_chinese($directory)){
$directory = iconv('utf-8','gbk',$directory);
}
if(!is_dir($directory)){
throw new OSS_Exception($dir.' is not a directory...,pls check it');
}
$object = '';
if(isset($options['object'])){
$object = $options['object'];
unset($options['object']);
}
$exclude = '.|..|.svn';
if (isset($options['exclude']) &&!empty($options['exclude'])){
$exclude = $options['exclude'];
unset($options['exclude']);
}
$recursive = false;
if(isset($options['recursive']) &&!empty($options['recursive'])){
if(in_array($options['recursive'],array(true,false))){
$recursive = $options['recursive'];
}
unset($options['recursive']);
}
$file_list_array = $this->read_dir($directory,$exclude,$recursive);
if(!$file_list_array){
throw new OSS_Exception($directory.' is empty...');
}
$index = 1;
foreach ($file_list_array as $item){
$options = array(
self::OSS_FILE_UPLOAD =>$item['path'],
self::OSS_PART_SIZE =>5242880,
);
echo $index++.". ";
$response = $this->create_mpu_object($bucket,(!empty($object)?$object.'/':'').$item['file'],$options);
if($response->isOK()){
echo "Upload file {".$item['path']." } successful..\n";
}else{
echo "Upload file {".$item['path']." } failed..\n";
continue;
}
}
}
public function create_object_group($bucket,$object_group  ,$object_arry,$options = NULL){
$this->validate_options($options);
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object_group,OSS_OBJECT_GROUP_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'POST';
$options[self::OSS_OBJECT] = $object_group;
$options[self::OSS_CONTENT_TYPE] = 'txt/xml';
$options[self::OSS_SUB_RESOURCE] = 'group';
$options[self::OSS_CONTENT] = $this->make_object_group_xml($bucket,$object_arry);
$response = $this->auth ( $options );
return $response;
}
public function get_object_group($bucket,$object_group,$options = NULL){
$this->validate_options($options);
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object_group,OSS_OBJECT_GROUP_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'GET';
$options[self::OSS_OBJECT] = $object_group;
$options[self::OSS_HEADERS] = array(self::OSS_OBJECT_GROUP =>self::OSS_OBJECT_GROUP);
$response = $this->auth ( $options );
return $response;
}
public function get_object_group_index($bucket,$object_group,$options = NULL){
$this->validate_options($options);
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object_group,OSS_OBJECT_GROUP_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'GET';
$options[self::OSS_OBJECT] = $object_group;
$options[self::OSS_CONTENT_TYPE] = 'application/xml';
$options[self::OSS_HEADERS] = array(self::OSS_OBJECT_GROUP =>self::OSS_OBJECT_GROUP);
$response = $this->auth ( $options );
return $response;
}
public function get_object_group_meta($bucket,$object_group,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object_group,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'HEAD';
$options[self::OSS_OBJECT] = $object_group;
$options[self::OSS_CONTENT_TYPE] = 'application/xml';
$options[self::OSS_HEADERS] = array(self::OSS_OBJECT_GROUP =>self::OSS_OBJECT_GROUP);
$response = $this->auth ( $options );
return $response;
}
public function delete_object_group($bucket,$object_group,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object_group,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_METHOD] = 'DELETE';
$options[self::OSS_OBJECT] = $object_group;
$response = $this->auth ( $options );
return $response;
}
public function get_sign_url($bucket,$object,$timeout = 60,$options = NULL){
$this->validate_options($options);
if(!$options){
$options = array();
}
$this->is_empty($bucket,OSS_BUCKET_IS_NOT_ALLOWED_EMPTY);
$this->is_empty($object,OSS_OBJECT_IS_NOT_ALLOWED_EMPTY);
$options[self::OSS_BUCKET] = $bucket;
$options[self::OSS_OBJECT] = $object;
$options[self::OSS_METHOD] = self::OSS_HTTP_GET;
$options[self::OSS_CONTENT_TYPE] = '';
$timeout = time() +$timeout;
$options[self::OSS_PREAUTH] = $timeout;
$options[self::OSS_DATE] = $timeout;
return $this->auth($options);
}
private function log($msg){
if(defined('ALI_LOG_PATH') ){
$log_path = ALI_LOG_PATH;
if(empty($log_path) ||!file_exists($log_path)){
throw new OSS_Exception($log_path.OSS_LOG_PATH_NOT_EXIST);
}
}else{
$log_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR;
}
if(!file_exists($log_path)){
throw new OSS_Exception(OSS_LOG_PATH_NOT_EXIST);
}
$log_name = $log_path.'oss_sdk_php_'.date('Y-m-d').'.log';
if(ALI_DISPLAY_LOG){
echo $msg."\n<br/>";
}
if(ALI_LOG){
if(!error_log(date('Y-m-d H:i:s')." : ".$msg."\n",3,$log_name)){
throw new OSS_Exception(OSS_WRITE_LOG_TO_FILE_FAILED);
}
}
}
public function to_query_string($options = array()){
$temp = array();
foreach ($options as $key =>$value){
if (is_string($key) &&!is_array($value)){
$temp[] = rawurlencode($key) .'='.rawurlencode($value);
}
}
return implode('&',$temp);
}
private function hex_to_base64($str){
$result = '';
for ($i = 0;$i <strlen($str);$i += 2){
$result .= chr(hexdec(substr($str,$i,2)));
}
return base64_encode($result);
}
private function s_replace($subject){
$search = array('<','>','&','\'','"');
$replace = array('&lt;','&gt;','&amp;','&apos;','&quot;');
return str_replace($search,$replace,$subject);
}
private function chk_chinese($str){
return preg_match('/[\x80-\xff]./',$str);
}
function is_gb2312($str)  {
for($i=0;$i<strlen($str);$i++) {
$v = ord( $str[$i] );
if( $v >127) {
if( ($v >= 228) &&($v <= 233) ){
if( ($i+2) >= (strlen($str) -1)) return true;
$v1 = ord( $str[$i+1] );
$v2 = ord( $str[$i+2] );
if( ($v1 >= 128) &&($v1 <=191) &&($v2 >=128) &&($v2 <= 191) )  
return false;
else  
return true;
}
}
}
}
private function check_char($str,$gbk = true){
for($i=0;$i<strlen($str);$i++) {
$v = ord( $str[$i] );
if( $v >127){
if( ($v >= 228) &&($v <= 233) ){
if(($i+2)>= (strlen($str)-1)) return $gbk?true:FALSE;
$v1 = ord( $str[$i+1] );$v2 = ord( $str[$i+2] );
if($gbk){
return (($v1 >= 128) &&($v1 <=191) &&($v2 >=128) &&($v2 <= 191))?FALSE:TRUE;
}else{
return (($v1 >= 128) &&($v1 <=191) &&($v2 >=128) &&($v2 <= 191))?TRUE:FALSE;
}
}
}
}
return $gbk?TRUE:FALSE;
}
private  function read_dir($dir,$exclude = ".|..|.svn",$recursive = false){
static $file_list_array = array();
$exclude_array = explode("|",$exclude);
if($handle = opendir($dir)){
while ( false !== ($file = readdir($handle))){
if(!in_array(strtolower($file),$exclude_array)){
$new_file = $dir.'/'.$file;
if(is_dir($new_file) &&$recursive){
$this->read_dir($new_file,$exclude,$recursive);
}else{
$file_list_array[] = array(
'path'=>$new_file,
'file'=>$file,
);
}
}
}
closedir($handle);
}
return $file_list_array;
}
private function make_object_group_xml($bucket,$object_array){
$xml = '';
$xml .= '<CreateFileGroup>';
if($object_array){
if(count($object_array) >self::OSS_MAX_OBJECT_GROUP_VALUE){
throw new OSS_Exception(OSS_OBJECT_GROUP_TOO_MANY_OBJECT,'-401');
}
$index = 1;
foreach ($object_array as $key=>$value){
$object_meta = (array)$this->get_object_meta($bucket,$value);
if(isset($object_meta) &&isset($object_meta['status']) &&isset($object_meta['header']) &&isset($object_meta['header']['etag']) &&$object_meta['status'] == 200){
$xml .= '<Part>';
$xml .= '<PartNumber>'.intval($index).'</PartNumber>';
$xml .= '<PartName>'.$value.'</PartName>';
$xml .= '<ETag>'.$object_meta['header']['etag'].'</ETag>';
$xml .= '</Part>';
$index++;
}
}
}else{
throw new OSS_Exception(OSS_OBJECT_ARRAY_IS_EMPTY,'-400');
}
$xml .= '</CreateFileGroup>';
return $xml;
}
private function validate_bucket($bucket){
$pattern = '/^[a-z0-9][a-z0-9]{2,62}$/';
if (!preg_match ( $pattern,$bucket )) {
return false;
}
return true;
}
private function validate_object($object){
$pattern = '/^.{1,1023}$/';
if (empty ( $object ) ||!preg_match ( $pattern,$object )) {
return false;
}
return true;
}
private function validate_options($options){
if ($options != NULL &&!is_array ( $options )) {
throw new OSS_Exception ($options.':'.OSS_OPTIONS_MUST_BE_ARRAY);
}
}
private function validate_content($options){
if(isset($options[self::OSS_CONTENT])){
if($options[self::OSS_CONTENT] == ''||!is_string($options[self::OSS_CONTENT])){
throw new OSS_Exception(OSS_INVALID_HTTP_BODY_CONTENT,'-600');
}
}else{
throw new OSS_Exception(OSS_NOT_SET_HTTP_CONTENT,'-601');
}
}
private function validate_content_length($options){
if(isset($options[self::OSS_LENGTH]) &&is_numeric($options[self::OSS_LENGTH])){
if( !$options[self::OSS_LENGTH] >0){
throw new OSS_Exception(OSS_CONTENT_LENGTH_MUST_MORE_THAN_ZERO,'-602');
}
}else{
throw new OSS_Exception(OSS_INVALID_CONTENT_LENGTH,'-602');
}
}
private function is_empty($name,$errMsg){
if(empty($name)){
throw new OSS_Exception($errMsg);
}
}
private static function set_options_header($key,$value,&$options) {
if (isset ( $options [self::OSS_HEADERS] )) {
if (!is_array ( $options [self::OSS_HEADERS] )) {
throw new OSS_Exception(OSS_INVALID_OPTION_HEADERS,'-600');
}
}else {
$options [self::OSS_HEADERS] = array ();
}
$options [self::OSS_HEADERS] [$key] = $value;
}
}
?>