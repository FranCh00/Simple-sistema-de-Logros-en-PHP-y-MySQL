<?php
class Logro {
    private $id;
    private $nombre;
    private $descripcion;
    private $tarea;
    private $creditos;
    private $imagen;

    public function __construct($id, $nombre, $descripcion, $tarea, $creditos, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->tarea = $tarea;
        $this->creditos = $creditos;
        $this->imagen = $imagen;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getTarea() {
        return $this->tarea;
    }

    public function getCreditos() {
        return $this->creditos;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setTarea($tarea) {
        $this->tarea = $tarea;
    }

    public function setCreditos($creditos) {
        $this->creditos = $creditos;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }
}
