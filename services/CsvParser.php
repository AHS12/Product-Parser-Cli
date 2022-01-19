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

    // private function getUniqueCombinationValues($uniqueFile)
    // {
    //     $unique = [];
    //     $fileHandle = fopen($uniqueFile, "r");
    //     while ($data = fgetcsv($fileHandle)) {
    //         //print_r($data);
    //         $unique[] = $data;
    //     }

    //     fclose($fileHandle);
    //     //skipping the header
    //     return $unique[1];
    // }

    public function parse(string $file, string $unique)
    {
        $this->file = $file;
        $this->unique = $unique;

        if (!file_exists($this->file)) {
            throw new \Exception("File not found");
        }
        // if (!file_exists($this->unique)) {
        //     throw new \Exception("Unique combinations file not found");
        // }

        $this->getPrinter()->display("Parsing file: $file");
       // $this->getPrinter()->display("Unique combinations file: $unique");

        $this->getPrinter()->display("Parsing file started...");

        // $uniqueCombinations = $this->getUniqueCombinationValues($this->unique);
        //print_r($uniqueCombinations);
        $uniqueCombinations = array();
        $key = 'heading';
        $heading = ['brand_name', 'model_name', 'condition_name', 'grade_name', 'gb_spec_name', 'colour_name', 'network_name', 'count'];
        $uniqueCombinations[$key] = $heading;
        
        //$uniqueCombinations[$csvHeading] = $csvHeading;
        $uniqueCombinationCount = 0;
       // print_r($uniqueCombinations);
        $success = $this->fileGetContentsChunked($file, 4096, function ($chunk, &$handle, $iteration) use (&$uniqueCombinations, &$uniqueCombinationCount) {
            
            $array = array_map('str_getcsv', explode("\n", $chunk));
            $arrayCastedRow = (array)$array;
            foreach ($arrayCastedRow as $row) {
                $key = implode(",", $row);
                if(array_key_exists($key, $uniqueCombinations)){
                    $uniqueCombinations[$key]['count'] = $uniqueCombinations[$key]['count'] + 1;
                }else{
                    
                    $uniqueCombinations[$key] = $row;
                    $uniqueCombinations[$key]['count'] = 1;
                }
                
                // if (!in_array($key, $uniqueCombinations)) {
                //     $uniqueCombinations[$key] = $row;
                //     $uniqueCombinationCount++;
                // }

                $this->getPrinter()->display("Procressing Row: " . implode(",", $row));

                //var_dump($row);
                //print_r($row);
                //print_r($uniqueCombinations);
                //    $difference =  array_diff($uniqueCombinations, $row);
                //    print_r($difference);
                //     if (count($difference) == 0) {
                //         $uniqueCombinationCount++;
                //         $this->getPrinter()->display("Found unique combination: $uniqueCombinationCount");
                //         $this->getPrinter()->display("Unique combination: " . implode(",", $row));
                //         $this->getPrinter()->display("");
                //     }

            }
        });

        if (!$success) {
            //It Failed
            throw new \Exception("Failed to parse file");
        }

        $this->getPrinter()->display("Parsing file done");

        //print_r($uniqueCombinations);
        $this->getPrinter()->display("Writing output csv file.. ... ");

        $this->writeCsv($unique, $uniqueCombinations);

        $this->getPrinter()->display("Writing output csv file done");

        //$this->getPrinter()->display("Unique combinations found: $uniqueCombinationCount");
    }


    private function writeCsv($file, $data)
    {
        $fileHandle = fopen($file, "w");
        foreach ($data as $key => $value) {
            fputcsv($fileHandle, $value);
        }
        fclose($fileHandle);
    }
}
