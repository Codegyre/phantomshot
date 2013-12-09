<?php

namespace Codegyre\PhantomShot;

class ComposerHook {
    public static function hook() {
        if (!$path = shell_exec('which npm')) {
            die("Can't find 'npm' on your system");
        }
        shell_exec('cd '.escapeshellarg(__DIR__).' && ' . $path . ' update');
    }
}