// show current vieport size in browser
// ------------------------------------
$(document).ready(function(){

  var MEASUREMENTS_ID = 'measurements'; // abstracted-out for convenience in renaming

  $("body").append('<div id="'+MEASUREMENTS_ID+'"></div>');

  $("#"+MEASUREMENTS_ID).css({
    'position': 'fixed',
    'bottom': '0',
    'right': '0',
    'background-color': 'black',
    'color': 'white',
    'padding': '5px',
    'font-size': '11px',
    'opacity': '0.4',
    'z-index': '1000'
  });

  getDimensions = function(){
    var style = getComputedStyle(document.body);
    var VIEWPORT_NAME = style.getPropertyValue('--vp-name');
    var NAV_STATE = style.getPropertyValue('--navstate');
    return NAV_STATE + ' | ' + VIEWPORT_NAME + ' | ' + $(window).width() + ' (' + $(document).width() + ') × ' + $(window).height() + ' (' + $(document).height() + ')';
  }

  $("#"+MEASUREMENTS_ID).text(getDimensions());

  $(window).on("resize", function(){
    $("#"+MEASUREMENTS_ID).text(getDimensions());
  });
});
