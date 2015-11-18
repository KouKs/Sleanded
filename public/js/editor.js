/* 
 * Editor script
 * 
 * vypadá to strašně, musím to přerobit...
 * 
 * @author Kouks
 */

var Memory = new Array();

$.fn.editor = function( ) {
    /**
     * hiding actual textare
     */
    $(this).hide();
    
    /**
     * 
     * @type jQuerypreparing preview container and menu
     */
    var container   = $(this).parent();
    container.preview( $(this).val() );
    container.menu();
};

$.fn.preview = function( content ) {
    if( content === '' ) {
        $(this).prepend(
            '<div class="editor-preview">'+
                '<section class="part focused">'+
                    '<div class="area">'+
                        '<div class="text-area"><p spellcheck="false" contenteditable="true"></p></div>'+
                    '</div>'+
                '</section>'+
            '</div>'        
        );
    } else {
        $(this).prepend(
            '<div class="editor-preview"></div>'        
        );
        $(".editor-preview").html( content );
        $(".editor-preview div.text-area").each( function( ) {
            $(this).attr("contentEditable","true");
        });
    }
};

$.fn.menu = function( textarea ) {
    
    $(this).prepend( 
        '<ul class="editor-menu"></ul>'
    );    

    $("ul.editor-menu").menuItem("+",           "","paragraph");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("H1",          "h2" , "heading");
    $("ul.editor-menu").menuItem("H2",          "h3" , "heading");
    $("ul.editor-menu").menuItem("H3",          "h4" , "heading");
    $("ul.editor-menu").menuItem("H4",          "h5" , "heading");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("black",       "<span class='black-text'>{text}</span>");
    $("ul.editor-menu").menuItem("red",         "<span class='red-text'>{text}</span>");
    $("ul.editor-menu").menuItem("dark-grey",   "<span class='grey-text'>{text}</span>");
    $("ul.editor-menu").menuItem("grey",        "<span class='grey-text'>{text}</span>");
    $("ul.editor-menu").menuItem("light-grey",  "<span class='light-grey-text'>{text}</span>");
    $("ul.editor-menu").menuItem("white",       "<span class='white-text'>{text}</span>");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("bold",        "<span class='bold'>{text}</span>");
    $("ul.editor-menu").menuItem("underline",   "<span class='underline'>{text}</span>");
    $("ul.editor-menu").menuItem("italic",      "<span class='italic'>{text}</span>");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("big",         "big-font"      , 'p-style' , /-font$/);
    $("ul.editor-menu").menuItem("medium",      "medium-font"   , 'p-style' , /-font$/);
    $("ul.editor-menu").menuItem("small",       "small-font"    , 'p-style' , /-font$/);
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("justify",     "justify-align" , 'p-style' , /-align$/);
    $("ul.editor-menu").menuItem("center",      "center-align"  , 'p-style' , /-align$/);
    $("ul.editor-menu").menuItem("left",        "left-align"    , 'p-style' , /-align$/);
    $("ul.editor-menu").menuItem("right",       "right-align"   , 'p-style' , /-align$/);
    $("ul.editor-menu").menuItem("indent",      "indent"        , 'p-style');
    $("ul.editor-menu").menuItem("margin",      "margin"        , 'p-style');
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("quote",       "quote-layout"  , 'p-style' , /-layout$/);
    $("ul.editor-menu").menuItem("code",        "code-layout"   , 'p-style' , /-layout$/);
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("remove formatting",'',"remove");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("+",           '<section class="part"><div class="area"><div class="text-area"><p spellcheck="false" contenteditable="true"></p></div></div></section>','section');
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("one",         "area" , "parts");
    $("ul.editor-menu").menuItem("two",         "half" , "parts");
    $("ul.editor-menu").menuItem("three",       "third" , "parts");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("red",         "red" ,      "bg");
    $("ul.editor-menu").menuItem("light-grey",  "grey" ,     "bg");
    $("ul.editor-menu").menuItem("grey",        "dark-grey" ,"bg");
    $("ul.editor-menu").menuItem("white",       "white" ,   "bg");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("image",       "" , "img");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("undo",        "" , "undo");
};

