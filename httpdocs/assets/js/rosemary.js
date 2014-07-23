$(document).ready(function(){
    animateLoadingElipsis();
    showGallery();
});


function activateMagnific() {
    $('#container').magnificPopup({
        preloader: true,
        type:'image',
        delegate: 'a',
        gallery:{
            enabled:true
        },
        callbacks: {
            open: function() {
                // Bind to nore options links
                activateMoreOptions();
                // In this context the 'this' item isnt a jQuery object so we have to create one
                var anchorHash = $(this.st.el.context).attr('id');
                window.scrollTo(0,0);
                window.location.hash = anchorHash;
            },
            close: function() {
                event.preventDefault();
                window.location.hash = '';
            }
        }
    });
}

function showGallery() {
    $("img.lazy").lazyload();
    activateMagnific();
    thumbnailsFillScreen();
    
    loadDirectLink();
    
    $('.loading').hide();
    $('.gallery').css("visibility","visible").hide().fadeIn();
}

function loadDirectLink() {
    if(window.location.hash) {
        $(window.location.hash).click();
    }
}

function activateMoreOptions() {
    $('.show-more-options').click(function() {
        $(this).siblings('.more-options').toggle();
        window.location.hash = '#more-options';
        $(this).siblings('.more-options').find('.direct-link').on('click', function() {
            $(this).select();
        });
    });
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
    // Resize if the window is resized
    $(window).resize(function(){
       thumbnailsFillScreen();
    });

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
