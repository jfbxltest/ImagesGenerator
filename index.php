<?php

// $name = "test";
// $w = 568;
// $h = 245;
// $ext = 'jpg';
// $format = '%s-%04dx%04d.%s';
// echo sprintf($format, $name, $w, $h, $ext);


require ("ImageGenerator.php");
require ("gallery.php");

 $optionsImage = [[
   'w' => 640,
   'h' => 640,
   'formats' => ['jpg','webp','avif']
 ]];

$extensionsAccepted = ['jpg', 'avif', 'webp'];
$targetDirectory = __DIR__ . '\\images\\target';
$gallery = new Gallery($targetDirectory,  $extensionsAccepted);

 if(!empty($_FILES)){
	// require("imgClass.php");
	$img = $_FILES['img'];
    $ext = pathinfo($img['name'],PATHINFO_EXTENSION );

	$allow_ext = array("jpg",'png','jpeg');
	if(in_array($ext,$allow_ext)){
        if (is_uploaded_file($_FILES['img']['tmp_name'])) {
            
            $image = __DIR__ . '\\images\\' . basename($img['name']);
            // var_dump($image);
            if (move_uploaded_file($img['tmp_name'], $image)) {
                ImageGenerator::generate($image, $targetDirectory, $optionsImage);
            } else {
                $erreur =  "Possible file upload attack: ";
            }
        } else {
             $erreur =  "Possible file upload attack: ";
         }
	}
	else{
		$erreur = "Votre fichier n'est pas une image";
	}

}


 ?><!DOCTYPE html>
 <html lang="fr">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>

<body>
<?php
if(isset($erreur)){
	echo $erreur;
}

?>
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="file" name="img"/>
<input type="submit" name="Envoyer"/>
</form>

<?php 
    $gallery->getFiles();
?>
</body>

</html>