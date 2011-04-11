<?
//     require_once('zpf-files.php');
//---------------------------------------function del_dir($dir)
//----------------------------------------------Borra todo un directorio con subdirectorios
function del_dir($dir) //Borrar el directorio
{
 $dir = strtr($dir, "//", "/");
 if (is_dir($dir))
 {
   chmod($dir,0777);
   $handle = opendir($dir);
   while(false !==($filename=readdir($handle)))
	{
	  if($filename!='.' && $filename!='..')
	  {
		  if (is_file("$dir/$filename")||is_link("$dir/$filename"))
		  {
			unlink("$dir/$filename");
		  }// if (is_file("$dir/$filename")||is_link("$dir/$filename"))
		  elseif(is_dir("$dir/$filename"))
		  {
		    $addr = strtr($addr, "дец", "aao");
			del_dir("$dir/$filename");
		  }//  elseif(is_dir("$dir/$filename"))
	  }// if($filename!='.'||$filename!='..')
	  
	}
   closedir($handle);
   rmdir($dir);
 }
 else
 {
//  unlink($dir);
 }
} // de function del-dir($dir) //Borrar el directorio
//---------------------------------------function del_dir($dir)

//---------------------------------------function del_dir_files($dir)
//----------------------------------------------Borra todos lso archivos de un direcotrio
function del_dir_files($dir) //Borrar archivos del directorio
{
 $dir = strtr($dir, "//", "/");
 //chmod($dir,0777);
 if (is_dir($dir))
 {
   $handle = opendir($dir);
   while(false !==($filename=readdir($handle)))
	{
	  if($filename!='.' && $filename!='..')
	  {
		  if (is_file("$dir/$filename")||is_link("$dir/$filename"))
		  {
			unlink("$dir/$filename");
		  }// if (is_file("$dir/$filename")||is_link("$dir/$filename"))
	  }// if($filename!='.'||$filename!='..')
	  
	}
   closedir($handle);
 }
} // de function del_dir_files($dir) //Borrar el directorio
//---------------------------------------function del_dir_files($dir)



//------------funcion copy dir

function copydirr($dirsource,$dirdest)

{ // recursive function to copy
  // all subdirectories and contents:

  if(is_dir($dirsource))
  {
  $dir_handle=opendir($dirsource);
  mkdir($dirdest, 0777);
  while($file=readdir($dir_handle))
  {
    if($file!="." && $file!="..")
    {
      if(!is_dir($dirsource."/".$file)) 
	  { copy ($dirsource."/".$file, $dirdest."/".$file); }
      else 
	  { copydirr($dirsource."/".$file, $dirdest."/".$file); }
    }
  }
     /* This is the correct way to loop over the directory. */

  }
  closedir($dir_handle);
  return true;
}





//-----------------------------------
/*

To make it return only other directories or only files, insert one of the following where indicated:

DIR ONLY OPTION 1: if(is_dir($full_path)){ $list[]=$full_path; }

FILE ONLY OPTION 2: if(is_file($full_path)){ $list[]=$full_path; }
*/
function dir_tree($path){ //where $path is your source dir.
     $handle=opendir($path);
     while($a=readdir($handle)){
         if(!preg_match('/^\./',$a)){
               $full_path="$path/$a";
               $list[]=$full_path; // REPLACE WITH OPTION IF NEEDED.
               if(is_dir($full_path)){
                   $recursive=dir_tree($full_path);
                   for($n=0; $n<count($recursive); $n++){
                         $list[]=$recursive[$n];
                   }
               }
         }
     }
     closedir($handle);
     return $list;
}

function dir_dirdirs($path){ //where $path is your source dir.
     $handle=opendir($path);
     while($a=readdir($handle)){
         if(!preg_match('/^\./',$a)){
               $full_path="$path/$a";
               
               if(is_dir($full_path)){
						$list[]=$full_path;
                   }
               
         }
     }
     closedir($handle);
     return $list;
}

function dir_files($path,$ext='',$start='')
{ //where $path is your source dir.

	 $list=array();
     $handle=opendir($path);


	 if(!$start)
	 {
		 while($a=readdir($handle))
		 {	 
			 if(!preg_match('/^\./',$a))
					{
						$full_path="$path/$a";
						if( is_file($full_path)&&(strrpos($full_path, $ext)+strlen($ext) === strlen($full_path)OR$ext=='') ){ $list[]=$full_path; }
					}
		}//while($a=readdir($handle))
		
	} else {//if(!$start)
		
		while($a=readdir($handle))
		{
			if(strpos($a,$start)===0)//si coincide el inicio con lo requerido le sigo
			{
			 	if(!preg_match('/^\./',$a))
					{
						$full_path="$path/$a";
						if( is_file($full_path)&&(strrpos($full_path, $ext)+strlen($ext) === strlen($full_path)OR$ext=='') ){ $list[]=$full_path; }
					}
			}//if(strpos($a,$start)===0)/
		}//while($a=readdir($handle))
	
	}//} else {//if(!$start)
  
    
     closedir($handle);
     return $list;
}

function dir_files2($path,$ext='',$start='') //devuelve solo el nombre de los archivos sin el path
{ //where $path is your source dir.
	$ret=dir_files($path,$ext='',$start='');
	//chek($ret);
	foreach ($ret as &$retelm)
	{
		$retelm=substr($retelm, strlen($path.'/') ); 
	}
	return $ret;
}
?>