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
class GrowthLogEntity {
    
    private $_id;
    private $_plantId;
    private $_height;
    
    function getId() {
        return $this->_id;
    }

    function getPlantId() {
        return $this->_plantId;
    }

    function getHeight() {
        return $this->_height;
    }

    function setId($id) {
        $this->_id = $id;
        return $this;
    }

    function setPlantId($plantId) {
        $this->_plantId = $plantId;
        return $this;
    }

    function setHeight($height) {
        $this->_height = $height;
        return $this;
    }

}
