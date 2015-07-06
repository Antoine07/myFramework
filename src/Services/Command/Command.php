<?php
namespace Services;

class Command {


    public function __construct(array $argv = null)
    {
        if (null === $argv) {
            $argv = $_SERVER['argv'];
        }
        // strip the application name
        array_shift($argv);
        $this->tokens = $argv;

    }

}