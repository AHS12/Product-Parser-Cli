<?php

namespace App;


use Services\Printer;
use Services\CsvParser;
//use Services\HelpService;



class App
{
    protected $printer;
    protected $csvParser;

    public function __construct(Printer $printer = null)
    {
        $this->printer = $printer ?: new Printer();
        $this->csvParser = new CsvParser($this->printer);
    }

    /**
     * @name getPrinter
     * @role get the printer
     * @param 
     * @return Services\Printer
     *
     */
    public function getPrinter()
    {
        return $this->printer;
    }


    /**
     * @name runCommand
     * @role run the command
     * @param array $argv
     * @return void
     *
     */
    public function runCommand(array $argv = [])
    {
        
        $short_options = "f:u:h";
        $long_options = ["file:", "unique-combinations:", "help"];
        $options = getopt($short_options, $long_options);

        //print_r($options);

        //without any argumetns
        if (empty($options)) {
            $this->printer->display("Welcome to the product parser");
            $this->printer->display("Available commands:\n --help - display this help");
            $this->printer->display("Usage: php parser.php --help");
            exit;
        }

        //handle help
        if(isset($options["h"]) || isset($options["help"])) {
            $this->printer->display("Welcome to the product parser");
            $this->printer->display("Usage: php parser.php [--file=<filename>] [--unique-combinations=<filename>]");
        }

        if(isset($options["f"]) || isset($options["file"])) {
            $filename = isset($options["f"]) ? $options["f"] : $options["file"];
        }else {
            throw new \Exception("No file specified");
        }

        if(isset($options["u"]) || isset($options["unique-combinations"])) {
            $unique = isset($options["u"]) ? $options["u"] : $options["unique-combinations"];
        }
        else 
        {
            throw new \Exception("No unique combinations file specified");
        }

        //csv format parsing
        $this->csvParser->parse($filename, $unique);


    }
}
