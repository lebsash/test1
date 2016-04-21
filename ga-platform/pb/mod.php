<?
if(in_array('mod_rewrite', apache_get_modules())){
			echo "Enabled";
	}else{
			echo "Not enabled";
	}
?>