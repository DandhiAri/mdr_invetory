<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= $file_name ?></title>
   <style>
	body{
		padding :0;
		margin: 0;
	}
	iframe{      
        display: block;  
        height: 100vh;  
        width: 100vw;     
        border: none; 
        background: lightyellow; 
    }
   </style>
</head>
<body>
	<?php 
		$file_path = base_url("/assets/docs/documentation/" . $file_name);
		$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
	?>
	<iframe src="<?= $file_path ?>" width="100%" height="100%" frameborder="0"></iframe>
</body>
</html>
