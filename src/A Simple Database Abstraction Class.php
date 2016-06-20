A Simple Database Abstraction Class

<?php    

class CDBAbstract {    
  var $_db_linkid = 0;    
  var $_db_qresult = 0;   
  var $_auto_commit = false;   
  var $RowData = array();    
  var $NextRowNumber = 0;    
  var $RowCount = 0;   
  function CDBAbstract () {    
    die ("CDBAbstract: Do not create instances of CDBAbstract! Use a subclass.");    
  }   
  function Open ($host, $user, $pass, $db = "", $autocommit = true) {    
  }   
  function Close () {   
  }   
  function SelectDB ($dbname) {   
  }   
  function Query ($querystr) {   
  }   
  function SeekRow ($row = 0) {   
  }   
  function ReadRow () {   
  }   
  function Commit () {   
  }   
  function Rollback () {   
  }   
  function SetAutoCommit ($autocommit) {   
    $this->_auto_commit = $autocommit;   
  }   
  function _ident () {    
    return "CDBAbstract/1.2";    
  }   
}   

class CDBMySQL extends CDBAbstract {    
  function CDBMySQL ($host, $user, $pass, $db = "") {    
    $this->Open ($host, $user, $pass);    
    if ($db != "")     
      $this->SelectDB($db);    
  }      
  function Open ($host, $user, $pass, $autocommit = true) {    
    $this->_db_linkid = mysql_connect ($host, $user, $pass);    
  }      
  function Close () {    
    @mysql_free_result($this->_db_qresult);    
    return mysql_close ($this->_db_linkid);    
  }      
  function SelectDB ($dbname) {    
    if (@mysql_select_db ($dbname, $this->_db_linkid) == true) {    
      return 1;        
    }     
    else {    
      return 0;    
    }       
  }       
  function  Query ($querystr) {    
    $result = mysql_query ($querystr, $this->_db_linkid);    
    if ($result == 0) {    
      return 0;    
    }     
    else {    
      if ($this->_db_qresult)   
    @mysql_free_result($this->_db_qresult);    
      $this->RowData = array();          
      $this->_db_qresult = $result;    
      $this->RowCount = @mysql_num_rows ($this->_db_qresult);    
      if (!$this->RowCount) {    
    // The query was probably an INSERT/REPLACE etc. 
    $this->RowCount = 0;    
      }     
      return 1;    
    }    
  }      
  function SeekRow ($row = 0) {    
    if ((!mysql_data_seek ($this->_db_qresult, $row)) or ($row > $this->RowCount-1)) {   

      printf ("SeekRow: Cannot seek to row %d\n", $row);    
      return 0;    
    }    
    else {    
      return 1;    
    }    
  }        
  function ReadRow () {    
    if($this->RowData = mysql_fetch_array ($this->_db_qresult)) {    
      $this->NextRowNumber++;    
      return 1;    
    }    
    else {    
      return 0;    
    }    
  }      
  function Commit () {   
    return 1;   
  }   
  function Rollback () {   
    echo "WARNING: Rollback is not supported by MySQL";   
  }   
  function _ident () {    
    return "CDBMySQL/1.2";    
  }      
}    


class CDB_OCI8 extends CDBAbstract {    
  function CDB_OCI8($host, $user, $pass, $autocommit = true) {   
    $this->Open ($host, $user, $pass, "", $autocommit);    
  }   

