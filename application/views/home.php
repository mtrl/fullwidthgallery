<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $config['gallery_title'] ?></title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
        <link rel="stylesheet" href="/assets/min/all.css" type="text/css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	    
	<script type="text/javascript" src="/assets/js/ZeroClipboard.min.js"></script>
        <script type="text/javascript" src="/assets/min/all.js"></script>
</head>
<body>

<div id="container">
    <div class="loading">
        <img src="<?php echo $config['loading_image'] ?>">
        <div class="text">
            <p>Loading<span class="elipsis">...</span></p>
        </div>
        <noscript>JavaScript must be enabled in order to view this gallery</noscript>
    </div>
    <div class="gallery">
    <?php foreach($photos as $month => $photos): ?>
        <?php $i = 0; foreach($photos as $key => $photo): ?>
        <div class="item">
            <?php if ($i == 0): ?>
                <p class="date"><?php echo date('F Y', strtotime($month)) ?></p>
            <?php endif; ?>
            <a id="<?php echo $photo->get_direct_link() ?>" rel="group" href="<?php echo $photo->url ?>" title="
		    <?php echo $photo->label ?><br>
		    <?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?> - <?php echo $photo->age ?> old<br>
		    <a href='#' class='show-more-options'>More options</a>
		    <div class='more-options'>
			<p>
			    <span class='hash'>#<?php echo $photo->get_direct_link() ?></span>
			    <a class='fullsize' href='<?php echo $photo->fullsize_url ?>' target='_blank'><img src='assets/img/icon_download.png' /> Download full size</a><a name='more-options'>&nbsp;&nbsp;</a>
			    <a href='#' id='copy-button' data-clipboard-text='<?php echo $photo->get_direct_link(true) ?>'><img src='assets/img/icon_copy.png'> Copy link</button>
			</p>
		    </div>
	    ">
                <img class="lazy" data-original="<?php echo $photo->thumbnail_url ?>" width="<?php echo $photo->thumbnail_width ?>"  height="<?php echo $photo->thumbnail_height ?>" title="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?>"  alt="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?>" />
            </a>
        </div>
        <?php $i++;endforeach; ?>
    <?php endforeach; ?>
    </div>
</div>
<!-- Page rendered in {elapsed_time} seconds -->
</body>
</html>
