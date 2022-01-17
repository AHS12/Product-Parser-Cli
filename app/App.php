<?php

namespace App;


use App\Printer;



class App
{
    protected $printer;

    public function __construct(Printer $printer = null)
    {
        $this->printer = $printer ?: new Printer();
    }
    // public function __construct(Printer $printer)
    // {
    //     $this->printer = $printer;
    // }

    public function getPrinter()
    {
        return $this->printer;
    }


    public function registerCommand($name, $callable)
    {
        $this->registry[$name] = $callable;
    }

    public function getCommand($command)
    {
        return isset($this->registry[$command]) ? $this->registry[$command] : null;
    }

    public function runCommand(array $argv = [])
    {
        $command = "--help";

        // if (isset($argv[1])) {
        //     $command_name = $argv[1];
        // }

        // $command = $this->getCommand($command_name);
        // if ($command === null) {
        //     $this->printer->display("ERROR: Command \"$command_name\" not found.");
        //     $this->printer->display("Use Command \"help\" to see all available commands.");
        //     exit;
        // }

        //call_user_func($command, $argv);
        print_r($argv);

        $short_options = "f:u:h";
        $long_options = ["filename:", "unique:", "help"];
        $options = getopt($short_options, $long_options);

        print_r($options);

        if(isset($options["f"]) || isset($options["filename"])) {
            $filename = isset($options["f"]) ? $options["f"] : $options["filename"];
        }

        if(isset($options["u"]) || isset($options["unique"])) {
            $unique = isset($options["u"]) ? $options["u"] : $options["unique"];
        }

        if(isset($options["h"]) || isset($options["help"])) {
            $this->printer->display("Hello Welcome to the basic cli app");
        }

        // print_r($filename);
        // print_r($unique);


    }
}
