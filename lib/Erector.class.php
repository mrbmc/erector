<?php

class Erector {
    function Erector() {
    }
}

function object_to_array($o){
	$defaults = get_class_vars(get_class($o));
	if(empty($defaults)) {
		return (array)$o;
	}
	foreach($o as $k=>$v) 
	{
		if(is_object($v)) {
			$o->$k = object_to_array($v);
		}
	}
	return (array)$o;
}


function obj_to_arr($obj = null)
{
	return object_to_array($obj);
}

function arr_to_obj($array = array()) {
    if (!empty($array)) {
        $data = false;
        foreach ($array as $akey => $aval) {
            $data -> {$akey} = $aval;
        }
        return $data;
    }
    return false;
}


?>