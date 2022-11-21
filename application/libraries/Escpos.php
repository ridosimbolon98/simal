<?php

require './vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Escpos {
  function print($items,$shop){
    date_default_timezone_set("Asia/Jakarta"); 
    /* Fill in your own connector here */
    $connector = new WindowsPrintConnector("pos_printer");

    /* Date is kept the same for testing */
    $date = date('d-m-Y h:i:s A');
  
    /* Start the printer */
    // $logo = EscposImage::load("resources/escpos-php.png", false);
    $printer = new Printer($connector);

    /* Name of shop */
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    $printer -> text($shop."\n");
    $printer -> selectPrintMode();
    $printer -> text("JL. Melati No. 42.\n");
    $printer -> feed();
  
    /* Title of receipt */
    $printer -> setEmphasis(true);
    $printer -> text("BUKTI PEMBAYARAN\n");
    $printer -> text("===============================\n");
    $printer -> setEmphasis(false);
  
    /* Items */
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> setEmphasis(false);
    
    $printer -> text($items[0]['item']);
    $printer -> text("             "); //15
    $printer -> text(':'.$items[0]['value']."\n");
    $printer -> text($items[1]['item']);
    $printer -> text("     "); //7
    $printer -> text(':'.$items[1]['value']."\n");
    $printer -> text($items[2]['item']);
    $printer -> text("           "); //13
    $printer -> text(':'.$items[2]['value']."\n");
    $printer -> text($items[3]['item']);
    $printer -> text("          "); //12
    $printer -> text(':'.$items[3]['value']."\n");
    $printer -> text($items[4]['item']);
    $printer -> text("       "); //9
    $printer -> text(':'.$items[4]['value']."\n");
    $printer -> text($items[5]['item']);
    $printer -> text("   "); //5
    $printer -> text(':'.$items[5]['value']."\n");
    $printer -> text($items[6]['item']);
    $printer -> text(" "); //3
    $printer -> text(':'.$items[6]['value']."\n");
  
    /* Footer */
    $printer -> feed(2);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("Terima kasih.\n");
    $printer -> feed(2);
    $printer -> text($date . "\n");
  
    /* Cut the receipt and open the cash drawer */
    $printer -> cut();
    $printer -> pulse();
  
    $printer -> close();
  }
}

class item
{
    private $item;
    private $value;
    private $sign;

    public function __construct($item = '', $value = '', $sign = false)
    {
        $this -> item = $item;
        $this -> value = $value;
        $this -> sign = $sign;
    }
    
    public function __toString()
    {
        $rightCols = 14;
        $leftCols = 34;
        if ($this -> sign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> item, $leftCols) ;
        
        $signs = ($this -> sign ? ': ' : '');
        $right = str_pad($signs . $this -> value, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}


