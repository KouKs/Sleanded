
var _URL = "/sleanded/public/admin/";

/* 
 * Page loading
 */
$(document).ready( function() {
    
    /* loading with scrolling */
    $(".area").showContent( );
    $(".progress-bar").showBar( );
    $(this).scroll( function() {
        $(".area").showContent( );
    });    
    
    /* smooth scrolling */
    $("ul.timeline").niceScroll({scrollspeed: 65});
    $("#port").niceScroll("#bar",{scrollspeed: 65});
    
    /*
     * Editor
     */
    $(".editor").editor();
    
    /*
     * Menu
     */
    $("#primary > a").hover( function( ) {
        $(this).next().css({top: $(this).offset().top});
    });
    $("#primary > nav").hover( function( ) {
        $(this).prev().css({ 'background': "#333" , 'border-color': "#333"});
    }, function() {
        $(this).prev().css({ 'background': "" , 'border-color': ""});
    });
    
    /*
     * Media tab
     */
    if( $("input#img").val() !== '' ) {
        $(".media-image-holder").attr( "src" , _URL + "../" + $("input#img").val()).show();
    }
    $(".media-choose-image").click(function(e) {
        e.preventDefault();
        $(".media-window").fadeIn();
        $(".grid").masonry('reloadItems').masonry();
    });
    $(".media-window img").click(function() {
        $(this).parent().parent().fadeOut();
        $("input#img").val( $(this).data('url') );
        $(".media-image-holder").attr( "src" , $(this).attr("src")).show();
    });
    /*
    $(this).click(function(e) {
        if( $('.media-window').css("opacity") !== 1 || $(e.target).closest('.media-window').length !== 0 ) return false;
        $('.media-window').fadeOut();
    });
     */
    /*
     * Dropzone
     */
    $("#dropzone").dropzone({ 
        url: _URL + "media",
        paramName: "file",
        thumbnailWidth: 500,
        thumbnailHeight: null,
        maxFilesize: 4,
        parallelUploads: 1,
        maxFiles: 25,
        autoProcessQueue: true,
        acceptedFiles: 'image/*',
        
        accept: function(file, done) {
            $(".dz-default").hide();
            done();
        },
        processing: function(file) {
            $( file.previewElement ).addClass("dz-processing");
        },
        sending: function( ) {
            $(".dz-processing .dz-progress").show();
        },
        totaluploadprogress: function( progress ) {
            $(".dz-processing .dz-progress span").css({width: 0});
            $(".dz-processing .dz-progress span").animate({width: progress + '%'},800);
        },
        complete: function( file ) {
            $(".dz-progress").fadeOut();
            var img = $( file.previewElement ).find("img");
            $( file.previewElement ).removeClass("dz-success").removeClass("dz-processing");
            $(img).css({'background-color': 'green'});
            $(".grid").prepend(
                '<div class="third grid-item"><div class="text-area">' +
                    '<img class="bordered" src="' + $(img).attr("src") + '" />' +
                    '<div class="desc">' +
                        '<p style="float: left" class="medium white-text">' + file.name + '</p>' +
                    '</div>' +
                '</div></div>'
            );
            window.setTimeout( function( ) { $(".grid").masonry('reloadItems').masonry(); } , 300 );
        }
    });

    
    /*
     * profile image loading error
     */
    $("#profile-image").error( function() {
        $(this).parent().html('<h5 class="dark-grey-text">No image supplied yet</h5>');
    });
});

