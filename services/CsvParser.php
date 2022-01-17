<?php

namespace Services;


class CsvParser
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

    private function fileGetContentsChunked($file, $chunk_size, $callback)
    {
        try {
            $handle = fopen($file, "r");
            $i = 0;
            while (!feof($handle)) {
                call_user_func_array($callback, array(fread($handle, $chunk_size), &$handle, $i));
                $i++;
            }

            fclose($handle);
        } catch (Exception $e) {
            trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);
            return false;
        }

        return true;
    }

    public function parse(string $file, string $unique)
    {
        $this->file = $file;
        $this->unique = $unique;

        if (!file_exists($this->file)) {
            throw new \Exception("File not found");
        }
        if (!file_exists($this->unique)) {
            throw new \Exception("Unique combinations file not found");
        }

        $this->getPrinter()->display("Parsing file: $file");
        $this->getPrinter()->display("Unique combinations file: $unique");

        $this->getPrinter()->display("Parsing file...");

        // $fileHandle = fopen($file, "r");
        // $fileLineNumber = 1;
        // while ($rawString = fgets($fileHandle) !== false) {
        //     var_dump($rawString);
        //     $row = str_getcsv($rawString);
        //     print_r($row);
        //     var_dump($row);
        //     $this->getPrinter()->display("Line $fileLineNumber: $rawString");

        //     $fileLineNumber++;
        // }

        // fclose($fileHandle);


        //$uniqueFileHandle = fopen($unique, "r");

        $success = $this->fileGetContentsChunked($file,4096,function($chunk,&$handle,$iteration){
            /*
                * Do what you will with the {$chunk} here
                * {$handle} is passed in case you want to seek to different parts of the file
                * {$iteration} is the section of the file that has been read so
                * ($i * 4096) is your current offset within the file.
            */
            // var_dump($chunk);
            //print_r($chunk);
            $array = array_map('str_getcsv', explode("\n", $chunk));
            print_r($array);
            //$this->getPrinter()->display("Line $iteration");
            //$data = fgetcsv($handle);
            //$data = str_getcsv($chunk);
            //print_r($data);
            // print_r(count($data));
            // foreach ($data as $key => $value) {
            //     # code...
            //    // print_r($value);
            //     //$this->getPrinter()->display("$key: $value");
            // }
            print_r($iteration);
            
        
        });
        
        if(!$success)
        {
            //It Failed
        }

        $this->getPrinter()->display("Parsing file done");
    }
}
