<?php

function app($input,$input2){
    return "$input".$input2;
}

echo call_user_func('app',"tt","eeee");