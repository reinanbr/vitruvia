<?php 

ob_start();
echo "amem ovo";
$res = ob_get_clean();
$new_res = explode("ovo",$res)[0];
echo $new_res;

