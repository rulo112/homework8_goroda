<?php
require_once 'db.php';

$regionId = intval($_GET['region_id']); 
$result = $conn->query("SELECT id, name FROM cities WHERE region_id = $regionId");

$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row; 
}

echo json_encode($cities); 
?>
