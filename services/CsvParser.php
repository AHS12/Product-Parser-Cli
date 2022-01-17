<?php

namespace Services;


Class CsvParser
{
    protected $file;
    protected $unique;
    protected $printer;

    public function __construct(Printer $printer = null)
    {
        $this->printer = $printer ?: new Printer();
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function parse(string $file, string $unique)
    {
        $this->file = $file;
        $this->unique = $unique;

        if(!file_exists($this->file)) {
            throw new \Exception("File not found");
        }
        if(!file_exists($this->unique)) {
            throw new \Exception("Unique combinations file not found");
        }

        $this->getPrinter()->display("Parsing file: $file");
        $this->getPrinter()->display("Unique combinations file: $unique");

        $this->getPrinter()->display("Parsing file...");
        
        $fileHandle = fopen($file, "r");
        $fileLineNumber = 1;
        while($rawString = fgets($fileHandle) !== false) {
            $row = str_getcsv($rawString);
            $this->getPrinter()->display("Line $fileLineNumber: $rawString");
            print_r($row);
            $fileLineNumber++;
        }

        fclose($fileHandle);

        $uniqueFileHandle = fopen($unique, "r");

        $this->getPrinter()->display("Parsing file done");
    }
}