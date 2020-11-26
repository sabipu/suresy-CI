jQuery(function() {
  initMobileNav();
});

function initMobileNav() {
  jQuery('.nav-opener').click(function(e) {
    e.preventDefault();
    jQuery('body').toggleClass('nav-active');
  });
}