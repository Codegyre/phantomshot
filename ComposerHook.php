<?php

namespace Codegyre\PhantomShot;

use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Symfony\Component\Process\ExecutableFinder;

class ComposerHook {
    public static function hook(Event $event) {
        switch ($event->getName()) {
            case ScriptEvents::POST_INSTALL_CMD:
                $command = 'install';
                break;
            case ScriptEvents::POST_UPDATE_CMD:
                $command = 'update';
                break;
            default:
                return;
        }

        $executableFinder = new ExecutableFinder;
        $npmPath = $executableFinder->find('npm');
        if ($npmPath === null) {
            throw new \RuntimeException('Unable to locate npm executable.');
        }

        exec('cd '.escapeshellarg(__DIR__).' && '.$npmPath.' '.$command, $out, $code);

        $io = $event->getIO();
        if ($code != 0) {
            throw new \RuntimeException('Error executing npm: '.$out);
        }
        $io->write($out);
    }
}