<?php

namespace Vitruvia\Core\Models;

abstract class Model{
    
    public function loadData($data){
        foreach($data as $key=>$value)
            if(property_exists($this,$key)){
                $this->{$key} = $value;
        }
    }

    abstract public function rules():array{
        
    }

    public function validate(){

    }
}