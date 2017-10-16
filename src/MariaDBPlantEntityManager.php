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
class MariaDBPlantEntityManager implements PlantEntityManagerInterface {

    private $_db;

    function __construct($host, $db, $username, $password) {
        $this->_db = new PDO("mysql:host={$host};dbname={$db}", $username, $password);
    }

    public function findPlant($serial) {
        $statement = $this->_db->prepare("select * from plant where serial = :serial LIMIT 1");
        $statement->execute(array(':serial' => $serial));
        // create object if row exists
        if ($row = $statement->fetch()) {
            $plant = new PlantEntity();
            $plant->setSerial($row['serial']);
            $plant->setCurrentHeight($row['current_height']);

            $statement = $this->_db->prepare("select * from plant_log where plant_serial = :serial");
            $statement->execute(array(':serial' => $serial));
            if ($statement->rowCount() > 0) {
                $rows = $statement->fetchAll();
                foreach ($rows as $row) {
                    $log = new GrowthLogEntity();
                    $log->setId($row['id']);
                    $log->setPlantId($row['plant_serial']);
                    $log->setHeight($row['height']);
                    $plant->addLog($log);
                }
            }
            return $plant;
        }
        return false;
    }

    public function save(PlantEntity $plant) {

        $values = [
            'serial' => $plant->getSerial(),
            'current_height' => $plant->getCurrentHeight()
        ];

        $statement = $this->_db->prepare("INSERT INTO plant(serial, current_height)
            VALUES(:serial, :current_height) ON DUPLICATE KEY UPDATE current_height = :current_height");

        if ($statement->execute($values)) {
            // get the current logs from db
            $statement = $this->_db->prepare("select id from plant_log where plant_serial = :serial");
            $statement->execute(["serial" => $plant->getSerial()]);
            $insertLogs = [];
            $savedIDs = [];
            if ($statement->rowCount() > 0) {
                $savedIDs = array_map(function ($row) {
                    return $row['id'];
                }, $statement->fetchAll());
            }

            // insert only the new logs
            /* @var $log GrowthLogEntity */
            foreach ($plant->getLogs() as $log) {
                if (!in_array($log->getId(), $savedIDs)) {
                    $insertLogs[] = $log->getPlantId();
                    $insertLogs[] = $log->getHeight();
                }
            }

            if (count($insertLogs) > 0) {

                $qPart = implode(', ', array_fill(0, count($insertLogs) / 2, "(?,?)"));

                $query = "INSERT INTO plant_log (plant_serial,height)"
                        . " VALUES " . $qPart;

                $statement = $this->_db->prepare($query);
                return $statement->execute($insertLogs);
            }
        } else {
            return false;
        }
        return true;
    }

    function __destruct() {
        $this->_db = null;
    }

}
