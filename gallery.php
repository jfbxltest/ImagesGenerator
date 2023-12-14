<?php
//affiche les fichiers dans un repertoire donné

function isExtensionAccepted(string $file, array $accept): string 
{
    $ext = pathinfo($file,PATHINFO_EXTENSION );
    return in_array($ext, $accept);
}

function concatPowSize(float $s, int $u)
{
    $units = ['Ko', 'Mo', 'Go'];
    if($s > 1024 && $u < 2) {
        return concatPowSize($s / 1024, $u +1);
    } 
    return number_format($s, 2, ',', ' ') . ' ' . $units[$u];
}

function exprimeFileSizing(string $file): string
{
    $size = filesize($file);
    return concatPowSize($size, 0);
}

function exprimeImageDimensions(string $file): string
{
    $dimensions = getimagesize($file);
    $format = '%04dx%04d';
    return sprintf($format, $dimensions[0], $dimensions[1]);
}

function getInfoImageFile($file): array
{
    return [
        'name' => basename($file),
        'dimensions' => exprimeImageDimensions($file),
        'size' => exprimeFileSizing($file)
    ];
}

class Gallery
{

    private string $directory;
    private array $extensionsAccepted;
    
    public function __construct(string $directory, array $extensionsAccepted)
    {
        $this->directory = $directory;
        $this->extensionsAccepted = $extensionsAccepted;
    }

    /***
     * retoure le tableau des fichier images avec
     * - le nom
     * - le type (jpg, avif, webp, etc.)
     * - la taille (octect)
     * - les dimensions (lxh)
     */
    public function getFiles()
    {
        $dir = opendir($this->directory);
        $files = [];
        while($file = readdir($dir)){
            if (isExtensionAccepted($file, $this->extensionsAccepted)) {
                $files[] =  getInfoImageFile($this->directory . '\\' . $file);
            }
        }
        ?>
        <table>
            <tbody>
            <?php foreach($files as $file) : ?>
                <tr>
                    <?php foreach($file as $key=>$value) : ?>
                    <td><?= $value?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach  ?>
            </tbody>
        </table>
        <?php
    }


}