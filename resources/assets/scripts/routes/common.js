import 'hiraku';
import 'slick-carousel';
import 'remodal';

export default {
  init() {
    // JavaScript to be fired on all pages

    // hiraku-option
    $(".js-offcanvas").hiraku({
      btn: ".js-offcanvas-btn",
      direction: "right",
    });

    // toogle
    $(".js-toggle").click(function () {
      $(this).next(".js-toggle__content").toggle("fast");
    });

  // smooth scroll
  $(function(){
     $('a[href^=#]').click(function() {
        var speed = 400; // ミリ秒
        var href= $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $('body,html').animate({scrollTop:position}, speed, 'swing');
        return false;
     });
  });


  // slick-carousel

  $('.multiple-items').slick({
    centerMode: true,
    centerPadding: '25%',
    infinite: true,
    slidesToShow: 1,
    autoplay: true,
    autoplaySpeed: 6000,
    responsive: [{
      breakpoint: 768,
      settings: {
        arrows: false, // 前後の矢印非表示
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3,
        autoplay: true,
        autoplaySpeed: 3000,
      },
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '0',
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 3000,
      },
    }],
  });


  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
