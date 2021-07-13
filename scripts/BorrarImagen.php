<?php
if (!unlink("../fotosparticipantes/".$_POST['archivo'])){ 
echo 'no'; 
}
else
{
 echo "si";
}
?>
		 
	