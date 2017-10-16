<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataBase
 *
 * @author Shiman
 */
class MongoDBPlanttEntityManager implements PlantEntityManagerInterface {

    private $_manager;
    private $_database;

    function __construct($host, $database, $username, $password) {
        $this->_database = $database;
        $this->_manager = new \MongoDB\Driver\Manager(
                (!empty($username) && !empty($password)) ? "mongodb://{$username}:{$password}@{$host}:27017" : "mongodb://{$host}:27017"
        );
    }

    public function findPlant($serial) {
        $query = new MongoDB\Driver\Query(["serial" => $serial], []);
        $cursor = $this->_manager->executeQuery($this->_database . '.plant', $query);
        foreach ($cursor as $document) {
            $plant = new PlantEntity();
            $plant->setSerial($document->serial);
            $plant->setCurrentHeight($document->currentHeight);
            foreach ($document->logs as $key => $log) {
                $logEntity = new GrowthLogEntity();
                $logEntity->setHeight($log->height);
                $logEntity->setPlantId($document->serial);
                $logEntity->setId($key);
                $plant->addLog($logEntity);
            }
            return $plant;
        }
        return null;
    }

    public function save(PlantEntity $plant) {

        $query = new MongoDB\Driver\Query(["serial" => $plant->getSerial()], []);
        $cursor = $this->_manager->executeQuery($this->_database . '.plant', $query);
        $update = false;
        foreach ($cursor as $document) {
            $update = true;
        }

        $data = [
            'currentHeight' => $plant->getCurrentHeight(),
            'logs' => []
        ];

        /* @var $log GrowthLogEntity */
        foreach ($plant->getLogs() as $log) {
            $data['logs'][] = [
                'height' => $log->getHeight()
            ];
        }

        $bulk = new MongoDB\Driver\BulkWrite;

        if ($update) {
            $bulk->update(
                    ["serial" => $plant->getSerial()],
                    $data
            );
        } else {
            $date['serial'] = $plant->getSerial();
            $bulk->insert(
                    $data
            );
        }


        if ($result = $this->_manager->executeBulkWrite($this->_database . '.plant', $bulk)) {
            return true;
        }

        return false;
    }

    function __destruct() {
        $this->_db = null;
    }

}
