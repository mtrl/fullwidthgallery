fullwidthgallery
================

A PHP image gallery for baby or child photos. The age of the child when each photo is taken is shown in the gallery.

Thumbnails and web sized images are auto generated and cached.

The gallery fills each row of the gallery to fill the full screen width.

# Instructions
1. Clone and place in desired directory
2. Requires the PHP exif module to add date and order
3. httpdocs/photos must be writable
4. Add photos to photos directory. The gallery will automatically resize to the sizes specified in application/config/config.php

Images are sorted by date if present in the EXIF data or by date created if EXIF data does not exist. Jpg images only.

Uses CodeIgniter, jQuery and magnific 
