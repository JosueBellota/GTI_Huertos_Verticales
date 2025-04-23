var currentIndex = 0;
var thumbnails = document.querySelectorAll('.thumbnail');
var mainImage = document.getElementById('mainImg');

function changeImage(element, newImageSrc) {

    mainImage.src = newImageSrc;

    thumbnails.forEach(function(thumbnail) {
        thumbnail.classList.remove('selected');
    });

    element.classList.add('selected');

    currentIndex = Array.from(thumbnails).indexOf(element);
}

function resetImage(element) {

    
    mainImage.src = 'img/huerto-5.jpg'; // Default image source
    thumbnails.forEach(function(thumbnail) {
        thumbnail.classList.remove('selected');
    });
    element.classList.add('selected');
    currentIndex = Array.from(thumbnails).indexOf(element);


}

function nextImage() {


    currentIndex = (currentIndex + 1) % thumbnails.length;
    var nextThumbnail = thumbnails[currentIndex];
    changeImage(nextThumbnail, nextThumbnail.src);

}

function prevImage() {

    currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
    var prevThumbnail = thumbnails[currentIndex];
    changeImage(prevThumbnail, prevThumbnail.src);

}


window.onload = function() {
    
    var screenWidth = window.innerWidth;
    var sliderArrows = document.querySelector('.slider-arrows');
    if (screenWidth <= 768) {
        sliderArrows.style.display = 'flex';
    }

};


window.addEventListener('resize', function() {

    var screenWidth = window.innerWidth;
    var sliderArrows = document.querySelector('.slider-arrows');
    if (screenWidth <= 768) {
        sliderArrows.style.display = 'flex';
    } else {
        sliderArrows.style.display = 'none';
    }

});
