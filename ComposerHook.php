<?php

namespace Codegyre\PhantomShot;

class ComposerHook {
    public static function hook() {
        if (!$path = shell_exec('which npm')) {
            die("Can't find 'npm' on your system");
        }
        echo "NPM: $path\n";
        shell_exec('cd '.escapeshellarg(__DIR__).' && ' . $path . ' update');
    }
}