$.fn.menuItem = function( label , html , action , exclusive ) { 
    var editor = $(".editor-preview");
    /*
     * creating new li element
     */
    li = document.createElement('li');
    
    /*
     * label (in menu)
     */
    if( label === 'static' ) {
        $(li).addClass( label );
        $(this).append(li);
        return;        
    } else {
        $(li).html( label );
    }
    /*
     * preventing deslection
     * @param e event
     */
    $(li).mousedown( function(e) {
        e.preventDefault();
    });
    
    /**
     * click event
     */
    $(li).mouseup( function() {
        
        /*
         * getting selected area
         */
        var sel = selection( );
        switch( action ) {
            case 'section':
                
                /*
                 * new section
                 */
                $(editor).html( $(editor).html() + html);
                break;
                
            case 'parts':
                
                count = {
                    area : 1,
                    half : 2,
                    third: 3
                };
                
                el = $(".editor-preview .focused");
                
                $(el).children().each( function( ) {
                    $(this).remove();
                });
                
                for( i = 0 ; i < count[html] ; i++ ) {
                    $(el).append( 
                        '<div class="' + html + '"><div class="text-area"><p spellcheck="false" contenteditable="true"></p></div></div>'
                    );
                }
                break;
                
            case 'remove':
                
                /*
                 * removing formatting
                 */
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                el = $(sel.wrap).is("span") ? sel.wrap : sel.parent;
                while( !$(el).is("p") ) {
                    if( $(el).is("div.text-area")) return;
                    
                    text = $(el).text();
                    parent = $(el).parent();
                    $(el).remove();
                    el = parent;
                    $(el).html( $(el).html() + text );
                    
                }
                break;
                
            case 'bg':
                
                /*
                 * changing bg
                 */
                $(".editor-preview .focused").removeAttr('class').addClass('part focused ' + html);

                break;
                
            case 'img':
                
                /*
                 * adding img
                 */
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                $(".media-window-tab").fadeIn();
                $(".media-window-tab .grid").masonry().masonry("reloadItems");
                break;
                
            case 'undo':
                
                /*
                 * adding img
                 */
                if( Memory.length > 0 ) $(".editor-preview").html( Memory[ Memory.length - 1 ] );
                Memory.pop();

                break;

            case 'paragraph':
                
                /*
                 * adding a paragraph to the beggining of a section
                 */
                $(".editor-preview .focused .text-area").prepend(
                    '<p spellcheck="false" contenteditable="true"></p>'
                ).find("p").first().focus();
                
                
                break;    
            
            case 'p-style':
                
                /*
                 * changing class
                 */
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                el = $(sel.parent).is("p") ? sel.parent : sel.wrap;
                
                while( !$(el).parent().is(".text-area") ) {
                    el = el.parent();
                    if( $(el).is("body")) return;
                }
                
                if( $(el).hasClass( html ) ) {
                    $(el).removeClass( html );
                } else {
                    if( exclusive !== '' ) 
                        $(el).removeClassRegExp( exclusive );

                    $(el).addClass(html);
                }
                
                break;    
            
            case 'heading':
                
                /*
                 * adding heading
                 */
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                el = $(sel.parent).is("p") ? sel.parent : sel.wrap;

                $(el).changeElementType( html );

                
                break;

            default:
                
                /*
                 * default wrapping
                 */
                if(!sel || sel.start === sel.end || $(".editor-preview").has(sel.parent).length === 0 ) break;
                
                /*
                 * removing whitespaces
                 */
                $(sel.parent).html($(sel.parent).html().replace("&nbsp;"," ")); 
                
                $(sel.parent).html( 
                    $(sel.parent).html().substr( 0 , sel.start ) + 
                    html.replace("{text}", sel.text) +
                    $(sel.parent).html().substr( sel.end , $(sel.parent).html().length )
                );
        }
    });
    
    /*
     * adding to menu
     */
    $(this).append(li);
};

/**
 * changing element type
 * @param newType type of element
 */
$.fn.changeElementType = function(newType) {
    var attrs = {};

    $.each(this[0].attributes, function(idx, attr) {
        attrs[attr.nodeName] = attr.nodeValue;
    });

    this.replaceWith(function() {
        return $("<" + newType + "/>", attrs).append($(this).contents());
    });
};

