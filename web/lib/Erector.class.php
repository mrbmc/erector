<?php

class Erector {
    function Erector() {
    }
}

function obj_to_arr($obj = null)
{
	$return = array();
	$defaults = get_class_vars(get_class($obj));
	if(empty($defaults))
	{
		return $return;
	}
	foreach ($defaults as $var => $val) 
	{
		if (is_object($obj->$var)) {
			$return[$var] = obj_to_arr($obj->$var);
		} elseif (is_array($obj->$var)) {
			$return[$var] = array();
			foreach ($obj->$var as $k => $v) 
			{
				array_push($return[$var],obj_to_arr($v));
			}
		} else {
			$return[$var] = $obj->$var;
		}
	}
	return $return;
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