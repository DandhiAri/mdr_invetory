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
		$file_path = base_url("/assets/docs/invoice/" . $file_name);
		$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
		
		$image_extensions = ['jpg', 'jpeg', 'png', 'gif'];

		if ($file_extension == 'pdf') {
			$file_path = base_url("/assets/docs/invoice/pdf/" . $file_name);
		} elseif (in_array($file_extension, $image_extensions)) {
			$file_path = base_url("/assets/docs/invoice/img/" . $file_name);
		} else {
			$file_path = null;
		}
	?>

	<?php if($file_extension == 'pdf'){ ?>
		<iframe src="<?= $file_path ?>" width="100%" height="100%" frameborder="0"></iframe>
	<?php } else { ?>
		<img src="<?= $file_path ?>" alt="Document Image" style="width:100%; max-height:100%;">
	<?php } ?>
</body>
</html>
