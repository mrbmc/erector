<?php

/*

$cache = Cache::instance("memcache");
$events = $cache->get("SELECT * FROM events");

*/
class Cache 
{
	public $type = "memcache";
	public $directory = "/home/sites/rhythmism/cache";
	public $lifetime = 300;//in seconds
	private $request;
	private $memcache = false;
	private $servername = 'localhost';
	private $serverport = 11211;
	private static $_instance;

	private function __construct($_type) 
	{
		global $vbulletin;

		if($_type)
			$this->type = $_type;

		if($this->type=="memcache" && class_exists("Memcache")) {
			$this->memcache = new Memcache;
			if(!$this->memcache->connect($this->servername, $this->serverport)) {
				trace("could not connect to memcache daemon");
				$this->memcache = false;
			}
		} elseif ($this->type=="file") {
			if(!is_writable($this->directory))
				trace("could not write to cache directory");
		}
	}

	public static function instance ($_type="memcache") {
		if (!isset(self::$_instance)) {
			$_classname = __CLASS__;
			self::$_instance = new $_classname($_type);
		}
		return self::$_instance;
	}

	private function key($request) {
		global $vbulletin;
		if($vbulletin->config['staging'])
			$key = "stg_";
		$key .= is_array($request) ? serialize($request) : $request;
		return md5($key);
	}

	private function load ($request) {
		global $db,$vbulletin;
		$return = array();

		// SQL requests
		if(stristr($request,"SELECT")) {
			$results = $db->query($request);
			while ($row = $db->fetch_array($results))
			{
				array_push($return,$row);
			}
		// RPC requests
		} else {
			//$results = file_get_contents($request);
			$results = $this->getRemoteFile($request);
			$return = (is_array(unserialize($results))) ? unserialize($results) : $results;
		}
		unset($results);
		return $return;
	}

	public function get ($request) {
		global $vbulletin;
		$action = "get_cache_" . $this->type;
		return $this->$action($request);
	}

	public function set ($request,$response,$lifetime=300) {
		$action = "set_cache_" . $this->type;
		if($lifetime>0)
			$this->lifetime = $lifetime;
		return $this->$action($request,$response);
	}

	private function get_cache_file ($request)
	{
		$key = $this->key($request);
		$file = $this->directory . '/' . $key . '.cache';
		if (file_exists($file)) {
			if( (mktime() - filemtime($file)) < $this->lifetime ) {
				return unserialize(file_get_contents($file));
			}
		}
		$cache = $this->load($request);
		$this->set($key,$cache);
		return $cache;
	}

	private function set_cache_file ($key, $response)
	{
		$file = $this->directory . "/" . $key . ".cache";
		$fstream = fopen($file, "w");
		$result = fwrite($fstream,serialize($response));
		fclose($fstream);
		return $result;
	}

	private function get_cache_memcache ($request) {
		global $db,$vbulletin;

		$key = $this->key($request);
		$cached = false;
		$cache = array();

		if($this->memcache) 
			$cached = ($cache = $this->memcache->get($key));

		if(!$cached) {
			trace('uncached:'.$request);
			$cache = $this->load($request);
			if($this->memcache)
				$this->set($key,$cache);
		} else {
			trace('cached:'.$request);
		}
		return $cache;
	}

	private function set_cache_memcache ($key,$data) {
		if(!$this->memcache)
			return false;
		return $this->memcache->set($key,$data,0,$this->lifetime);
	}

	public function getRemoteFile($url){
		$url_parsed = parse_url($url);
		$scheme = $url_parsed["scheme"];
		$host = $url_parsed["host"];
		$port = $url_parsed["port"]?$url_parsed["port"]:"80";
		$user = $url_parsed["user"];
		$pass = $url_parsed["pass"];
		$path = $url_parsed["path"]?$url_parsed["path"]:"/";
		$query = $url_parsed["query"];
		$anchor = $url_parsed["fragment"];
		if (!empty($host)){
			// attempt to open the socket
			if($fp = fsockopen($host, $port, $errno, $errstr, 2)){
				$path .= $query?"?$query":"";
				$path .= $anchor?"$anchor":"";
				// this is the request we send to the host
				$out = "GET $path ".
					"HTTP/1.0\r\n".
					"Host: $host\r\n".
					"Connection: Close\r\n".
					"User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n";
				if($user)
					$out .= "Authorization: Basic ".
						base64_encode("$user:$pass")."\r\n";
				$out .= "\r\n";

				fputs($fp, $out);
				while (!feof($fp)) {
					$return.=fgets($fp, 128);
				}
				fclose($fp);
			} else {
				$error = "Failed to make connection to host.";//$errstr;
			}
			$headers = $this->parseHeaders(trim(substr($return,0,strpos($return,"\r\n\r\n"))));
		}

		if($return){
			if(is_array($headers)){
				$h = array_change_key_case($headers, CASE_LOWER);
				if($error) // failed to connect with host
					$buffer="Fail: ".trace($s->error);
				elseif(preg_match("/404/",$h['status'])) // page not found
					$buffer="Fail: ".trace("Page Not Found");
				else
					$buffer = $return;
			} else {
				$buffer="Fail: ".trace("An unknown error occurred.");
			}
		}else{
			$buffer="Fail: ".trace("An unknown error occurred.");
		}
		return $buffer;
	}

	private function parseHeaders($s){
		$h=preg_split("/[\r\n]/",$s);
		foreach($h as $i){
			$i=trim($i);
			if(strstr($i,":")){
				list($k,$v)=explode(":",$i);
				$hdr[$k]=substr(stristr($i,":"),2);
			}else{
				if(strlen($i)>3)
					$hdr[]=$i;
			}
		}
		if(isset($hdr[0])){
			$hdr['Status']=$hdr[0];
			unset($hdr[0]);
		}
		return $hdr;
	}

}




?>
