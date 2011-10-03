<?php


define('IMAGE_DIR', 'images');

$chord = format($_GET['chord']);
$return = array();

$return['files'] = array();
//$return['remap'] = ['.gif'=>'','#'=>'sharp'];

if ($dh = opendir(IMAGE_DIR)) {
	while (($file = readdir($dh)) !== false) {

		if( strpos( format($file), $chord ) !== false and strpos( $file, '.gif' ) !== false ){
			array_push( $return['files'], array("image"=>IMAGE_DIR.'/'.$file,"label"=>format($file,true)) );
		}
	}
	closedir($dh);
}

if( !isAjax() ){
	echo '<pre>';
	print_r($return);
	echo '</pre>';
}else{
	echo json_encode($return);
}


function format($filename, $forLabel=false){
	
	if( strlen($filename) == 1 ){
		$filename = strtoupper($filename);
	}
	
	
	$formatted = $filename;
	$formatted = str_replace('Guitar_Chord.gif', '', $formatted );
	$formatted = str_replace('GuitarChord.gif', '', $formatted );
	
	$formatted = str_replace('major', 'maj', $formatted );
	$formatted = str_replace('minor', 'm', $formatted );
	$formatted = str_replace('#', 'sharp', $formatted );
	$formatted = str_replace('flat', 'b', $formatted );
	$formatted = str_replace(' ', '', $formatted );
	
	if($forLabel){
		$formatted = str_replace('_', '', $formatted );
		$formatted = str_replace('maj', ' Major ', $formatted );
		$formatted = str_replace('dim', ' Di*inished ', $formatted );
		
		$formatted = str_replace('m', ' Minor ', $formatted );
		$formatted = str_replace('*', 'm', $formatted );
		$formatted = str_replace('sharp', '# ', $formatted );
	}
	
	return $formatted;

}



function isAjax (){
	if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ){ 
		return true;
	}else{
		return false;
	}
}