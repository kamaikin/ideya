<?php
	/**
 	 * @package other
 	 *
 	 * @author Камайкин Владимир Анатольевич <kamaikin@gmail.com>
 	 *
 	 * @version 0.1
 	 * @since since 2013-07-04
 	 */
	class TOther{
		public function file_size($size){
		    if($size >= 1073741824){
		        $fileSize = round($size/1024/1024/1024,1) . ' GB';
		    }elseif($size >= 1048576){
		        $fileSize = round($size/1024/1024,1) . ' MB';
		    }elseif($size >= 1024){
		        $fileSize = round($size/1024,1) . ' KB';
		    }else{
		        $fileSize = $size . ' bytes';
		    }
		    return $fileSize;
		}

		public function emailCheck($email){
			if(preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $email)){ 
              	return TRUE; 
           	}else{ 
              	return FALSE;    
           	} 
		}
	}