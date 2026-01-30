/*
* Template Name: Unify - Responsive Bootstrap Template
* Author: @htmlstream
* Website: http://htmlstream.com
*/

var App = function() {
	// We extend jQuery by method hasAttr
	$.fn.hasAttr = function(name) {
	  return this.attr(name) !== undefined;
	};

  // Shadow Header
  function handleHeader() {
    jQuery(window).scroll(function() {
      if (jQuery(window).scrollTop() >= 100) {
        jQuery('nav.navbar').addClass('shadow');
      } else {
        jQuery('nav.navbar').removeClass('shadow');
      }
    });
  }

  return {
    init: function() {
      handleHeader();
    }

  };

}();

App.init();


