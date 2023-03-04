<?php
require_once 'Product.php';
use products\Product;
header("Content-type: application/json; charset=utf-8");
//header("Content-type: text/html; charset=utf-8");

$image_uri = 'https://icon-library.com/images/product-icon/product-icon-3.jpg';

if ($_SERVER["HTTP_APPKEY"] == 1234) {
    echo json_encode(
        array(
            new Product(1, "Product1", $image_uri, 1200),
            new Product(2, "Product2", $image_uri, 1500),
            new Product(3, "Product3", $image_uri, 1400),
            new Product(4, "Product4", $image_uri, 1000000),
        )
    );
}
else {
    http_response_code(401);
}