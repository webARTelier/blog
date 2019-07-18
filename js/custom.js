// these are the TYPO3 FEE standard javascript functions
// you may add new functions for the current project and
// remove functions that are not used in current project



// namespace container
// -------------------
var feeJS = feeJS || {};



// concatenate vendor scripts
// --------------------------

// NOTE: by default ALL vendor scripts are included
// to keep the demo section running. For performance
// reasons exclude all scripts you do not need for
// current project!

//@prepros-append vendor/jquery-3.2.1.min.js



// -----------------------------------------------------------------------



// concatenate FEE partials
// ------------------------

// NOTE: by default ALL partials are included
// to keep the demo section running. For performance
// reasons exclude all scripts you do not need for
// current project!

//@prepros-append partials/_fee_func_common.js
//@prepros-append partials/_fee_func_forms.js



// -----------------------------------------------------------------------



// concatenate init
// ----------------
//@prepros-append partials/_fee_init.js
