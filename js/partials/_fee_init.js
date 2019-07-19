


// INIT REQUIRED FUNCTIONS
// =======================



// get css breakpoints
// -------------------
var bpTiny = parseInt(getComputedStyle(document.body).getPropertyValue('--bp-tiny'));
var bpSmall = parseInt(getComputedStyle(document.body).getPropertyValue('--bp-small'));
var bpMedium = parseInt(getComputedStyle(document.body).getPropertyValue('--bp-medium'));
var bpLarge = parseInt(getComputedStyle(document.body).getPropertyValue('--bp-large'));



// PART I: things to be done on document.ready
// ===========================================
$(document).ready(function() {



  // smooth scrolling to top
  // -----------------------
  $('html').on('click', '.js-scrollToTop', function() {
    feeJS.smoothScrollToTop();
  });



  // smooth scrolling to anchor
  // --------------------------
  $('a[href*="#"]')
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
    feeJS.smoothScrollToAnchor(this);
  });



  // toggle tabs
  // -----------
  $('html').on('click', '.js-chooseTab', function() {
    feeJS.toggleTab(this);
  });



  // toggle accordion items
  // NOTE: optional parameter 'openMultiple' can be used
  // to prevent closing open item(s) when clicking on closed item
  // ------------------------------------------------------------
  $('html').on('click', '.js-toggleAccordion', function() {
    feeJS.toggleAccordion(this, 'openMulitiple');
  });



  // prepare resizing for elements with width/height attribute
  // like vimeo/youtube videos or google map iframes
  // ---------------------------------------------------------
  $('.js-addAspectRatio').each(function() {
    feeJS.addAspectRatio(this);
  });



  // prepare forms
  // -------------
  $('form').each(function() {
    feeJS.preventSubmitInvalid(this);
  });

  $('.js-submit').click(function() {
    feeJS.markSubmitted(this);
  });

  $('.js-autogrow').each(function() {
    feeJS.autoGrow(this);
  });

  $('html').on('keyup', '.js-autogrow', function() {
    feeJS.autoGrow(this);
  });

  $('html').on('click', '.js-setDate', function() {
    feeJS.setDate();
  });



  // shift comment form for replies
  // ------------------------------
  $('html').on('click', '.js-shiftForm', function() {
    feeJS.shiftForm(this);
  });

  // shift comment form back to original position
  // --------------------------------------------
  $('html').on('click', '.js-shiftbackForm', function() {
    feeJS.shiftbackForm();
  });



  // open modals
  // -----------
  $('html').on('click', '.js-openModal', function() {
    feeJS.openModal($(this).attr('data-target'));
  });



  // close modals
  // ------------
  $('html').on('click', '.js-closeModal', function() {
    feeJS.closeModal();
  });



  // switch modals
  // -------------
  $('html').on('click', '.js-switchModal', function() {
    feeJS.switchModal($(this).attr('data-target'));
  });



  // =======================================================================



  // PART II: things to be done on resize
  // ====================================
  $(window).resize(feeJS.debounce(function() {



    // responsive resizing for elements with width/height attribute
    // like vimeo/youtube videos or google map iframes
    // ------------------------------------------------------------
    $('.js-resizeAspectRatio').each(function() {
      feeJS.resizeAspectRatio(this);
    });



  }, 100));



  // =======================================================================



  // PART III: things to be done on scroll
  // =====================================
  $(window).scroll(feeJS.debounce(function() {



    // show to top element when scrolling down
    // ---------------------------------------
    feeJS.showAtScroll('.c-totop', '150');



  }, 100));



  // =======================================================================



  // PART IV: trigger 'resize' and 'scroll' on document ready
  // so functions that need to be executed on document ready
  // AND on resize/scroll only need to be called on resize/scroll
  // ------------------------------------------------------------
  $(window).trigger('resize');
  $(window).trigger('scroll');

  // rangeslider: trigger 'change' to place value bubble
  // ---------------------------------------------------
  $('.js-rangeslider').each(function() {
    $(this).trigger('change');
  })



});

