<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonModel
 *
 * @author Shiman
 */
class PlantGrowModel {
    
    /**
     * 
     * @param PlantEntity $plant
     * @param GrowthLogEntity $log
     * @return int new height
     */
    function calclulateGrowth(PlantEntity $plant, GrowthLogEntity $log) {
        $currentHeight = $plant->getCurrentHeight();
        $newHeight = $log->getHeight();
        return ($newHeight - $currentHeight);
    }
    
    /**
     * 
     * @param PlantEntity $plant
     * @param GrowthLogEntity $log
     * @return \PlantEntity
     */
    function growPlant(PlantEntity $plant, GrowthLogEntity $log) {
        $currentHeight = $plant->getCurrentHeight();
        $newHeight = $log->getHeight();
        $plant->setCurrentHeight($newHeight);
        $plant->addLog($log);
        return $plant;
    }
    
}
