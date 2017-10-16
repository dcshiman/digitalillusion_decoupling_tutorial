<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usecase
 *
 * @author Shiman
 */
class ObservingPlantsUsecase {
    
    private $_em;
    
    function __construct(PlantEntityManagerInterface $em) {
        $this->_em = $em;
    }
    
    /**
     * 
     * Monitors the plant and enters the log
     * 
     * @param String $plantSerial
     * @param int $height
     * @return int Height the plant grew from the last log
     */
    function plantMonitored($plantSerial, $height) {
        if (!$plant = $this->em()->findPlant($plantSerial)) {
            $plant = new PlantEntity();
            $plant->setSerial($plantSerial);
        }
        
        $log = new GrowthLogEntity();
        $log->setPlantId($plant->getSerial());
        $log->setHeight($height);
        
        $model = new PlantGrowModel();
        
        // Calculate the height grown
        $growthHeight = $model->calclulateGrowth($plant, $log);
        
        // Grow the plant
        $model->growPlant($plant, $log);
        $model->growPlant($plant, $log);
        
        if (!$this->em()->save($plant)) {
            throw new Exception("Could Not Save To Database");
        }
        
        return $growthHeight;
    }
    
    /**
     * 
     * @return PlantEntityManagerInterface
     */
    private function em() {
        return $this->_em;
    }
}
