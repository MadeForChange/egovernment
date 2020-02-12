<?php
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
<style>.carousel .item {
  padding-bottom: 56.25%;
  background-size: cover;
}
.carousel .item:nth-child(1) {
  background-image: url('https://via.placeholder.com/1280x720?text=Slide 1');
}
.carousel .item:nth-child(2) {
  background-image: url('https://via.placeholder.com/1280x720?text=Slide 2');
}
.carousel .item:nth-child(3) {
  background-image: url('https://via.placeholder.com/1280x720?text=Slide 3');
}
.carousel.vertical .carousel-inner > .item {
  -webkit-transition: 0.6s ease-in-out top;
  -o-transition: 0.6s ease-in-out top;
  transition: 0.6s ease-in-out top;
}
@media all and (transform-3d), (-webkit-transform-3d) {
  .carousel.vertical .carousel-inner > .item {
    -webkit-transition: -webkit-transform 0.6s ease-in-out;
    -ms-transition: -ms-transform 0.6s ease-in-out;
    -o-transition: -o-transform 0.6s ease-in-out;
    transition: transform 0.6s ease-in-out;
    -ms-backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -ms-perspective: 1000;
    -webkit-perspective: 1000;
    perspective: 1000;
  }
  .carousel.vertical .carousel-inner > .item.next,
  .carousel.vertical .carousel-inner > .item.active.right {
    top: 0;
    -ms-transform: translate3d(0, 100%, 0);
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0);
  }
  .carousel.vertical .carousel-inner > .item.prev,
  .carousel.vertical .carousel-inner > .item.active.left {
    top: 0;
    -ms-transform: translate3d(0, -100%, 0);
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  .carousel.vertical .carousel-inner > .item.next.left,
  .carousel.vertical .carousel-inner > .item.prev.right,
  .carousel.vertical .carousel-inner > .item.active {
    top: 0;
    -ms-transform: translate3d(0, 0, 0);
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }
}
.carousel.vertical .carousel-inner > .active {
  top: 0;
}
.carousel.vertical .carousel-inner > .next,
.carousel.vertical .carousel-inner > .prev {
  top: 0;
  height: 100%;
  width: 100%;
}
.carousel.vertical .carousel-inner > .next {
  left: 0;
  top: 100%;
}
.carousel.vertical .carousel-inner > .prev {
  left: 0;
  top: -100%;
}
.carousel.vertical .carousel-inner > .next.left,
.carousel.vertical .carousel-inner > .prev.right {
  top: 0;
}
.carousel.vertical .carousel-inner > .active.left {
  left: 0;
  top: -100%;
}
.carousel.vertical .carousel-inner > .active.right {
  left: 0;
  top: 100%;
}
.carousel.vertical .carousel-indicators,
.carousel-indicators-vertical {
  right: 20px;
  top: 50%;
  transform: translate(-50%);
  bottom: auto;
  left: auto;
  width: auto;
  margin: 0;
  padding: 0;
}
.carousel.vertical .carousel-indicators li,
.carousel-indicators-vertical li {
  display: block;
  margin: 5px 0;
}
</style><div class="carousel slide vertical" id="carousel-vertical" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel-vertical" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-vertical" data-slide-to="1"></li>
    <li data-target="#carousel-vertical" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="item active"></div>
    <div class="item"></div>
    <div class="item"></div>
  </div>
</div>
<p>
dksks
sd
sd
s
s
ds
dd
sd
ss
sd
s
sd
ds

ds
</p>
<script>$(document).ready(function() {
  var delta = 0;
  var scrollThreshold = 5;

  // detect available wheel event
  wheelEvent = "onwheel" in document.createElement("div") ? "wheel" : // Modern browsers support "wheel"
      document.onmousewheel !== undefined ? "mousewheel" :         // Webkit and IE support at least "mousewheel"
      "DOMMouseScroll";                                            // let's assume that remaining browsers are older Firefox

  // Bind event handler
  $(window).on(wheelEvent, function (e) {
      // Do nothing if we weren't scrolling the carousel
      var carousel = $('.carousel.vertical:hover');
      if (carousel.length === 0)  return;

      // Get the scroll position of the current slide
      var currentSlide = $(e.target).closest('.item')
      var scrollPosition = currentSlide.scrollTop();

      // --- Scrolling up ---
      if (e.originalEvent.detail < 0 || e.originalEvent.deltaY < 0 || e.originalEvent.wheelDelta > 0) {
          // Do nothing if the current slide is not at the scroll top
          if(scrollPosition !== 0) return;

          delta--;

          if ( Math.abs(delta) >= scrollThreshold) {
              delta = 0;
              carousel.carousel('prev');
          }
      }

      // --- Scrolling down ---
      else {
          // Do nothing if the current slide is not at the scroll bottom
          var contentHeight = currentSlide.find('> .content').outerHeight();
          if(contentHeight > currentSlide.outerHeight() && scrollPosition + currentSlide.outerHeight() !== contentHeight) return;

          delta++;
          if (delta >= scrollThreshold)
          {
              delta = 0;
              carousel.carousel('next');
          }
      }

      // Prevent page from scrolling
      return false;
  });
})
</script></body>
</html>
