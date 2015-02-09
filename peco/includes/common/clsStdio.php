<?	
/******************************************************
 * Class StdIo
 *
 * In/Out data Handling
 * 
 * Project Name               :  PECO
 * Package Name            		:  
 * Program ID                 :  clsStdio.php
 * Environment                :  PHP  version 4, 5
 * Author                     :  JVB
 * Version                    :  1.0
 * Creation Date              :  2015/01/01
 *
 * Modification History     :
 * Version    Date            Person Name  		Chng  Req   No    Remarks
 * 1.0       	2015/01/01    	JVB          -  		-     -     -
 *
 ********************************************************/
class Stdio{
	var $allow_unicode = true;
	/**
	 * Init class
	 */
	function Stdio(){
	
	}
	/**
	 * Parse all _GET, _POST
	 */
	function parse_incoming($flag=true)
	{
		global $_GET, $_POST;
		$return = array();
		
		if($flag ==true && is_array($_GET) )
		{
			while( list($k, $v) = each($_GET) )
			{	
				if( is_array($_GET[$k]) )
				{
					while( list($k2, $v2) = each($_GET[$k]) )
					{
						$return[$k][ $this->clean_key($k2) ] = $this->clean_value($v2);
					}
				}
				else
				{
					$return[$k] = $this->clean_value($v);
				}
			}
		}
		
		// Overwrite GET data with post data		
		if($flag!=true && is_array($_POST) )
		{
			while( list($k, $v) = each($_POST) )
			{	
				if ( is_array($_POST[$k]) )
				{	
					while( list($k2, $v2) = each($_POST[$k]) )
					{	
						$return[$k][ $this->clean_key($k2) ] = $this->clean_value($v2);
					}
				}
				else
				{
					$return[$k] = $this->clean_value($v);
				}
			}
		}
		
		return $return;
	}
	/**
	 * Clean key
	 */
	function clean_key($key) {		
		if ($key == "")
		{
			return "";
		}
		$key = preg_replace( "/\.\./"           , ""  , $key );
		$key = preg_replace( "/\_\_(.+?)\_\_/"  , ""  , $key );
		$key = preg_replace( "/^([\w\.\-\_]+)$/", "$1", $key );
		return $key;
	}
	
	/**
	 * Clean value
	 */
	function clean_value($val) {
		$val = trim($val);
		if (is_array($val)) return $val;
		if ($val == "")
		{
			return "";
		}
		
		$val = str_replace( "&#032;"			 , " "						 , trim($val) );
		$val = str_replace( chr(0xCA)			 , ""							 , $val );  //Remove sneaky spaces
		$val = str_replace( "&"            , "&amp;"         , $val );
		$val = str_replace( "<!--"         , "&#60;&#33;--"  , $val );
		$val = str_replace( "-->"          , "--&#62;"       , $val );
		$val = preg_replace( "/<script/i"  , "&#60;script"   , $val );
		$val = str_replace( ">"            , "&gt;"          , $val );
		$val = str_replace( "<"            , "&lt;"          , $val );
		$val = str_replace( "\""           , "&quot;"        , $val );
		$val = preg_replace( "/\n/"        , "<br>"          , $val ); // Convert literal newlines
		$val = preg_replace( "/\\\$/"      , "&#036;"        , $val );
		$val = preg_replace( "/\r/"        , ""              , $val ); // Remove literal carriage returns
		$val = str_replace( "!"            , "&#33;"         , $val );
		$val = str_replace( "'"            , "&#39;"         , $val ); // IMPORTANT: It helps to increase sql query safety.
		
		// Ensure unicode chars are OK
		if ( $this->allow_unicode )
		{
			$val = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $val );
		}
		
		// Strip slashes if not already done so.
		if ( get_magic_quotes_gpc() )
		{
			$val = stripslashes($val);
		}
		
		// Swop user inputted backslashes
		$val = preg_replace( "/\\\(?!&amp;#|\?#)/", "&#092;", $val ); 
		
		return $val;
	}
	function GET($var, $default=""){
		return isset($_GET[$var])? $_GET[$var] : $default;
	}
	function POST($var, $default=""){
		return isset($_GET[$var])? $_GET[$var] : $default;
	}
}
?>