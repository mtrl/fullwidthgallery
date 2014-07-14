var imagesWide;

$(document).ready(function(){
    animateLoadingElipsis();
    
    $("img.lazy").lazyload();
    
    thumbnailsFillScreen();
    $(window).resize(function(){
       thumbnailsFillScreen();
    });
    
    $('#container').magnificPopup({
        type:'image',
        delegate: 'a',
        gallery:{
            enabled:true
            },
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
        imagesWide = 4;
    }
}

// Fit thumbnails images to screen width
function thumbnailsFillScreen() {
    setNumberOfImagesWide();
    var images = $('#container');
    var itemCount = images.find('.item').length;
    for(i = imagesWide; i <= (itemCount + 2); i = i + imagesWide) {
        if(imagesWide > itemCount) {
            imagesWide = itemCount;
        }
        images.find('.item').slice(i - imagesWide, i).wrapAll('<div class="row">');
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
           $(this).height(Math.ceil($(this).height() * heightMultiplier));
           $(this).width(Math.ceil($(this).width() * heightMultiplier)); 
        });
    });
}

var loadingDotNumber = 4;
var loadingDotCount = 0;
var loadingDotSpeed = 400;
function animateLoadingElipsis() {
    var dotText = "";
    for(i = 0; i < loadingDotCount; i = i + 1){
        dotText = dotText + ' .';
    }
    loadingDotCount = loadingDotCount + 1;
    $('.loading .elipsis').text(dotText);
    if(loadingDotCount == loadingDotNumber) {
        loadingDotCount = 0;
    }
    setTimeout(animateLoadingElipsis, loadingDotSpeed);
}
