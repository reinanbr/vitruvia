<?php

namespace Vitruvia\Utils\System;

class Shell
{
    public static function runShell(string $command): string
    {
        return shell_exec($command) ?? "";
    }
}
