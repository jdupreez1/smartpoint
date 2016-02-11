<?php

	//escape out quotes and define character encoding
	function escape($string)
	{
		return htmlentities($string,ENT_QUOTES,'UTF-8');
				
	}

?>