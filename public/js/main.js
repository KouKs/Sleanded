/* 
 * Variables
 */

var _URL = "/sleanded/public/";

/* 
 * Page loading
 */
$(document).ready( function() {

    window.setTimeout( function( ){
        $(".message").fadeOut();
    } , 4000 );
    
    $(window).load(function() {
        $('.grid').masonry({
            itemSelector: '.grid-item'
        });
    });
});

/*
 * Functions
 */
$.fn.showContent = function( ) {   
    this.each( function( ) {
        if( $(this).css("opacity") < 1 && $(window).scrollTop() > $(this).offset().top - window.innerHeight ) {
            $(this).animate({opacity: 1});
            return;
        }
    });
};

$.fn.showBar = function( ) {  
    this.each( function( ) {
        if( $(this).children().first().css("width") !== 0 && $(window).scrollTop() > $(this).offset().top - window.innerHeight ) {
            $(this).children().first().animate({width: $(this).data("percent")},1500);
            return;
        }
    });    
};

/* 
 * Ajax function
 */

function ajax( controller , action , id , el , pass ) {
    if( pass || confirm("Do you really wanna do this?") ) {
        $.post( _URL + controller + '/' + action  + '/' + id , {} , function( ) {
            //alert("Successfully sent!");
            if( el !== undefined ) {
                $(el).fadeOut( "slow" , function( ) { 
                    $(this).remove();
                    $(".grid").masonry('reloadItems').masonry();
                });
            }
        });
    } else {
        return false;
    }
}