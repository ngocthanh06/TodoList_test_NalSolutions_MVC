<?php
    class Database 
    {
        private $dbHost = DB_HOST;
        private $dbUser = DB_USER;
        private $dbPass = DB_PASS;
        private $dbName = DB_NAME;

        private $statement;
        private $dbHandler;
        private $error;

        public function __construct() 
        {
            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try {
                $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        //Allows us to write queries
        public function query($sql) 
        {
            $this->statement = $this->dbHandler->prepare($sql);
        }

        //Bind values
        public function bind($parameter, $value, $type = null) 
        {
            switch (is_null($type)) {
                case is_int($value):
                    $type = PDO::PARAM_INT;

                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;

                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;

                    break;
                default:
                    $type = PDO::PARAM_STR;
            }

            $this->statement->bindValue($parameter, $value, $type);
        }

        //Execute the prepared statement
        public function execute() 
        {
            return $this->statement->execute();
        }

        //Return an array
        public function resultSet() 
        {
            $this->execute();

            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }

        //Return a specific row as an object
        public function single() 
        {
            $this->execute();

            return $this->statement->fetch(PDO::FETCH_OBJ);
        }

        //Get's the row count
        public function rowCount() 
        {
            return $this->statement->rowCount();
        }

        public function insert($table, array $data)
        {
            //code
            $sql = "INSERT INTO {$table} ";
            $columns = implode(',', array_keys($data));
            $values  = "";
            $sql .= '(' . $columns . ')';

            foreach ($data as $field => $value) {
                if (is_string($value)) {
                    $values .= "'". $value ."',";
                } else {
                    $values .= $value . ',';
                }
            }

            $values = substr($values, 0, -1);
            $sql .= " VALUES (" . $values . ')';

            $this->query($sql);
        }

        public function update($table, array $data, array $conditions)
        {
            $sql = "UPDATE {$table}";

            $set = " SET ";

            $where = " WHERE ";

            foreach ($data as $field => $value) {
                if (is_string($value)) {
                    $set .= $field .'='.'\''. $value .'\',';
                } else {
                    $set .= $field .'='. $value . ',';
                }
            }

            $set = substr($set, 0, -1);

            foreach ($conditions as $field => $value) {
                if (is_string($value)) {
                    $where .= $field .'='.'\''. $value .'\' AND ';
                } else {
                    $where .= $field .'='. $value . ' AND ';
                }
            }

            $where = substr($where, 0, -5);

            $sql .= $set . $where;

            $this->query($sql);
        }

        public function delete ($table ,  $id, $col = null )
        {
            if (!isset($col)) {
                $sql = "DELETE FROM {$table} WHERE id = $id ";
            } else {
                $sql = "DELETE FROM {$table} WHERE $col = $id ";
            }            
            
            $this->query($sql);
        }
    }
