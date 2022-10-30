<?php	
if(filter_var($address, FILTER_VALIDATE_EMAIL)){ 
 echo "Email is valid."; 
} else { 
 echo "Not valid."; 
}
?>
