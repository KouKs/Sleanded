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
var _URL = "/sleanded/public/";

/* 
* Function to animate leaving a page
*/
$.fn.leavePage = function() {   
    /*
    this.click(function(event){

        event.preventDefault();
        linkLocation = this.href === undefined ? this.form.action : this.href;
        $("#page").fadeOut();
        $("#redirect-right").load( linkLocation , function( ) {   
            $(this).show().animate({width:"100%"});
        });
    }); */
};


$(document).ready( function() {
    
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
    
    /* loading */
    $("#top-bar").fadeIn("slow",function() {
        $("#motto").fadeIn("slow",function() {
            $("#buttons")./*fadeIn().*/animate({top:"40%",opacity:1},"slow");
        });
    });
    
    $(this).scroll( function() {
        if( $(window).scrollTop() > 80 ) {
            if( $("#fixed-bar").css("display") === "none" ) {
                $("#fixed-bar").fadeIn();
                $("#fixed-bar").append($("#top-bar"));
            }
        } else {
            if( $("#top-bar").css("display") !== "none" ) {
                    $("header").append($("#top-bar"));
                $("#fixed-bar").stop(true,false).fadeOut( );
            }
        }
        
    });
    
    $("html").niceScroll({scrollspeed: 65});
    $("#port").niceScroll("#bar",{scrollspeed: 65});
    //$('.leave').leavePage();
    
    $(".area").showContent( );
    $(this).scroll( function() {
        $(".area").showContent( );
    });
    
});

$.fn.showContent = function( ) {   
    this.each( function( ) {
        if( $(this).css("opacity") < 1 && $(window).scrollTop() > $(this).offset().top - 650 ) {
            $(this).animate({opacity: 1});
            return;
        }
    });
};