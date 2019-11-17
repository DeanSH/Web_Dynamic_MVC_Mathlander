<?php
    require_once("Model//QueryModel.php");
    // Database connection class reusable by models
    class DBconnection {
        private $rs; // Procedural "handle" or "resource" to database
        private $connectRs;
        private $fetchResult;
        private $DBi;
        public $sql;
        
        // function to execute connecting to the DB
        public function DBConnection()
        {
            $this->connectDb("mathlander","localhost","root","Ch1Ck3n");  
        }
        
        // private query called when the public function for database connection is executed, this does the actual connection work
        private function connectDb($prDatabase,$prHost,$prUser,$prPass)
        {
            $this->connectRs = mysqli_connect($prHost,$prUser,$prPass);
            if(!$this->connectRs)
            {
                echo "Error connecting to the database server".mysqli_error($this->connectRs);
                $this->connectRs = -1;
            }
            else
            {
                //connected check if DB exists and select it for use
                $dbRs = mysqli_select_db($this->connectRs,$prDatabase);
                if(! $dbRs)
                {
                    echo "Error selecting the database".mysqli_error($this->connectRs);   
                }
                else
                {
                    //all connecxt to DB so instantiate the DB queries model
                    $this->sql = new QueryModel();
                    $this->sql->dbRs = $this->connectRs;
                }
            }
        }
        
        // function to send a query to the database
        public function query($pStrSQL)
        {
            $this->rs = -1;// DEFAULT -1 MEANS BAD RECORDSET
            $this->rs = mysqli_query($this->connectRs,$pStrSQL);
            if( !$this->rs)
            {
                echo "Error running query [$pStrSQL] ".mysqil_error($this->connectRs)."<br>";
                $this->rs = -1;
            }
        }
        
        
        // Used to fetch the next row on a currect dataset after select queries
        public function next(){
            $aRow = mysqli_fetch_array($this->rs);
            return $aRow;
        }
        
        // Can be used to check number of rows returned from a seelct query
        public function num_rows(){
            $aNumRows = $this->rs->num_rows;
            return $aNumRows;
        }
        
        // Can be used to check affected rows after queries
        public function affected_rows(){
            $aAffectedRows = $this->rs->affected_rows;
            return $aAffectedRows;
        }

        public function free(){
            mysqli_free_result($this->rs);
        }
    }// end of database class
?>