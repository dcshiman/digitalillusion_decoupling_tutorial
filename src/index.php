<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require __DIR__ . "\ObservingPlantsUsecase.php";
require __DIR__ . "\PlantEntityManagerInterface.php";
require __DIR__ . "\PlantEntity.php";
require __DIR__ . "\PlantGrowModel.php";
require __DIR__ . "\GrowthLogEntity.php";

// infrastructure
require __DIR__ . "\MariaDBPlantEntityManager.php";
require __DIR__ . "\MongoDBPlanttEntityManager.php";

$em1 = new MariaDBPlantEntityManager('localhost','digitalillusion_decouple','root','');
$em2 = new MongoDbPlanttEntityManager('localhost','digitalillusion_decoupling','','');
$obersvingPlants = new ObservingPlantsUsecase($em2);
$serial = "10001";
$growthIncresed = $obersvingPlants->plantMonitored($serial, 10);

echo sprintf("Plant #%s grew %d", $serial, $growthIncresed);