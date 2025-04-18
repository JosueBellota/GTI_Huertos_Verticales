var currentIndex = 0;
var thumbnails = document.querySelectorAll('.thumbnail');
var mainImage = document.getElementById('mainImg');

function changeImage(element, newImageSrc) {
    mainImage.src = newImageSrc;

    // Remove 'selected' class from all thumbnails
    thumbnails.forEach(function(thumbnail) {
        thumbnail.classList.remove('selected');
    });

    // Add 'selected' class to the clicked thumbnail
    element.classList.add('selected');

    // Update current index
    currentIndex = Array.from(thumbnails).indexOf(element);
}

function resetImage(element) {
    mainImage.src = 'img/huerto-5.jpg'; // Default image source

    // Remove 'selected' class from all thumbnails
    thumbnails.forEach(function(thumbnail) {
        thumbnail.classList.remove('selected');
    });

    // Add 'selected' class to the reset thumbnail
    element.classList.add('selected');

    // Reset current index to default image
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

// Show slider arrows on mobile screens
window.onload = function() {
    var screenWidth = window.innerWidth;
    var sliderArrows = document.querySelector('.slider-arrows');
    if (screenWidth <= 768) {
        sliderArrows.style.display = 'flex';
    }
};

// Listen for window resize to show/hide slider arrows
window.addEventListener('resize', function() {
    var screenWidth = window.innerWidth;
    var sliderArrows = document.querySelector('.slider-arrows');
    if (screenWidth <= 768) {
        sliderArrows.style.display = 'flex';
    } else {
        sliderArrows.style.display = 'none';
    }
});