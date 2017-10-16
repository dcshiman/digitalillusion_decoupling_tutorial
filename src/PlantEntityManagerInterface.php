<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Shiman
 */
interface PlantEntityManagerInterface {
    
    /**
     * Finds a plant from the database
     * 
     * @param String $serial
     * @return PlantEntity 
     */
    function findPlant($serial);
    
    /**
     * Save a plant entity to the database
     * 
     * @param PlantEntity $plant
     * @return boolean true if saved
     */
    function save(PlantEntity $plant);
    
    
}
