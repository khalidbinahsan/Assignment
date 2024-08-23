<?php 
class InvoiceBuilder {
    private $title;
    private $items;
    public function addTitle($title){
        $this->title = $title;
    }
    public function addItem($item, $price){
        $this->items[] = [$item, $price];
    }
    public function addTotal(){
        $total = 0;
        foreach($this->items as $item){
            $total += $item[1];
        }
        return $total;
    }
    public function dataRender(){
        $file_data = [$this->title];
        foreach($this->items as $item){
            $file_data[] = "$item[0] - $item[1]";
        }
        return $file_data;
    }
    public function createInvoice() {
        $createFile = fopen("$this->title.text", "w");
        $fileData = [...$this->dataRender(),"--------------", "Total = ".$this->addTotal()];
        foreach($fileData as $data){
            fwrite($createFile, $data.PHP_EOL);
        }
    }
}
$inv = new InvoiceBuilder();
$inv->addTitle("My First Invoice");
$inv->addItem("Item 1", 100);
$inv->addItem("Item 2", 200);
$inv->createInvoice();