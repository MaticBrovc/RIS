<?php 

class DBInit {

    private static $host = "remotemysql.com";
    private static $user = "jSMN5gWYsq";
    private static $password = "NqmxhOWzGy";
    private static $schema = "jSMN5gWYsq";
    private static $instance = null;
    
    private function __construct() {
        
    }

    private function __clone() {
        
    }

    /**
     * Returns a PDO instance -- a connection to the database.
     * The singleton instance assures that there is only one connection active
     * at once (within the scope of one HTTP request)
     * 
     * @return PDO instance 
     */
    public static function getInstance() {
        self::$instance = null;
        $limit = 10;
        $counter = 0;
        if (!self::$instance) {
            while(true){
                try{
                    $config = "mysql:host=" . self::$host
                    . ";dbname=" . self::$schema;
                    $options = array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    );

                    self::$instance = new PDO($config, self::$user, self::$password, $options);
                    break;
                }
                catch (Exception $e) {
                self::$instance = null;
                $counter++;
                if ($counter == $limit)
                    throw $e;
    }
                
            }
            
        }

        return self::$instance;
    }

}