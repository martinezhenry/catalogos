<?php


require_once ('../../controllers/ctFlyer.php');
require_once ('../../models/ProductFlyer.php');



$flyer = new Flyer();

for ($i=0; $i < 5 ; $i++){

	$product = new ProductFlyer();
	$products[$i] = $product;
}


$flyer->setProducts($products);

create($flyer);