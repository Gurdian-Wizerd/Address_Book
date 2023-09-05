<?php
// clean the form data to prevent the injection
function validateFormData($formData){
    $formData=trim(stripcslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'),'',$formData)),ENT_QUOTES)));
    return $formData;
}
?>