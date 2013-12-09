<?php

namespace Codegyre\PhantomShot;

use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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

        $processBuilder = new ProcessBuilder(array(
            $npmPath,
            $command,
        ));
        $processBuilder->setWorkingDirectory(__DIR__);
        $npmProcess = $processBuilder->getProcess();

        $io = $event->getIO();

        $npmProcess->run(function ($type, $buffer) use ($io) {
            if (Process::ERR === $type) {
                throw new \RuntimeException($buffer);
            } else {
                $io->write($buffer, false);
            }
        });
   }

}