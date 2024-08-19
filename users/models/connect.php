<?php
class ConexionBDD {

private $strhost = "localhost";         
private $strUser = "root";
private $strPass = "";
private $strDataBase = "kiipay";
private $connect;

function __construct(){
    $strConexion = "mysql:host=".$this-> strhost .";dbname=".$this-> strDataBase.";charset=utf8";
    try {
        $this->connect = new PDO($strConexion, $this->strUser, $this->strPass); 
        $this->connect ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    } catch (exception $e) {
        $this->connect = 'Fallo la conexion: ' . $e->getMessage();
        echo $this->connect;
    }
    
    
}
public function connect(){
    return $this->connect;
}



}

?>