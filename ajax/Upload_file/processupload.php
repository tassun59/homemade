<?php
$index = $_POST['index'];

if($index == 0)
{
	$file_input = $_FILES["FileInput"];
	$file_input_error = $_FILES["FileInput"]["error"];
	$file_input_type = $_FILES['FileInput']['type'];
	$file_input_tmp_name = $_FILES['FileInput']['tmp_name'];
	$file_output = $_POST['FileOutput'];
	$File_Name          = strtolower($_FILES['FileInput']['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	$NewFileName 		= $_POST['Name_File_id'].'_'.$Random_Number.$File_Ext; //new file name
}
else
{
	$file_input = $_FILES["FileInput-".$index];
	$file_input_error = $_FILES["FileInput-".$index]["error"];
	$file_input_type = $_FILES['FileInput-'.$index]['type'];
	$file_input_tmp_name = $_FILES['FileInput-'.$index]['tmp_name'];
	$file_output = $_POST['FileOutput-'.$index];
	$File_Name          = strtolower($_FILES['FileInput-'.$index]['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	$NewFileName 		= $_POST['Name_File_id-'.$index].'_'.$Random_Number.$File_Ext; //new file name
}


if(isset($file_input) && $file_input_error== UPLOAD_ERR_OK)
{
	############ Edit settings ##############
	//$UploadDirectory	= '../../ressources/1/'; //specify upload directory ends with / (slash)
	$UploadDirectory	= $file_output; //specify upload directory ends with / (slash)
	##########################################
	
	/*
	Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
	Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
	and set them adequately, also check "post_max_size".
	*/
	
	//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die();
	}
	
	
	//Is file size is less than allowed size.
	/*if ($_FILES["FileInput"]["size"] > 5242880) {
		die("File size is too big!");
	}*/
	
	//allowed file type Server side check
	switch(strtolower($file_input_type))
		{
			//allowed file types
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html': //html file
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
				break;
			default:
				die('Unsupported File!'); //output error
	}
	
	
	
	if (!file_exists($UploadDirectory)) {
		//Créer un dossier 'fichiers/1/'
		mkdir($UploadDirectory, 0777, true);
	}
	
	
	if($index != 0)
	{
		$ouverture=opendir($file_output);
		$fichier=readdir($ouverture);
		$fichier=readdir($ouverture);
		while ($fichier=readdir($ouverture)) {
		unlink($file_output.$fichier);
		}
		closedir($ouverture);
	}
	
	
	if(move_uploaded_file($file_input_tmp_name, $UploadDirectory.$NewFileName ))
	   {
		die('Success! File Uploaded.');
	}else{
		die('error uploading File!');
	}
	
}
else
{
	die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
}