<?php


require_once("../domain/locales.php");
require_once("../dao/localDao.php");


class LocalBo {

    private $LocalesDao;

    public function __construct() {
        $this->LocalesDao = new LocalesDao();
    }

    public function getLocalDao() {
        return $this->LocalesDao;
    }

    public function setLocalDao(LocalesDao $LocalesDao) {
        $this->LocalesDao = $LocalesDao;
    }

    //***********************************************************
    //agrega a una persona a la base de datos
    //***********************************************************

    public function add(Locales $Local) {
        try {
            if (!$this->LocalesDao->exist($Local)) {
                $this->LocalesDao->add($Local);
            } else {
                throw new Exception("El Local ya existe en la base de datos!!");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    //***********************************************************
    //modifica a una persona a la base de datos
    //***********************************************************

    public function update(Locales $Local) {
        try {
            $this->LocalesDao->update($Local);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //***********************************************************
    //eliminar a una persona a la base de datos
    //***********************************************************

    public function delete(Locales $Local) {
        try {
            $this->LocalesDao->delete($Local);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //***********************************************************
    //consulta a una persona a la base de datos
    //***********************************************************

    public function searchById(Locales $Local) {
        try {
            return $this->LocalesDao->searchById($Local);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //***********************************************************
    //consultar todas las personas de la base de datos
    //***********************************************************

    public function getAll() {
        try {
            return $this->LocalesDao->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }

}

//end of the class LocalBo
?>