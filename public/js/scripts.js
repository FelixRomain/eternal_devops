(function($) {
    "use strict";
    
      $.fn.andSelf = function() {
        return this.addBack.apply(this, arguments);
      }
      /*
      |=================
      | fancybox
      |================
      */
   
        $("[data-fancybox]").fancybox({});
        
        
      /*
      |===============
      | WOW ANIMATION
      |==================
      */
          var wow = new WOW({
            mobile: false  // trigger animations on mobile devices (default is true)
        });
        wow.init();
        
// Use the function
window.addEventListener('scroll', onScroll)
      
  
      // Smooth Scroll
          $(function() {
            $('a[href*=#]:not([href=#])').click(function() {
              if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                  $('html,body').animate({
                    scrollTop: target.offset().top
                  }, 600);
                  return false;
                }
              }
            });
          });
      
  });
  