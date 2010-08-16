<?php

/**
 * Pagination class
 * 
 * usage:
 * $list = array(18);
 * $pager = new Paginate($list,$page,10);
 * echo $pager->getNav();
 */
class Paginate 
{ 
	public $page = 1;
	public $perpage = Config::PERPAGE;
	public $objRef = null;
	public $totalItems = 0;
	public $totalPages = 1;
	public $urlTemplate = "";

	private function clamp ($val,$min,$max) {
		return max(min($val,$max),$min);
	}

	private function clean($n) {
		if(!is_numeric(trim($n)))
			return 0;
		return intval(trim($n));
	}

	private function startID () {
		return ($this->page - 1) * $this->perpage;
	}

	private function stopID () {
		return min( ($this->startID + $this->perpage) , $this->totalItems);
	}

	function getSlice ($obj) {
		return array_slice ( $obj , $this->startID() , $this->stopID() );
	}

	function __construct($_page=0,$_pagesize=0) {
		$this->page = isset($_REQUEST['p']) ? $this->clean($_REQUEST['p']) : $this->page;
		$this->perpage = isset($_REQUEST['perpage']) ? $this->clean($_REQUEST['perpage']) : $this->perpage;
	}

	public function init($obj) {
		if(is_numeric($obj))
			$this->totalItems = $obj;
		else {
			$this->objRef =& $obj;
			$this->totalItems = count($this->objRef);
		}
		$this->totalPages = ceil($this->totalItems / $this->perpage);
		$this->page = $this->clamp($this->page, 1, $this->totalPages);
		$this->perpage = $this->clamp($this->perpage,1,$this->totalItems);
	}

	public function getPage () {
		if($this->objRef!=null)
			return $this->clamp($this->page, 1, $this->totalPages);
		else
			return $this->page;
	}
	
	public function getPerPage () {
		if($this->objRef!=null)
			return $this->clamp($this->perpage, 1, $this->totalItems);
		else
			return $this->perpage;
	}
	
	function getNav () {
		$str = "";
		$i = 1;
		$term = "";
		
		$str = '<ul class="navigation pagenav">';
		if($this->totalPages>5)
			$str .= '<li><a href="'.str_replace("{#}","1",$this->urlTemplate).'"> &lt;&lt;  </a></li>';
		if($this->page>1)
			$str .= '<li><a href="'.str_replace("{#}",$i,$this->urlTemplate).'"> &lt; </a></li>';
		for($i = 1; $i <= $this->totalPages; $i++)
		{
			if ($i == $this->page)
				$str .= "<li>$term $i</li>";
			else
				$str .= '<li><a href="'.str_replace("{#}",$i,$this->urlTemplate).'">'.$term.' '.$i.'</a></li>'; 
		}
		if($this->page<$this->totalPages)
			$str .= '<li><a href="'.str_replace("{#}",($this->page+1),$this->urlTemplate).'"> &gt;  </a></li>';
		if($this->totalPages>5)
			$str .= '<li><a href="'.str_replace("{#}",$this->totalPages,$this->urlTemplate).'"> &gt;&gt; </a></li>';
		$str .= '</ul>';

		return $str;
	}

	function getSQLLimit () {
		$limit = "";
		$limit = (max($this->page-1,0)*$this->perpage);
		$limit .= ",".$this->perpage;
		return $limit;
	}

}  

?>