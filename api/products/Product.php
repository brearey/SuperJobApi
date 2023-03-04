<?php
namespace products;
class Product
{
    public $id;
    public $name;
    public $image = 'https://icon-library.com/images/product-icon/product-icon-3.jpg';
    public $price;
    public function __construct($id, $name, $image, $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
    }
}