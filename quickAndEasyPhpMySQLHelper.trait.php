<?php
defined('DBHOST') or define("DBHOST", "localhost");
defined('DBPORT') or define("DBPORT", 3306);
defined('DBNAME') or define("DBNAME", "DBNAME");
defined('DBUSER') or define("DBUSER", "DBUSER");
defined('DBPASS') or define("DBPASS", "DBPASS");
defined('DBCHARSET') or define("DBCHARSET", "utf8mb4");

trait getData{
        public static function runQuery(string $sql, array $paramData, string $queryType = "SELECT", ?array $sqlSettings = null){
                if(!empty($sqlSettings) and isset($sqlSettings["dbHost"]) and isset($sqlSettings["dbPort"]) and isset($sqlSettings["dbName"]) and isset($sqlSettings["dbUser"]) and >
                    $dbHost = $sqlSettings["dbHost"];
                    $dbPort = $sqlSettings["dbPort"];
                    $dbName = $sqlSettings["dbName"];
                    $dbUser = $sqlSettings["dbUser"];
                    $dbPass = $sqlSettings["dbPass"];
                    $dbCharset = $sqlSettings["dbCharset"];
                }else{
                    $dbHost = DBHOST;
                    $dbPort = DBPORT;
                    $dbName = DBNAME;
                    $dbUser = DBUSER;
                    $dbPass = DBPASS;
                    $dbCharset = DBCHARSET;
                }
                try{
                    $databaseHandle = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=$dbCharset", $dbUser, $dbPass);
                    $databaseHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                    $databaseHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $databaseHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    $databaseHandle->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, true);
                    $result = null;
                    
                    if($queryType === "SELECT"){
                        $statement = $databaseHandle->prepare($sql);
                        foreach($paramData as $data){
                                //var_dump($data);
                                if (is_integer($data['data'])){
                                        #echo("int");
                                        #echo($data['id']);
                                        #echo($data['data']);
                                        #var_dump($data);
                                        $statement->bindValue($data['id'], $data['data'], PDO::PARAM_INT);
                                }else{
                                        #echo("string");
                                        #echo($data['id']);
                                        #echo($data['data']);
                                        #var_dump($data);
                                        $statement->bindValue($data['id'], $data['data'], PDO::PARAM_STR);
                                        
                                }
                        }
                        
                        $status = $statement->execute();
                        $result = $databaseHandle->lastInsertId();
                    }elseif($queryType === "DELETE"){
                        
                    }
                    //var_dump($result);
                    return $result;
                }catch(Exception $e){
                        
                        var_dump($e);
                        return null;
                }
                
        }       
        public static function getMySQLDateTime(?DateTime $dateTime = null){
                if(is_null($dateTime)){
                        $dateTime = new DateTime();
                        return $dateTime->format('Y-m-d H:i:s');
                }else{
                    return $dateTime->format('Y-m-d H:i:s');
                }
        }
        public static function getDateTimeObjectFromMySQL(string $datetime){
                if(!is_null($datetime)){
                        return DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
                }
        }
        public function getNiceUKDateTime(?DateTime $dateTime = null){
                if(is_null($dateTime)){
                        $dateTime = new DateTime();
                        return $dateTime->format('d/m/Y H:i:s');
                }else{
                    return $dateTime->format('d/m/Y H:i:s');
                }
        }
        
}

