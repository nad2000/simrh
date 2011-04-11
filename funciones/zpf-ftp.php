<?php
//include("funciones.php");

function ftp_putAll($conn_id, $src_dir, $dst_dir) {
   $d = dir($src_dir);
   while($file = $d->read()) { // do this for each file in the directory
       if ($file != "." && $file != "..") { // to prevent an infinite loop
           if (is_dir($src_dir."/".$file)) { // do the following if it is a directory
               if (!@ftp_nlist($conn_id, $dst_dir."/".$file)) {
                   ftp_mkdir($conn_id, $dst_dir."/".$file); // create directories that do not yet exist
               }
               ftp_putAll($conn_id, $src_dir."/".$file, $dst_dir."/".$file); // recursive part
           } else {
               $upload = ftp_put($conn_id, $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY); // put the files
           }
       }
   }
   $d->close();
}


function ftp_rmAll($conn_id,$dst_dir)
{
  $ar_files = ftp_nlist($conn_id, $dst_dir);
  if (is_array($ar_files)) { // makes sure there are files
   foreach ($ar_files as $st_file) { // for each file
// ADDITION TO SKIP CURRENT AND PARRENT FOLDERS
       if (($st_file == ".") || ($st_file == "..")) {
         continue; }

           if (ftp_size($conn_id, $st_file) == -1){   
           ftp_rmAll($conn_id, $st_file);
           } else {
           ftp_delete($conn_id, $st_file); 

     }
   }
  }
  ftp_rmdir($conn_id, $dst_dir); // delete empty directories
}

?>