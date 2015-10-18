/* 
 * parallax images
 */



$(document).ready( function() { 
    $('.img-header').imageScroll({
        image: null,
        imageAttribute: 'image',
        container: $('header'),
        windowObject: $(window),
        speed: 0.2,
        coverRatio: 0.75,
        holderClass: 'img-holder',
        holderMinHeight: 1266,
        holderMaxHeight: null,
        extraHeight: 0,
        mediaWidth: 1600,
        mediaHeight: 1266,
        parallax: true,
        touch: false
    });
    
    $('.img-why-us').imageScroll({
        image: null,
        imageAttribute: 'image',
        container: $("#why-us"),
        windowObject: $(window),
        speed: 0.05,
        coverRatio: 0.75,
        holderClass: 'img-holder',
        holderMinHeight: 1000,
        holderMaxHeight: null,
        extraHeight: 0,
        mediaWidth: 2000,
        mediaHeight: 1000,
        parallax: true,
        touch: false
    });
    
    $('.img-blog').imageScroll({
        image: null,
        imageAttribute: 'image',
        container: $("#blog"),
        windowObject: $(window),
        speed: 0.05,
        coverRatio: 0.75,
        holderClass: 'img-holder',
        holderMinHeight: 1000,
        holderMaxHeight: null,
        extraHeight: 0,
        mediaWidth: 2000,
        mediaHeight: 1000,
        parallax: true,
        touch: false
    });
});