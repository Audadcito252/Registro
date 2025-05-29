<?php
class Usuario {
    public $nombre;
    public $email;
    public $password;
    public function __construct($nombre, $email, $password) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }
}
