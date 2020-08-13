<?php
class database
{
    private $dsn="mysql:dbname=db_user;host=localhost";
    private $username="root";
    private $pass="";
    public $pdo;
    public function __construct()
    {
        if(!isset($this->pdo))
        {
            try
            {
                $link=new PDO($this->dsn,$this->username,$this->pass);
                $link->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $this->pdo=$link;
            }
            catch(PDOExecption $e)
            {
                die("fail to connect.".$e->getMessage());            }
        }
        
    }
}



?>
