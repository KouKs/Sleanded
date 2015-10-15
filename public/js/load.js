/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
$(document).ready( function( ) {
    $("#container").fadeIn("slow",function( ) {
        $("#banner-left").animate( { width: '150px'} );
        $("#banner-right").animate( { width: '150px'} );
    });

    $('.leave').leavePage();
});
*/

/* 
* Function to animate leaving a page
*/
$.fn.leavePage = function() {   
    
  this.click(function(event){

    event.preventDefault();
    linkLocation = this.href === undefined ? this.form.action : this.href;

    $("#banner-left").animate( { width: '0px'} );
    $("#banner-right").animate( { width: '0px'} );
    $("#container").fadeOut("slow",function(){
      window.location = linkLocation;
    });      
  }); 
};


$(document).ready( function() { 
    $('.img-header').imageScroll({
        image: null,
        imageAttribute: 'image',
        container: $('header'),
        windowObject: $(window),
        speed: 0.05,
        coverRatio: 0.75,
        holderClass: 'img-holder',
        holderMinHeight: 1000,
        holderMaxHeight: null,
        extraHeight: 0,
        mediaWidth: 1280,
        mediaHeight: 1024,
        parallax: true,
        touch: false
    });
    /*
    $('.img-ref').imageScroll({
        image: null,
        imageAttribute: 'image',
        container: $('.img-ref').parent(),
        windowObject: $(window),
        speed: 0.05,
        coverRatio: 0.75,
        holderClass: 'img-holder',
        holderMinHeight: 200,
        holderMaxHeight: null,
        extraHeight: 0,
        mediaWidth: 1280,
        mediaHeight: 1024,
        parallax: true,
        touch: false
    });*/
    
    /* side menu */
    $("#side a").each( function( ) {
        $(this).css({color:"transparent",fontSize: "0px"});
    });
    $("#side").hover( function() {
        $("#side a").each( function( ) {
            $(this).css({color:"#aaa",fontSize: "14px"});
        });
    },function( ){
        $("#side a").each( function( ) {
            $(this).css({color:"transparent",fontSize: "0px"});
        });
    });
});