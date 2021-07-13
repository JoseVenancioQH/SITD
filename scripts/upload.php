<?php

error_reporting(E_ALL); 

// we first include the upload class, as we will need it here to deal with the uploaded file
include('clases/class.upload.php');

// we have three forms on the test page, so we redirect accordingly
if (!array_key_exists('action', $_POST) || $_POST['action'] == 'simple') {

} else if ($_POST['action'] == 'image') {

    // ---------- IMAGE UPLOAD ----------
    
    // we create an instance of the class, giving as argument the PHP object 
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new Upload($_FILES['userfile'], 'es_ES');
 
    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {		
	    
		$dir="../fotosparticipantes/";
		if (!file_exists($dir)){@mkdir($dir, 0777);}
		
		$dir="../fotosparticipantestemp/";
		if (!file_exists($dir)){@mkdir($dir, 0777);}
		
		/*$dir_evento="../fotosparticipantesevento/".$_POST['evento'];
		if (!file_exists($dir_evento)){@mkdir($dir_evento, 0777);}
		
		$dir_evento_thumb="../fotosparticipanteseventothumb/".$_POST['evento'];
		if (!file_exists($dir_evento_thumb)){@mkdir($dir_evento_thumb, 0777);}*/
		
		$dir_participante="../fotosparticipantestemp/";
		if (!file_exists($dir_participante)){@mkdir($dir_participante, 0777);}
		
		$dir_participante_thumb="../fotosparticipantes/";
		if (!file_exists($dir_participante_thumb)){@mkdir($dir_participante_thumb, 0777);}
		
		$img_x = $handle->image_src_x;
		$img_y = $handle->image_src_y;
       
        // yes, the file is on the server
        // below are some example settings which can be used if the uploaded file is an image.
		if($_POST['overwrite']=='si')
		{$handle->file_overwrite = true;
		 $handle->file_auto_rename = false;}
		else
		{$handle->file_overwrite = false;
		 $handle->file_auto_rename = true;}			
		 
		if($img_y>90){
		 $handle->image_resize                   = true;     
		 $handle->image_ratio_x                  = true;		 		 		 		 
		 $handle->image_y                        = 90;	
	    } 
         
		 $handle->file_new_name_body             = $_POST['curp'];
		 $handle->image_convert                  = 'png';   		 

        // now, we start the upload 'process'. That is, to copy the uploaded file
        // from its temporary location to the wanted location
        // It could be something like $handle->Process('/home/www/my_uploads/');
        $handle->Process($dir_participante_thumb."/");
        
		$name_img_thumb = $handle->file_dst_name_body;
		
        // we check if everything went OK
        if ($handle->processed) {			
		    
			if($_POST['overwrite']=='si')
			{$handle->file_overwrite = true;
			 $handle->file_auto_rename = false;}
			else
			{$handle->file_overwrite = false;
			 $handle->file_auto_rename = true;}
			
			if($img_x>=600){
			 $handle->image_resize                   = true;     
			 $handle->image_ratio_y                  = true;		 		 		 		 
			 $handle->image_x                        = 600;	
			}			
			
		    $handle->file_new_name_body                = $_POST['curp'];
		    $handle->image_convert                     = 'png';
			$handle->Process($dir_participante."/");
			
			$name_img = $handle->file_dst_name_body;	   		
			
        } else {
            // one error occured  
		    echo $handle->error;           
        }		
		echo $name_img.".png";		
		$handle-> Clean();
    } else {
        echo '0';
    }

} else if ($_POST['action'] == 'multiple') {
    
} else if ($_POST['action'] == 'local') {
	
}


//echo '<p><a href="index.html">do another test</a></p>';
//
//echo '<pre>';
//echo($handle->log);
//echo '</pre>';

?>