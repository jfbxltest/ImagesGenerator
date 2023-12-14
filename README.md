# ImagesGenerator

Générateur d'images managé en PHP

- A partir d'une image (jpeg / bmp) créer une série d'image selon une liste de dimensions et de format
- Observer les performances (taille image)

## Liste de dimensions et format

- format json

```
{
  "sizes" : [
      {
          "w" : 1234,
          "h" : 1234,
          "format" : ['jpg', 'avif', 'webp']
      }
  ]
}
```
