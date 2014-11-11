<?
class db {
	function connect($username, $password, $host="", $db) {
		$dbcon = mysql_connect($host,$username,$password);
		$dbname = mysql_select_db($db, $dbcon);
		if (is_resource($dbcon)) {
			$this->dbcon = $dbcon;
			return(true);
		} else {
			$this->exitWithError("Connection to the database could not be established"); 
			return(false);
		}
	}

	function exec($sql) {
		if (!$this->validateSQL($sql)) {
			$this->exitWithError("Invalid SQL");
			return(false);
		}
		$this->sql = $sql;

		###############################################################################
		#
		# get result set
		#
		$result_set = array();
		if ($qr = mysql_query($sql, $this->dbcon)) {
			if (ereg("SELECT ", $sql)) {
				###############################################################################
				#
				# not an INSERT - get result set data
				# number of rows
				#
				$result_set["rows"] = mysql_num_rows($qr);

				###############################################################################
				#
				# number of columns
				#
				$result_set["cols"] = mysql_num_fields($qr);
	
				while ($col = mysql_fetch_field($qr)) {
					###############################################################################
					#
					# column data
					#
					$result_set["col_data"][] = array("name"=>$col->name, "type"=>$col->type);
				}
				while ($row = mysql_fetch_assoc($qr)) {
					###############################################################################
					#
					# row data
					#
					$result_set["row_data"][] = $row;
				}
			} else {
				###############################################################################
				#
				# this query returned a new primary key - must be a insert
				#
				$result_set["rows"] = mysql_affected_rows($this->dbcon);
				$result_set["row_data"]["ID"] = mysql_insert_id($this->dbcon);
			}
		} else {
			###############################################################################
			#
			# query could not be executed
			#
			#$this->exitWithError("MySQL ERROR: ".mysql_error($this->dbcon));
			$this->error = mysql_error($this->dbcon);
			return(false);
		}	
		$this->result_set = $result_set;
		return(true);
	}

	function validateSQL($sql) {
		if (ereg("--", $sql)) {
			return(false);
		}
		if (!ereg("(SELECT|UPDATE|DELETE|INSERT){1}", $sql)) {
			return(false);
		}
		return(true);
	}

	function exitWithError($message="") {
		if ($message == "") {
			$message = $this->error;
		}
		ob_clean();
		print($message);
		exit();
		return(true);
	}

	var $dbcon;
	var $error;
	var $sql;
	var $result_set;
	var $error;
}
?>
