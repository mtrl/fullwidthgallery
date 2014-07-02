var imagesWide = 5;
    
$(window).load(function() {
    $(".fancybox").fancybox();
    thumbnailsFillScreen();
});

// Fit thumbnails images to screen width
function thumbnailsFillScreen() {
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