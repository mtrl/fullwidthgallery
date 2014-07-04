fullwidthgallery
================

A PHP image gallery for baby or child photos. The age of the child when each photo is taken is shown in the gallery.

![gallery](https://raw.githubusercontent.com/mtrl/fullwidthgallery/master/screenshots/gallery.jpg)
![gallery-lightbox](https://raw.githubusercontent.com/mtrl/fullwidthgallery/master/screenshots/gallery-lightbox.jpg)

Thumbnails and web sized images are auto generated and cached.

The gallery fills each row of the gallery to fill the full screen width.

# Instructions
1. Requires the PHP exif module to add date and order
1. Copy the config file "application/config/config.php.sample" to "application/config/config.php" and edit as needed.
1. Clone and upload the contents of the httpdocs to desired directory on your web server.
1. The "photos" directory must be made writable "0755".
1. Add photos to "/photos" directory. The gallery will automatically resize to the sizes specified in application/config/config.php

Images are sorted by date if present in the EXIF data or by date created if EXIF data does not exist. Jpg images only.

Uses CodeIgniter, jQuery and magnific 
