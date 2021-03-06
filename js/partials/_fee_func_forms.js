


// FORM HANDLING FUNCTIONS
// =======================

// check for html5 validation
// --------------------------
feeJS.hasHtml5Validation = function() {
  return typeof document.createElement('input').checkValidity === 'function';
}



// -----------------------------------------------------------------------



// mark form as submitted
// ----------------------
feeJS.markSubmitted = function(target) {
  $(target).closest('.js-form').addClass('is-submitted');
}



// -----------------------------------------------------------------------



// stop iOS safari from submitting invalid form
// --------------------------------------------
feeJS.preventSubmitInvalid = function(target) {

  if(feeJS.hasHtml5Validation()) {
    $(target).submit(function (e) {
      if(!this.checkValidity()) {
        e.preventDefault();
      }
    })
  }
}



// -----------------------------------------------------------------------



// textarea auto height
// --------------------
feeJS.autoGrow = function(target) {
  target.style.height = (target.scrollHeight)+"px";
}



// -----------------------------------------------------------------------



// set mysql datetime timestamp
// ----------------------------
feeJS.setDate = function() {
  var d = new Date();
  $('.js-date').val(new Date().toISOString().split('T')[0]+' '+d.toTimeString().split(' ')[0]);
}



// -----------------------------------------------------------------------



// shift comment form for replies
// ------------------------------
feeJS.shiftForm = function(target) {

  // shift form
  // ----------
  $('.js-shiftableForm').detach().appendTo($(target).closest('.js-shiftFormAnchor'));

  // show 'cancel reply' button
  // -------------------------
  $('.js-shiftbackForm').removeClass('is-hidden');

  // set 'replyTo' value
  // -------------------
  $('#input_replyTo').val($(target).closest('.c-comment').data('id'));
}



// -----------------------------------------------------------------------



// shift comment form back to original position
// --------------------------------------------
feeJS.shiftbackForm = function() {

  // shift form back to original position
  // ------------------------------------
  $('.js-shiftableForm').detach().appendTo('.js-shiftFormHome');

  // remove 'cancel reply' button
  // ----------------------------
  $('.js-shiftbackForm').addClass('is-hidden');

  // reset 'replyTo' value
  // ---------------------
  $('#input_replyTo').val('');
}
