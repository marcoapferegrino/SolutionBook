/**
 * Created by luisknight on 5/11/15.
 */
$(document).ready(function() {

    var dir = '/wallpapers/';
    var images = ['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg', 'image5.jpg','img2.jpg','img3.jpg','img4.jpg','img6.jpg'];
    $('body').css('background-image', 'url('+dir+images[Math.floor(Math.random()*images.length)] +')');
    $('body').css('background-size',' 100% 100%');



});
//document.getElementById(body).style.backgroundImage = 'url("image1.jpg")';
//$('body').css({'background-image': 'url(' + images[Math.floor(Math.random() *      images.length)] + ')'});

//$('body').css('background-image', 'url("image1.jpg")');
//$("body").css("background-image", "url(image"+ Math.floor(Math.random()*3) + ".jpg)");