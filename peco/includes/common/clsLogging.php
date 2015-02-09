<?php
/**
*  Logging Handling
*  @author		: Wouter van Vliet (wouter@escotday.com)
*  modifier		: JVB ()
*  @date		: 25/11/2006
*  @version		: 1.0.0
*/
define("L_STDERR", 1);//file
define("L_STDOUT", 2);//monitor
define("DATESTRING_FULL", "Y-m-d D H:i:s");
define("FS_ROOTDIR", '');

class VnLogging{
	
	var $LogHandle;
	var $LogType;
	var $DisAbled = Array();

	/**
	 * Init class
	 */
	function VnLogging($Target = L_STDOUT, $logFile="debug.log") {
		if ($Target == L_STDOUT) {
			$this->setLogType(L_STDOUT);
		}else
		if ($Target == L_STDERR) {
			if ($Handle = @fopen($logFile, 'a')) {
				$this->setLogHandle($Handle);
				$this->setLogType(L_STDERR);
			} else {
				$this->setLogType(L_STDOUT);
			};
		}else
		if (is_resource($Target)) {
			$this->setLogHandle($Target);
			$this->setLogType(L_STDERR);
		}else{
			if ($Handle = @fopen($Target, 'a')) {
				$this->setLogHandle($Handle);
				$this->setLogType(L_STDERR);
			}else{
				$this->setLogType(L_STDOUT);
			};
		};
	}

	/**
	 * Set disable error-type
	 */
	function disableType($Type) {
		$this->DisAbled[$Type] = 1;
	}

	/**
	 * Set enable error-type
	 */
	function enableType($Type) {
		unset($this->DisAbled[$Type]);
	}

	/**
	 * Set log handle
	 */
	function setLogHandle($LH) {
		$this->LogHandle = $LH;
	}

	/**
	 * Set log type
	 */
	function setLogType($LT) {
		$OldLogType = $this->LogType;
		$this->LogType = $LT;
		return $OldLogType;
	}

	/**
	 * Write error string
	 */
	function Error($String) {
		$this->_doWrite('error', $String);
	}
	
	/**
	 * Write warning string
	 */
	function Warning($String) {
		$this->_doWrite('warning', $String);
	}

	/**
	 * Write notice string
	 */
	function Notice($String) {
		$this->_doWrite('notice', $String);
	}

	/**
	 * Write fatal string
	 */
	function Fatal($String) {
		$this->_doWrite('FATAL', $String);
		die;
	}

	/**
	 * Write fatal string
	 */
	function Strict($String) {
		$this->_doWrite('FATAL', $String);
		die;
	}

	/**
	 * Dump variable
	 */
	function Dumper($VarName) {
		$this->_doWrite('notice', '{VARDUMP}'."\n".var_export($VarName, true));
	}

	/**
	 * Write error to stdout
	 */
	function _doWrite($Type, $String) {
		if (isset($this->DisAbled[$Type])) return false;

		$LogString = '['.date(DATESTRING_FULL).'] ['.$Type.'] ' . $String;

		if ($Type != 'notice') {
			$BT = debug_backtrace();
			$Indent = "\t--";
			while($Stack = array_pop($BT)) {
				if (!isset($Stack['line'])) continue;
				if (isset($Stack['function']) && $Stack['function'] == '_dowrite') continue;
				$Stack['file'] = substr($Stack['file'], strlen(FS_ROOTDIR));
				$Appendix = ' '."\n$Indent -> ";
				if (isset($Stack['class'])) $Appendix .= $Stack['class'].$Stack['type'];
				if (isset($Stack['function'])) $Appendix .= $Stack['function'].'()';
				$LogString .= $Appendix.' @ '.$Stack['file'].' line '.$Stack['line'];
				$Indent .= "--";
			};
		};
		
		switch($this->LogType) {
			case L_STDERR:
				if (!$this->LogHandle) return false;
				fwrite($this->LogHandle, $LogString . "\n");
				break;
			case L_STDOUT:
				if (!isset($_SERVER['REMOTE_ADDR'])) {
					print "$LogString\n";
				} else {
					print "<PRE>\n<b>$LogString</b>\n</PRE>";
				}
				break;

		};
	}
};
?>