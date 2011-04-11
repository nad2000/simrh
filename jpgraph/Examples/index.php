<?
	foreach (new DirectoryIterator('./') as $file) 
	{ 
		$file=$file->getFilename();
		
		if($file!='.' AND  $file!='..')
		echo '<br /><br /><br /><br />'.$file.'<br />';
		?><img src="<?=  $file ?>" /><?				   
	} 
?>