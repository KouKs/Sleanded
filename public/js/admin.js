
var _URL = "/sleanded/public/admin/";

/* 
 * Page loading
 */
$(document).ready( function() {
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
    $(".media-choose-image").click(function(e) {
        e.preventDefault();
        $(".media-window").fadeIn();
    });
    $(".media-window img").click(function() {
        $(this).parent().fadeOut();
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
    $("#dropzone").dropzone({ url: _URL + "media"});
    
    Dropzone.options.dropzone = {
        paramName: "file[]",
        maxFilesize: 4,
        uploadMultiple: true,
        parallelUploads: 25,
        maxFiles: 25,
        autoProcessQueue: true,
        acceptedFiles: 'image/*',
        accept: function(file, done) {
            done();
        }
      };
    
    $("#dropzone").on("complete", function(file) {
       $("#dropzone").removeFile(file);
       alert("xD");
    });
});

