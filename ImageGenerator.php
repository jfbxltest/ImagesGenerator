<?php

class ImageGenerator {

    //on recoit l'image
    //on la converti en GD image selon le type
    //demande de taille et de format
    //

    static function generate(string $image, string $targetDir, $options) {
        //on recoit l'image
        //on la converti en GD image selon le type
        $gdImage =  ImageGenerator::getGdImage($image);
        $baseName = basename($image,'.'.pathinfo($image, PATHINFO_EXTENSION));

        foreach($options as $option) {
            $imageSized = ImageGenerator::getImageSized($gdImage, $option['w'], $option['h']);
            ImageGenerator::writeImage($imageSized, $targetDir,$baseName,$option['formats']);

        }
    }

    static private function getGdImage($image)  {
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $gdImage = null;
        // var_dump($ext);
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $gdImage = imagecreatefromjpeg($image);
                break;
            case 'png':
                $gdImage = imagecreatefrompng($image);

        }
        
        return $gdImage;
    }

    static private function getImageSized( $gdImage, int $width, int $height) {
        $x = imagesx($gdImage);
        $y = imagesy($gdImage);
        $ratio = $width / $height * $y;
        
        $dimX = $width;
        $dimY = $height; 
        $decalX = 0; 
        $decalY = 0;
        
        if($x > $ratio) { 
            $dimX = $height * $x / $y; 
            $decalX = -($dimX - $width) / 2; 
        } elseif ($x < $ratio) {
            $dimY = $width * $y / $x;
            $decalY = -($dimY - $height) / 2;
        } 
        
        $resized = imagecreatetruecolor($width, $height);
        imagecopyresampled($resized,$gdImage,$decalX,$decalY,0,0,$dimX,$dimY,$x,$y);
        return $resized;
    }

    static private function formatFileName(string $name, int $w, int $h, string $ext): string {
        $format = '%s-%04dx%04d.%s';
        return sprintf($format, $name, $w, $h, $ext);
    }

    static private function writeImage($gdImage, string $targetDir, string $baseName, array $exts) {
        $x = imagesx($gdImage);
        $y = imagesy($gdImage);

        if (in_array('jpg', $exts)) { imagejpeg($gdImage,"$targetDir/$baseName-$x x $y.jpg",90); }
        // if (in_array('avif', $exts)) { imageavif($gdImage,"$targetDir/$baseName-$x x $y.avif",90,10); }
        if (in_array('webp', $exts)) { imagewebp($gdImage,"$targetDir/$baseName-$x x $y.webp",90); }



       

    }
}