<?php

class Paginate 
{ 
	var $page = 1;
	private $perpage = 10;
	private $count = 0;
	private $totalpages = 0;

	var $urlTemplate = "";

	function __construct($obj,$_page=1,$_per=10) {
		$this->count = count($obj);
		$this->perpage = $_per;
		$this->page = $this->clamp($_page, 1, $this->totalPages());
	}

	private function clamp ($val,$min,$max) {
		return max(min($val,$max),$min);
	}

	private function totalPages () {
		return ceil($this->count / $this->perpage);
	}
	
	private function startID () {
		return ($this->page - 1) * $this->perpage;
	}

	private function stopID () {
		return min( ($this->startID + $this->perpage) , $this->count);
	}

	function getNav () {
		$str = "";
		$i = 1;
		$spacer = " &nbsp; | &nbsp; ";

        $str .= '<a href="'.str_replace("{#}","1",$this->urlTemplate).'"> &lt;&lt;  </a>';
        $str .= $spacer; 
        $str .= '<a href="'.str_replace("{#}",$i,$this->urlTemplate).'"> &lt; </a>';
        $str .= $spacer; 

	    for($i = 1; $i <= $this->totalPages(); $i++)
	    {
	        if ($i == $this->page)
	            $str .= "Page $i";
	        else
	            $str .= '<a href="'.str_replace("{#}",$i,$this->urlTemplate).'">Page '.$i.'</a>'; 
	        $str .= $spacer; 
	    }
        $str .= '<a href="'.str_replace("{#}",($this->page+1),$this->urlTemplate).'"> &gt;  </a>';
        $str .= $spacer; 
        $str .= '<a href="'.str_replace("{#}",$this->totalPages(),$this->urlTemplate).'"> &gt;&gt; </a>';

	    return $str;
	}

	function getSlice ($obj) {
		return array_slice ( $obj , $this->startID() , $this->stopID() );
	}

}  

?>