<?
if($_POST)
{
	foreach($_POST as $key => $value)
		{
			${$key} =& $_POST[$key];

		}

}
if($_GET)
{
	foreach($_GET as $key => $value)
		{
			${$key} =& $_GET[$key];

		}

}

if($_SESSION)
{
	foreach($_SESSION as $key => $value)
		{
			//${$key} = NULL;
			${$key} =& $value;
		}
}


?>