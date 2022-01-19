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


    /* currently unused */
    /** 
     * @name fileGetContentsChunked
     * @role procress the file and get chunked content
     * @param string $file
     * @param int $chunkSize
     * @return callback function
     * @return boolean
     *
     */
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



    /**
     * @name generateKey
     * @role procress a line and generate a key
     * @param array $row
     * @return string
     */
    private function generateKey($row)
    {
        $key = implode(",", $row);
        $key = trim($key);
        $key = strtolower($key);
        $key = preg_replace('/\s+/', '', $key);

        return $key;
    }

    /**
     * @name parseLines
     * @role parse the lines of the csv file
     * @param array $lines
     * @param array $uniqueCombinations
     * @return void
     *
     */
    private function parseLines(array $lines, &$uniqueCombinations)
    {
        foreach ($lines as $line) {
            //insert line into new node

            $this->getPrinter()->display('Procressing Row: ' . implode(",", $line));
            $key = $this->generateKey($line);
            //print_r($key);
            if (array_key_exists($key, $uniqueCombinations)) {
                $uniqueCombinations[$key]['count'] = $uniqueCombinations[$key]['count'] + 1;
            } else {

                $uniqueCombinations[$key] = $line;
                $uniqueCombinations[$key]['count'] = 1;
            }
        }
    }

    /**
     * @name parse
     * @role parse the file(csv)
     * @param string $filename
     * @param string $uniqueCombinations filename
     * @return void
     *
     */
    public function parse(string $file, string $unique)
    {
        $this->file = $file;
        $this->unique = $unique;

        if (!file_exists($this->file)) {
            throw new \Exception("File not found");
        }


        $this->getPrinter()->display("Parsing file: $file");


        $this->getPrinter()->display("Parsing file started...");

        $uniqueCombinations = array();
        $key = 'heading';
        $heading = ['brand_name', 'model_name', 'condition_name', 'grade_name', 'gb_spec_name', 'colour_name', 'network_name', 'count'];
        $uniqueCombinations[$key] = $heading;

        //batch operation to conserve memory
        $numberOfLinesToBatch = 50;
        $filehandleStream = fopen('products-big-test.csv', 'r');

        $buffer = array();
        while ($row = fgetcsv($filehandleStream)) {
            $buffer[] = $row;
            if (count($buffer) >= $numberOfLinesToBatch) {
                $this->parseLines($buffer, $uniqueCombinations);
                $buffer = array();
            }
        }
        if (!empty($buffer)) {
            $this->parseLines($buffer, $uniqueCombinations);
        }

        fclose($filehandleStream);


        $this->getPrinter()->display("Parsing file done");

        //print_r($uniqueCombinations);
        $this->getPrinter()->display("Writing output csv file.. ... ");

        $this->writeCsv($unique, $uniqueCombinations);

        $this->getPrinter()->display("Writing output csv file done");
    }


    /** 
     * @name writeCsv
     * @role write the csv file
     * @param string $filename
     * @param array $data
     * @return void
     *
     */
    private function writeCsv($file, $data)
    {

        $fileHandle = fopen($file, "w");
        foreach ($data as $key => $value) {
            //print_r($value);
            fputcsv($fileHandle, $value);
            //fputcsv($fileHandle,["\r\n"]);
        }
        fclose($fileHandle);
    }
}
