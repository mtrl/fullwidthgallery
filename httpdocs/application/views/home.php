<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Rose</title>
        <link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    $(".fancybox").fancybox();
            });
        </script>
        <style type="text/css">
            body {
                font-family: 'Roboto', sans-serif;
                background: url(/img/rosemary.jpg) top center no-repeat;
                background-attachment: fixed;
            }
            h1 {
                font-size: 24px;
                color: #ea86ff;
                font-weight: 100;
            }
        </style>
</head>
<body>

<div id="container">
    <?php foreach($photos as $month => $photos): ?>
        <h1><?php echo date('F Y', strtotime($month)) ?></h1>
        <?php foreach($photos as $key => $photo): ?>
            <a class="fancybox" rel="group" href="<?php echo $photo->url ?>" title="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?> - <?php echo $photo->label ?>">
                <img src="<?php echo $photo->thumbnail_url ?>" title="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?>"  alt="<?php echo date('jS F Y', strtotime($photo->exif['date_time'])) ?>" />
            </a>
            <!-- <?php echo $photo->thumbnail_url ?><br /> -->
        <?php endforeach; ?>      
    <?php endforeach; ?>  
</div>
<!-- Page rendered in {elapsed_time} seconds -->
</body>
</html>