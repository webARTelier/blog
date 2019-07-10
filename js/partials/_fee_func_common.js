


// COMMON FRAMEWORK FUNCTIONS
// ==========================



// debounce
// --------
feeJS.debounce = function(func, wait) {
  var timeout, args, context, timestamp;

  return function() {
    context = this;
    args = [].slice.call(arguments, 0);
    timestamp = new Date();

    var later = function() {
      var last = (new Date()) - timestamp;

      if(last < wait) {
        timeout = setTimeout(later, wait - last);

      } else {
        timeout = null;
        func.apply(context, args);
      }
    };

    if(!timeout) {
      timeout = setTimeout(later, wait);
    }
  }
};



// -----------------------------------------------------------------------



// smooth scrolling to top
// -----------------------
feeJS.smoothScrollToTop = function() {
  $("html, body").animate({ scrollTop: 0 }, 600);
  return false;
}



// -----------------------------------------------------------------------



// smooth scrolling to anchor
// --------------------------
feeJS.smoothScrollToAnchor = function(target) {
  if(location.pathname.replace(/^\//,'') == target.pathname.replace(/^\//,'') && location.hostname == target.hostname) {

    var scrolltarget = $(target.hash);
    var fixedOffset = 0;

    scrolltarget = scrolltarget.length? scrolltarget : $('[name=' + target.hash.slice(1) +']');
    if (scrolltarget.length) {
      $('html, body').animate({
        scrollTop: scrolltarget.offset().top - fixedOffset
      }, 1000);
      return false;
    }
  }
}



// -----------------------------------------------------------------------



// show element below given scroll position
// ----------------------------------------
feeJS.showAtScroll = function(target, scrollPosition) {
  var scrolled = $(window).scrollTop();

  // show below given scroll position ...
  // ------------------------------------
  if (scrolled >= scrollPosition) {
    $(target).addClass('is-visible');
  }

  // ... and hide above given scroll position
  // ----------------------------------------
  else {
    $(target).removeClass('is-visible');
  }
}



// -----------------------------------------------------------------------



// prepare element with defined aspect ratio
// (YouTube/Vimeo iframes, ...) for responsive resizing
// NOTE: elements to be resized must consist of
// - element itself (default markup: js-addAspectRatio")
// - responsive container (default markup: js-responsiveContainer")
// ----------------------------------------------------------------
feeJS.addAspectRatio = function(target) {

  // figure out and save aspect ratio ...
  // ------------------------------------
  $(target).attr('data-aspectratio', $(target).height() / $(target).width())

  // ... update element status ...
  // -----------------------------
    .removeClass('js-addAspectRatio')
    .addClass('js-resizeAspectRatio')

  // ... and remove the hard coded width/height
  // ------------------------------------------
    .removeAttr('height')
    .removeAttr('width');
}



// -----------------------------------------------------------------------



// resize prepared element with defined aspect ratio
// (YouTube/Vimeo iframes, ...) for responsive resizing
// NOTE: elements to be resized must consist of
// - element itself (default markup: js-addAspectRatio")
// - responsive container (default markup: js-responsiveContainer")
// ----------------------------------------------------------------
feeJS.resizeAspectRatio = function(target) {

  // get width of parent responsive container
  // ----------------------------------------
  var newWidth = $(target).closest('.js-responsiveContainer').width();

  // resize element according to its aspect ratio
  // --------------------------------------------
  $(target).width(newWidth).height(newWidth * $(target).data('aspectratio'));
}



// -----------------------------------------------------------------------



// toggle accordion content
// ------------------------
feeJS.toggleAccordion = function(target, openMultiple) {

  openMultiple = openMultiple || false;

  // close other opened items?
  // -------------------------
  if(openMultiple == false) {
    $('.js-toggleAccordion')
      .not(target)
      .closest('.js-accordion')
      .removeClass('is-open')
      .find('.js-accordionContent')
      .hide('fast');
  }

  $(target)
    .closest('.js-accordion')
    .find('.js-accordionContent')
    .slideToggle('fast');

  $(target)
    .closest('.js-accordion')
    .toggleClass('is-open');
}



// -----------------------------------------------------------------------



// toggle tab content
// ------------------
feeJS.toggleTab = function(target) {

  var tabTarget = $(target).attr('data-tabtarget');

  $('.js-chooseTab, .js-tabContent').removeClass('is-active');
  $(target).addClass('is-active');
  $(tabTarget).addClass('is-active');
}



// -----------------------------------------------------------------------



// open modals
// -----------
feeJS.openModal = function(target) {

  // prevent page in background from scrolling
  // -----------------------------------------
  $('body').css('overflow-y', 'hidden');

  // close all other modals
  // ----------------------
  $('.js-modal').removeClass('is-visible');

  // open modal and page overlay
  // ---------------------------
  $('.js-modal' +  target).addClass('is-visible');
  $('.js-pageOverlay.js-closeModal').addClass('is-visible');
}



// -----------------------------------------------------------------------



// close modals
// ------------
feeJS.closeModal = function() {

  // let page in background scroll again
  // -----------------------------------
  $('body').css('overflow-y', '');

  // close modal and overlay
  // -----------------------
  $('.js-modal').removeClass('is-visible');
  $('.js-pageOverlay').removeClass('is-visible');
}



// -----------------------------------------------------------------------



// switch modals
// -------------
feeJS.switchModal = function(target) {
  feeJS.closeModal();
  feeJS.openModal(target);
}