/**
 * removing el classes based on regular expression
 * @param regexp regular expression
 */
$.fn.removeClassRegExp = function (regexp) {
    if(regexp && (typeof regexp==='string' || typeof regexp==='object')) {
        regexp = typeof regexp === 'string' ? regexp = new RegExp(regexp) : regexp;
        $(this).each(function () {
            $(this).removeClass(function(i,c) { 
                var classes = [];
                $.each(c.split(' '), function(i,c) {
                    if(regexp.test(c)) { classes.push(c); }
                });
                return classes.join(' ');
            });
        });
    }
    return this;
};

/**
 * adding a P
 */
$.fn.addParagraph = function() {
    el = $(this);
    while( !$(el).parent().is(".text-area") ) {
        $el = $(el).parent();
        if( $(el).is("body")) return;
    }
    $(el).after("<p spellcheck='false' contenteditable='true'></p>");
    $(el).next().focus();
};

/**
 * getting selection
 */
function selection( ) {
    sel = window.getSelection();
    if( sel !== undefined ) {
        start = sel.baseOffset < sel.extentOffset ? sel.baseOffset : sel.extentOffset;
        end   = sel.baseOffset > sel.extentOffset ? sel.baseOffset : sel.extentOffset;
        return {
            start  : start,
            end    : end,
            text   : sel.toString(),
            parent : $(sel.focusNode.parentElement),
            wrap   : $(sel.focusNode)
        };
    } else {
        return false;
    }
};

/**
 * removing section or creating new P
 * @param e event
 */
$(document).bind('keydown', function(e) {
    sel = selection( );
    if( ( e.which === 8 || e.which === 46 ) && sel) {
        el = $(sel.parent).is("p") ? sel.parent : sel.wrap;
        if( $(el).text() === '' && $(el).is("p") ) {
            e.preventDefault();
            if( $(el).parent().parent().parent().text() === '' ) {
                $(el).parent().parent().parent().remove();
                return;
            }
            if( $(el).siblings().length > 0 ) {
                if( $(el).prev() !== undefined ) 
                    $(el).prev().focus();
                else
                    $(el).next().focus();
                $(el).remove();
            }
        }
    }
    if( e.which === 13 && sel) {
        e.preventDefault();
        el = $(sel.parent).is("p") ? sel.parent : sel.wrap;
        $(el).addParagraph();
        return false;
    }
});

/**
 * memory
 * @param e event
 */
$(document).bind('keyup', function(e) {
    if( $(".editor-preview").has( e.target) !== 0 ) {
        Memory.push( $(".editor-preview").html() );
    }
});/*
$(document).bind('click', function(e) {
    if( $(".editor-menu").has( e.target ) !== 0 ) {
        Memory.push( $(".editor-preview").html() );
    }
});*/



/**
 * copying content to textarea on submit
 * @param e event
 */
$(document).submit(function(e) { 
    $(".editor-preview p").each( function( ) {
        $(this).removeAttr("contenteditable");
    });
    $(".editor").val($(".editor-preview").html());
});

/**
 * choosing image
 * @param e event
 */
$(document).bind('click', function(e) {
   if( $(e.target).is(".media-window-tab img") ) {
       
       sel = selection();
       if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) return;
       
       /*
        * removing whitespaces
        */ 
       $(sel.wrap).html($(sel.wrap).html().replace("&nbsp;"," "));   

       /*
        * adding img
        */ 
       $(sel.wrap).html( 
           $(sel.wrap).html().substr( 0 , sel.start ) + 
           '<img class="shadowed" src="' + $(e.target).attr("src") + '" />' + 
           $(sel.wrap).html().substr( sel.end , $(sel.wrap).html().length )
       );
       $(".media-window-tab").fadeOut();
   }
   if( $(".editor-preview section").has( e.target ).length > 0 || 
       $(e.target).is(".editor-preview section") ) {
       $(".editor-preview section").each( function( ) {
           $(this).removeClass("focused");
       });
       $(e.target).closest("section").addClass("focused");
   } 
});