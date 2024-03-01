<?php

namespace Vitruvia\Utils\System;

class Shell{
    public static function runShell(String $command):String{
	    return Shell_exec($command);
    }
}