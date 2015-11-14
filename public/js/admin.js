
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
    $(".media-window img").click(function() {
        $(this).parent().fadeOut();
    });
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

