var imagesWide;
    
$(window).load(function() {
    $(".fancybox").fancybox({
        'titlePosition' : 'inside'
    });
    
    thumbnailsFillScreen();
    $(window).resize(function(){
       thumbnailsFillScreen();
    });
    showGallery();
});

function showGallery() {
    $('.loading').hide();
    $('.gallery').css("visibility","visible").hide().fadeIn();
}

// Determine the number of images wide in order to optimise viewing on mobile devices
function setNumberOfImagesWide() {
    var screenWidth = $(window).width();
    if (screenWidth <= 640) {
        imagesWide = 2;
    } else if (screenWidth <= 960) {
        imagesWide = 3;
    } else if (screenWidth <= 1178) {
        imagesWide = 4;
    } else {
        imagesWide = 5;
    }
}

// Fit thumbnails images to screen width
function thumbnailsFillScreen() {
    setNumberOfImagesWide();
    var images = $('#container');
    var itemCount = images.find('.item').length;
    for(i = imagesWide; i <= itemCount; i = i + imagesWide) {
        if(imagesWide > itemCount) {
            imagesWide = itemCount;
        }
        images.find('.item').slice(i - imagesWide, i).wrapAll('<div class="row">');
        console.log(i - imagesWide + " " + i);
    }
    fitThumbnailRowToContainerWidth();
}

function fitThumbnailRowToContainerWidth() {
    var containerWidth = $('.row:first-child').parent().width();
    $('.row').each(function() {
        var widthOfAllItems = 0;
        $(this).find('.item').each(function() {
            widthOfAllItems = widthOfAllItems + $(this).width();
        });
        var heightMultiplier = containerWidth / widthOfAllItems;
        $(this).find('img').each(function(){
           $(this).height(Math.floor($(this).height() * heightMultiplier)); 
        });
    });
}