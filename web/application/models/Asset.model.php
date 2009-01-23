<?php

/**
 * FILE ASSET class
 * @author Brian McConnell
 * @todo Implement child classes for specific asset types
 */

class Asset extends Model
{
	private $errors = array();
	private $fileElementName;
	private $uploads_dir;
	private $good_filetypes = array(".doc", ".docx",".pdf",".html",".txt",".jpeg",".jpg",".bmp",".gif",".png");

	public $assetid;
	public $userid;
	public $path;
	public $filename;
	public $filetype;
	public $width;
	public $height;
	public $length;
	private $tmppath;
	private $filesize;

	public function __construct ($element) {
		parent::__construct();
		$this->fileElementName = $element;
		$this->uploads_dir = Config::isntance()->UPLOADS;
		if($this->upload())
			return $this->save();
		else 
			return false;
	}

	public function save ($matchcolumn,$data) {
		$saved = parent::save('assetid',$this->toArray()); 
		if(stristr($this->sql,"INSERT")!==false && $saved==true)
			$this->assetid = mysql_insert_id();
		return $saved;
	}

	public static function load ($sql_extra=null) {
		self::$table = strtolower(get_class());
		return parent::load($sql_extra);
	}

	public function upload () {
		if(!empty($_FILES[$this->fileElementName]['error']))
		{
			switch($_FILES[$this->fileElementName]['error'])
			{
			case '1':
				$this->errors[] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$this->errors[] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$this->errors[] = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$this->errors[] = 'No file was uploaded.';
				break;
			case '6':
				$this->errors[] = 'Missing a temporary folder';
				break;
			case '7':
				$this->errors[] = 'Failed to write file to disk';
				break;
			case '8':
				$this->errors[] = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$this->errors[] = 'No error code avaiable';
			}
			return false;
		} elseif(empty($_FILES[$this->fileElementName]['tmp_name']) || $_FILES[$this->fileElementName]['tmp_name'] == 'none')
		{
			$this->errors[] = 'No file was uploaded.';
			return false;
		}else 
		{
			
			$this->filename = $_FILES[$this->fileElementName]['name'];
			$this->filetype = strrchr($this->filename,".");
			$this->tmppath = $_FILES[$this->fileElementName]['tmp_name'];

			if(!in_array($this->filetype,$this->good_filetypes)) {
				$this->errors[] = "Not an accpetable filetype";
				return false;				
			}
			return $this->saveFile();
		}
	}


	private function saveFile () {

		$this->path = $this->uploads_dir . "/" . gmmktime() . $this->filetype;
		$this->filesize = @filesize($this->tmppath);
		$imgsize = getimagesize($this->tmppath);
		$this->width = $imgsize[0];
		$this->height = $imgsize[1];
		$this->length = 1;
		$this->userid = $_POST['userid'];

		if(move_uploaded_file( $this->tmppath , $this->path))
			return TRUE;
		else if ( rename( $this->tmppath , $this->path ) )
			return TRUE;
		else
			return FALSE;
	}


	public function createLink($obj) {
		self::$table = "asset_links";
		$type = strtolower(get_class($obj));
		$idvar = $type . "id";
		$link = array( 'assetid'=>$this->assetid,
						'objectid'=>$obj->$type->$idvar,
						'objecttype'=>$type,
					);
		$saved = parent::save('linkid',$link);
		self::$table = strtolower(get_class());
		return $saved;
	}

}
/*
class Image extends Assets
{
	public function __construct(){
		parent::__construct();
	}

}

class Video extends Assets
{
	public function __construct(){
		parent::__construct();
	}

}

class Audio extends Assets
{
	public function __construct(){
		parent::__construct();
	}

}

class Document extends Assets
{
	public function __construct(){
		parent::__construct();
	}

}
*/

?>