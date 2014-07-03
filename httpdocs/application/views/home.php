<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Image gallery</title>
        <link rel="stylesheet" href="/assets/css/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/assets/css/rosemary.css" type="text/css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="/assets/js/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
        <script type="text/javascript" src="/assets/js/rosemary.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>

<div id="container">
    <div class="loading">
        <img src="/assets/img/loading.gif">
        <noscript>JavaScript must be enabled in order to view this website</noscript>
    </div>
    <div class="gallery">
    <?php foreach($photos as $month => $photos): ?>
        <?php $i = 0; foreach($photos as $key => $photo): ?>
        <div class="item">
            <?php if ($i == 0): ?>
                <p class="date"><?php echo date('F Y', strtotime($month)) ?></p>
            <?php endif; ?>
            <a class="fancybox" rel="group" href="<?php echo $photo->url ?>" title="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?> - <?php echo $photo->label ?>. <a href='<?php echo $photo->fullsize_url ?>' target='_blank'>Download full size</a>">
                <img src="<?php echo $photo->thumbnail_url ?>" title="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?>"  alt="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?>" />
            </a>
        </div>
        <?php $i++;endforeach; ?>
    <?php endforeach; ?>
    </div>
</div>
<!-- Page rendered in {elapsed_time} seconds -->
</body>
</html>