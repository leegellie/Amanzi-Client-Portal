<html>
<head>
<title>MSSQL PHP Example -- Table List</title>
</head>
<body>
<?php
/*
This script will list all the tables in the specified data source.
Replace datasource_name with the name of your data source.
Replace database_username and database_password
with the SQL Server database username and password.
*/
$data_source='70.63.215.99';
$user='amanzimarblegran\lgellie';
$password='password.99';

// Connect to the data source and get a handle for that connection.
$conn=odbc_connect($data_source,$user,$password);
if (!$conn){
    if (phpversion() < '4.0'){
      exit("Connection Failed: . $php_errormsg" );
    }
    else{
      exit("Connection Failed:" . odbc_errormsg() );
    }
}

// Retrieves table list.
$result = odbc_tables($conn);

   $tables = array();
   while (odbc_fetch_row($result))
     array_push($tables, odbc_result($result, "TABLE_NAME") );
// Begin table of names.
     echo "<center> <table border = 1>";
     echo "<tr><th>Table Count</th><th>Table Name</th></tr>";
// Create table rows with data.
   foreach( $tables as $tablename ) {
     $tablecount = $tablecount+1;
     echo "<tr><td>$tablecount</td><td>$tablename</td></tr>";
   }

// End table.
echo "</table></center>";
// Disconnect the database from the database handle.
odbc_close($conn);
?>
</body>
</html>