var imagesWide;

$(document).ready(function(){
    animateLoadingElipsis();
});

$(window).load(function() {
    $(document).ready(function() {
        $('#container').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery:{
                enabled:true
                },
            /*retina: {
                //ratio: 2, // Increase this number to enable retina image support.
                ratio: function() { return window.devicePixelRatio === 1.5 ? 1.5 : 2  },
                // Image in popup will be scaled down by this number.
                // Option can also be a function which should return a number (in case you support multiple ratios). For example:
                // ratio: function() { return window.devicePixelRatio === 1.5 ? 1.5 : 2  }
                replaceSrc: function(item, ratio) {
                  return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
                } // function that changes image source
              }*/
            });
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
