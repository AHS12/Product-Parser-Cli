<?php

namespace Services;



class Printer
{

    public function out($message)
    {
        echo $message;
    }

    public function newline()
    {
        $this->out("\n");
    }


    /**
     * @name display
     * @role display a message in the console
     * @param string $message
     * @return void
     *
     */
    public function display($message)
    {
        $this->newline();
        $this->out($message);
        //$this->newline();
        $this->newline();
    }
}