  function Open($host, $user, $pass, $db = "", $autocommit = true) {    
    ($this->_db_linkid = OCILogon($user, $pass, $host)) or die("Error on logon: 
". OCIError());   
    $this->_auto_commit = $autocommit;   
  }   

  function Close() {    
    OCIFreeStatement($this->_db_qresult);   
    OCILogOff($this->_db_linkid) or die ("Error on logoff: ". OCIError());   
  }   

  function SelectDB($dbname) {   
    echo "CDB_OCI8 does not support SelectDB";   
    return 0;   
  }   

  function Query($querystr) {   
    ($result = ociparse($this->_db_linkid, $querystr))    
      or die("Error in query: ". OCIError());   
    if ($this->_auto_commit) {   
      OCIExecute($result, OCI_COMMIT_ON_SUCCESS);   
    }   
    else {   
      OCIExecute($result, OCI_DEFAULT);   
    }   
       
    if ($result == 0) {    
      return 0;    
    }     
    else {   
      if ($this->_db_qresult)   
    OCIFreeStatement($this->_db_qresult);   
      $this->RowData = array();      
      $this->_db_qresult = $result;   
      $this->RowCount = OCIRowCount($this->_db_qresult);   
      if (!$this->RowCount) {   
    // The query was probably an INSERT/REPLACE etc. 
    $this->RowCount = 0;    
      }   
      return 1;    
    }   
  }   

  function SeekRow ($row = 0) {   
    die ("CDB_OCI8 does not support SelectDB");   
  }   
        
  function ReadRow() {    
    if(OCIFetchInto($this->_db_qresult, $this->RowData, OCI_ASSOC)) {    
      $this->NextRowNumber++;    
      return 1;    
    }   
    else {   
      return 0;    
    }   
  }    

  function Commit() {   
    OCICommit($this->_db_linkid);   
  }   
  function Rollback() {   
    OCIRollback($this->_db_linkid);   
  }   

  function _ident () {    
    return "CDB_OCI8/1.0";    
  }   
}   


class CDB_pgsql extends CDBAbstract { 
  var $_php_ver_major; 
  var $_php_ver_minor; 
  var $_php_ver_rel; 
  function CDB_pgsql($host, $user, $pass, $db, $autocommit = true) { 
    $this->Open( $host, $user, $pass, $db, $autocommit ); 
  } 

  function Open ($host, $user, $pass, $db = "", $autocommit = true) {    
    list( $this->_php_ver_major, 
          $this->_php_ver_minor, 
          $this->_php_ver_rel   ) = explode( ".", phpversion() ); 
    ($this->_db_linkid = @pg_connect( "host=$host password=$pass dbname=$db user=$user" )) or 
      die("Error on logon:"); 
  }   

  function Close () {   
    pg_freeresult( $this->_db_qresult ); 
    return pg_close( $this->_db_linkid ); 
  }   

  function SelectDB ($dbname) {   
    echo "CDB_pgsql does not support SelectDB"; 
    return 0; 
  }   

  function Query ($querystr) {   
    if (!$this->_auto_commit) { 
        @pg_exec( $this->_db_linkid, "BEGIN;" ); 
    } 
    $result = pg_exec( $this->_db_linkid, $querystr ); 
    if ($result == 0) { 
      return 0; 
    } else { 
      if ($this->_db_qresult) 
        @pg_freeresult( $this->_db_qresult ); 
      $this->RowData = array(); 
      $this->_db_qresult = $result; 
      $this->RowCount = @pg_numrows( $this->_db_qresult ); 
      if (!$this->RowCount) { 
        // The query was probably an INSERT/REPLACE etc. 
        $this->RowCount = 0; 
      } 
      $this->NextRowNumber = 0; 
      return 1; 
    } 
  }   

  function SeekRow ($row = 0) {   
    $this->NextRowNumber = $row; 
    return 1; 
  }   

  function ReadRow ($arrType = PGSQL_ASSOC) {   
    if ($this->NextRowNumber >= $this->RowCount) 
        return 0; 
      if ($this->_php_ver_major > 3) { 
        if ($this->RowData = pg_fetch_array( $this->_db_qresult, $this->NextRowNumber, $arrType )) { 
          $this->NextRowNumber++; 
          return 1; 
        } else { 
          return 0; 
        } 
      } else { 
        if ($this->RowData = pg_fetch_array( $this->_db_qresult, $this->NextRowNumber )) { 
          $this->NextRowNumber++; 
          return 1; 
        } else { 
          return 0; 
        } 
      } 
  }   

  function Commit () {   
    return $this->Query("COMMIT;"); 
  }   

  function Rollback () {   
    return $this->Query("ROLLBACK;"); 
  }   

  function SetAutoCommit ($autocommit) {   
    $this->_auto_commit = $autocommit;   
  }   

  function _ident () {    
    return "CDB_pgsql/0.1";    
  }   
} 

/* 
##                                    Example 
## $sql = new CDBMySQL("localhost", "username", "password", "dbname"); 
## $sql -> Query ("SELECT firstname, lastname FROM people"); 
## while ($sql -> ReadRow()) { 
##   echo $sql -> RowData["lastname"] . ", "; 
##   echo $sql -> RowData["firstname"] . "<br>"; 
## }      
*/ 

?>

