<?php
###############################################################################
#
# define template constants
#
define("TPL_REPLACE",	1);
define("TPL_APPEND",	2);
define("TPL_PREPEND",	4);

class template {
	var $template;

	function template($_template) {
		if (file_exists($_template)) {
			###############################################################################
			#
			# grab template
			#
			$this->template = implode("", file($_template));
		} else {
			###############################################################################
			#
			# couldn't find template
			#
			print("Template file \"$_template\" could not be found.");
			exit;
		}
		return;
	}
	
	function assign($macro, $value, $flags = TPL_REPLACE) {
		###############################################################################
		#
		# assign values to macros
		#
		#print("assign $macro = $value<BR>");
		$what	= "/(<MACRO:$macro>)/";
		$with	= $value;
		$this->template = preg_replace($what, $with, $this->template);
		return;
	}

	function parse($print = true) {
		###############################################################################
		#
		# perform macro replacments
		#
		if ($print) {
			print($this->template);
			return;
		} else {
			return($this->template);
		}
	}

	function getAllMacros() {
		$what	= "/<MACRO:([A-Za-z0-9]*)>/";
		preg_match_all($what, $this->template, $macros);
		return($macros[1]);
	}
}
?>

