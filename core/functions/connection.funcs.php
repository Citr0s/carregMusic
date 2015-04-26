<?PHP

function connect($addr, $user, $password, $db)  {
    mysql_connect($addr, $user, $password) or die("Could not establish connection with database:" . mysql_error());
    mysql_select_db($db);
}

function dropdown($var1, $var2, $table, $id, $tableName)	{
	echo "<select id='$id' name='$id'>";
	echo "<option value='0'>Select your $tableName</option>";

	$query = "SELECT $var1, $var2 FROM $table";
	$result = mysql_query($query) or die ("Query seeking $table from database failed:: " . mysql_error());
				
	while ($row = mysql_fetch_array($result)) {
		$id = $row["$var1"];	
		$cName = $row["$var2"];
		echo "<option value='$id'>$cName</option>"; 
	}
	
	echo "</select>";
}
	
?>