<?php
	/*
	 * This function will merge an existing set of rules with a new set of rules, replacing the keys from the old set of rules with the keys of the new set of rules
	 */
	function merge_rules($oldrules, $newrules) {
		foreach ($oldrules as $oldkey => $oldval) {
			foreach ($newrules as $newkey => $newval) {
				if ($oldval[0] === $newval[0])
					unset($oldrules[$oldkey]);
			}
		}
		return array_merge($oldrules, $newrules);
	}

function yiilog($object) {
	Yii::log(print_r($object, true), 'warning');
}

function mergeErrors($errors) {
	$e  = "";
	foreach ($errors as $error) {
		foreach ($error as $err) {
			$e .= $err . "|";
		}
	}
	$e = rtrim($e, "|");
	return $e;
}

function merge_config($baseconfig, $localconfig) {
	foreach ($localconfig as $key => $value) {
		if (array_key_exists($key, $baseconfig) && is_array($value)) {
			$baseconfig[$key] = merge_config($baseconfig[$key], $localconfig[$key]);
		} else {
			$baseconfig[$key] = $value;
		}
	}
	return $baseconfig;
}

function hasRole($role) {
	if (Yii::app()->user->isGuest) {
		return false;
	}
	if (is_array($role)) {
		foreach ($role as $r) {
			if (Yii::app()->authManager->isAssigned($r, Yii::app()->user->id)) {
				return true;
			}
		}
		return false;
	} else {
		return Yii::app()->authManager->isAssigned($role, Yii::app()->user->id);
	}
}

/**
 * Unescape characters
 */
function unescape($string) {
	$string = str_replace('\0', "\0", $string);
	$string = str_replace('\n', "\n", $string);
	$string = str_replace('\r', "\r", $string);
	$string = str_replace('\t', "\t", $string);
	$string = str_replace('\\', "\\", $string);
	$string = str_replace('\'', "\'", $string);
	$string = str_replace('\"', "\"", $string);
	return $string;
}

/**
 * Create a 2D array from a CSV string
 *
 * @param mixed $data 2D array
 * @param string $delimiter Field delimiter
 * @param string $enclosure Field enclosure
 * @param string $newline Line seperator
 * @return
 */
function parseCSV($data, $delimiter = ',', $enclosure = '"', $newline = "\n") {
	$pos = $last_pos = -1;
	$end = strlen($data);
	$row = 0;
	$quote_open = false;
	$trim_quote = false;

	$return = array();
	$delimiter = ($delimiter === "") ? ',' : unescape($delimiter);
	$enclosure = ($enclosure === "") ? '"' : unescape($enclosure);
	$newline = ($newline === "") ? '\n' : unescape($newline);

	// Create a continuous loop
	for ($i = -1;; ++$i){
		++$pos;
		// Get the positions
		$comma_pos = strpos($data, $delimiter, $pos);
		$quote_pos = strpos($data, $enclosure, $pos);
		$newline_pos = strpos($data, $newline, $pos);

		// Which one comes first?
		$pos = min(($comma_pos === false) ? $end : $comma_pos, ($quote_pos === false) ? $end : $quote_pos, ($newline_pos === false) ? $end : $newline_pos);

		// Cache it
		$char = (isset($data[$pos])) ? $data[$pos] : null;
		$done = ($pos == $end);

		// It it a special character?
		if ($done || $char == $delimiter || $char == $newline){

			// Ignore it as we're still in a quote
			if ($quote_open && !$done){
				continue;
			}

			$length = $pos - ++$last_pos;

			// Is the last thing a quote?
			if ($trim_quote){
				// Well then get rid of it
				--$length;
			}

			// And we're done
			if ($done){
				break;
			}

			// Get all the contents of this column
			$return[$row][] = ($length > 0) ? str_replace($enclosure . $enclosure, $enclosure, substr($data, $last_pos, $length)) : '';

			// Save the last position
			$last_pos = $pos;

			// Next row?
			if ($char == $newline){
				++$row;
			}

			$trim_quote = false;
		}
		// Our quote?
		else if ($char == $enclosure){

			// Toggle it
			if ($quote_open == false){
				// It's an opening quote
				$quote_open = true;
				$trim_quote = false;

				// Trim this opening quote?
				if ($last_pos + 1 == $pos){
					++$last_pos;
				}

			}
			else {
				// It's a closing quote
				$quote_open = false;

				// Trim the last quote?
				$trim_quote = true;
			}

		}

	}

	return $return;
}

/*
 * Checks if a table exists. Provide already normalized name
 */
function tableExists($table) {
	try {
		Yii::app()->db->createCommand("SELECT 1 FROM " . $table)->queryScalar();
	} catch (CDbException $e) {
		return false;
	}
	return true;
}

/*
 * Checks if a table column exists. Provide already normalized names
 */
function columnExists($table, $column) {
	try {
		Yii::app()->db->createCommand("SELECT " . $column . " FROM " . $table)->queryScalar();
	} catch (CDbException $e) {
		return false;
	}
	return true;
}

/*
 * Transforms a string so that we're sure it can be used everywhere in the system
 * if $uc is true, the first letter of the name will be uppercase
 */
function normalizeName($class, $uc = false) {
	/* Removes UTF-8 BOM marks and normalizes UTF-8 */
	$nclass = preg_replace('/\p{M}/u', '', Normalizer::normalize($class, Normalizer::FORM_D));
	/* Replace spaces and slashes by underscores */
	$nclass = preg_replace('/ /', '_', $nclass);
	$nclass = preg_replace('/\//', '_', $nclass);
	/* Removes characters other than [a-zA-Z0-9_] */
	$nclass = preg_replace('/[^a-zA-Z0-9_]/', '', $nclass);
	/* Limit to 16 characters and make lowercase - this is needed because MySQL foreign keys are max 64 characters: 16*3+9 */
	$nclass = substr(strtolower($nclass), 0, 16);
	return $uc ? ucfirst($nclass) : $nclass;
}

function m2h($minutes) {
	$d = floor($minutes / 1440);
	$h = floor(($minutes - $d * 1440) / 60);
	$m = $minutes - ($d * 1440) - ($h * 60);
	$d = $d > 0 ? "${d}d" : "";
	$h = $h > 0 ? "${h}h" : "";
	$m = $m > 0 ? "${m}m" : "";
	return "${d}${h}${m}";
}

function h2m($time) {
	$matches = array();
	$match = preg_match("/^(([0-9]+)[dD])?(([0-9]+)[hH])?(([0-9]+)[mM])?$/", $time, $matches);
	if (($match === FALSE) || ($match === 0)) {
		return FALSE;
	} else {
		$d = isset($matches[2]) ? intval($matches[2]) : 0;
		$h = isset($matches[4]) ? intval($matches[4]) : 0;
		$m = isset($matches[6]) ? intval($matches[6]) : 0;
	}
	return $d * 1440 + $h * 60 + $m;
}

function tdate($date) {
	return date("d-M-Y", strtotime($date));
}

?>
