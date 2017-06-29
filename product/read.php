<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

//instantiate database and product object
$database = new Database();
$db = $database->getConnection();

//initialize object
$product = new Product($db);

//query products
$stmt = $product->readAll();
$num = $stmt->rowCount();

//check if more than 0 record is found
if($num>0){
    
    $data = "";
    $x = 1;
    
    //retreive table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extract row
        extract($row);
        
        $data .= '{';
        $data .= '"id":"' . $id . '", ';
        $data .= '"name":"' . $name . '",';
        $data .= '"description":"' . html_entity_decode($description) . '",';
        $data .= '"price":' . $price . ',';
        $data .= '"category_id":' . $category_id . ',';
        $data .= '"category_name":"' . $category_name . '"';
        $data .= '}';
        
        $data .= $x<$num ? ',' : '';
        $x++;
    }
    //json format output
    echo "[{$data}]";
}
else{
    echo '[{}]';
}

?>