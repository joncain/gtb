<?php
function assignArrayMacroValue($ereg, $var, $macros, &$formtemplate, $rs = null) {
	for ($i = 0; $i < count($macros); $i++) {
		if (preg_match($ereg, $macros[$i], $matches)) {
			if ($rs[$var] == $matches[1]) {
				#print("assign {$macros[$i]} = CHECKED<BR>");
				$formtemplate->assign($macros[$i], " CHECKED ");
			}
		}
	}
	return(true);
}

function validString($value) {
	if (strlen($value) > 0 && preg_match("/[a-zA-Z]+/", $value)) {
		return(true);
	}
	return(false);
}

function toBool($val) {
	if (strtolower($val) === "yes") {
		return(1);
	}
	return(0);
}

function validBool($value) {
	#if ($value === true || $value === false || $value === 1 || $value === 0 || $value === "1" || $value === "0") {
	if ((bool)$value === true || (bool)$value === false) {
		return(true);
	}
	return(false); 
}

function whenEmptyThenZero($value) {
	if (empty($value)) {
		return(0);
	}
	return($value);
}

function validYear($year) {
	if (preg_match("/^[0-9]{4}$/", $year)) {
		return(true);
	}
	return(false);
}


function validAddress($address) {
	$address = str_replace("\'", "'", $address);
	if (preg_match("/^[-,' a-z0-9.]{5,255}$/i", $address)) {
		return(true);
	}
	return(false);
}

function validCity($city) {
	$city = str_replace("\'", "'", $city);
	if (preg_match("/^[-,' a-z]{4,255}$/i", $city)) {
		return(true);
	}
	return(false);
}

function validStateCode($state) {
	if (preg_match("/^[a-z]{2}$/i", $state)) {
		return(true);
	}
	return(false);
}

function validZip($zip) {
	if (preg_match("/^[0-9]{5}(-[0-9]{4})?$/", $zip)) {
		return(true);
	}
	return(false);
}

function validPhone($phone) {
	if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
		return(true);
	}
	return(false);
}

function validEmail($email) {
	if (preg_match("/^[a-z]{1}[-._a-z0-9]{1,60}@[-a-z.]{1,60}\.[a-z]{2,4}$/i", $email)) {
		return(true);
	}
	return(false);
}

function validCCExp($exp) {
	global $db;
	if (preg_match("/^[0-9]{2}\/[0-9]{2,4}$/", $exp)) {
		$mm = substr($exp, 0, 2);
		$yy = substr($exp, 3, 4);
		if ((int)$yy == (int)date("Y") && (int)$mm >= (int)date("m")) {
			//this year
			return(true);
		}
		if ((int)$yy > (int)date("Y")) {
			//future year
			return(true);
		}
	}
	return(false);
}

function validMoney($money) {
	if (preg_match("/^[0-9]+(\.[0-9]{2})?$/", $money)) {
		return(true);
	}
	return(false);
}

function validCC($cc) {
	if (preg_match("/^[0-9]{16}$/", $cc)) {
		return(true);
	}
	return(false);
}

function validName($name) {
	$name = str_replace("\'", "'", $name);
	if (preg_match("/^[a-z]{1}[a-z -']{1,50}$/i", $name)) {
		return(true);
	}
	return(false);
}

function validateID($id) {
	if (ereg("^[0-9]+$", $id) && $id > 0) {
		return(true);
	}
	return(false);	
}

function displayError($message) {
	$html = "<TABLE align=\"center\"><TR><TD class=\"error\">ERROR: $message!</TD></TR></TABLE>";
	return($html);
}

function dateToDateTime($date) {
        if (empty($date)) {
                $date= "NULL";
        } else {
                $date = "'" . date("Y-m-d", strtotime($date)) . "'";
        }
	return($date);
}

function sumflags($flags) {
	if (!is_array($flags)) {
		return(0);
	}
	$flags = array_sum($flags);
	return($flags);	
}

function ddlb($options, $currentValue = null) {
	if (!is_array($options)) {
		$options = array();
	}
	$name = $options["col_data"][0]["name"];
	$html = "<SELECT name=\"$name\">\r\n";
	for ($i = 0; $i < $options["rows"]; $i++) {
		$value = $options["row_data"][$i][$options["col_data"][0]["name"]];
		$label = $options["row_data"][$i][$options["col_data"][1]["name"]];
		if ($value == $currentValue) {
			$selected = "SELECTED";
		} else {
			$selected = "";
		}
		$html .= "<OPTION value=\"$value\" $selected>$label</OPTION>\r\n";
	}
	$html .= "</SELECT>\r\n";
	return($html);
}
?>
