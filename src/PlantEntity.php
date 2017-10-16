<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonEntity
 *
 * @author Shiman
 */
class PlantEntity {
    
    private $_serial;
    private $_logs = [];
    private $_currentHeight = 0;
    
    function getSerial() {
        return $this->_serial;
    }

    function getCurrentHeight() {
        return $this->_currentHeight;
    }
    
    function setSerial($serial) {
        $this->_serial = $serial;
        return $this;
    }
    
    function setCurrentHeight($currentHeight) {
        $this->_currentHeight = $currentHeight;
        return $this;
    }
    
    function addLog(GrowthLogEntity $log) {
        $this->_logs[] = $log;
    }
    
    function getLogs() {
        return $this->_logs;
    }

}
