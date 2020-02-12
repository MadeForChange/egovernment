<?php
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $title . " | " . APPSLOGAN; ?>">
    <meta name="keywords" content="<?php echo APPKEYWORDS; ?>">
	<meta name="author" content="PleaseZoomIn">
    <link rel="icon" href="<?php echo UPL_FILES; ?>/img/favicon.ico">
    	<link rel="alternate" href="<?php echo WEB_LINK; ?>rss/" title="<?php echo APPNAME . " | RSS Feed"; ?>" type="application/rss+xml" />
	
	<meta property="og:title" content="<?php echo $title . " | " . APPNAME; ?>">
	<meta property="og:description" content="<?php echo $title . " | " . APPSLOGAN; ?>">
	<meta property="og:type" content="article">
	<meta property="og:url" content="<?php echo  "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">
	

<title>Please Zoom In | Decision making like never before  | Made for Change </title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<style>

.carousel .item {

  background-size: cover;
}


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


/*
  terrible.css
  Andrew Tunecliffe, 2015
  http://atunnecliffe.com
*/
/* uncomment to see outlines of stuff when you hover *-/
:hover {
  background:rgba(0, 0, 0, 0.1);
}/**/

html,
body {
  margin: 0;
  padding: 0;
}

.section {

  width: 100%;
}

.container {
  position: relative;
  width: 1170px;
  margin: 0 auto;
  color: #444;
  font-size: 14px;
  font-weight: 300;
  font-family: Roboto, "Open Sans", Arial, sans-serif;
  overflow: hidden;
}

.section .container {
  padding: 30px 0 50px 0;
}

.section.bg {
  background: #f7f7f7;
}
/*
  Header
*/

@media only screen and (max-width: 600px) { .header {display :none;} }

.header {
  line-height: 40px;
  width: 100%;
  transition: line-height 0.2s linear, box-shadow 0.2s linear;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  background: rgba(245, 245, 245, 0.97);
}

.header.small {
  line-height: 50px;
  box-shadow: 0px 1px 3px 0px rgba(50, 50, 50, 0.8);
}

.header.small > .container > #logo {
  height: 40px;
}

.target {
  top: 50%;
  color: #fff !important;
  transform: translateY(-50%);
}
#logo {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: red;
  float: left;
  height: 40px;
  width: 170px;
  margin-left: 5px;
}

ul.nav {
  float: right;
  list-style: none;
  margin: 0;
  padding: 0;
}

ul.nav li {
  float: left;
  position: relative;
}

ul.nav li a {
  transition: color 0.2s linear;
  font-size: 18px;
}

ul.nav li:hover a {
  color: red;
}

ul.nav li a {
  padding: 21px;
  color: initial;
  text-decoration: initial;
}
/*
  Slider
*/

.section .slider,
.section .footer {
  background: #333;
}

.slidercontent {
  text-align: center;
}

.hero {
  font-family: "Roboto Slab", sans-serif;
  color: white;
  font-weight: normal;
  letter-spacing: 1px;
}

h1.hero {
  font-size: 54px;
}

h2.hero {
  font-size: 30px;
  margin-bottom: 60px;
}

h1.hero:after {
  content: "";
  width: 300px;
  position: relative;
  border-bottom: 1px solid #aaa;
  text-align: center;
  margin: auto;
  margin-top: 15px;
}

.call {
  color: white;
  display: block;
  margin-bottom: 20px;
}

.call span {
  display: inline;
  border: 1px solid white;
  padding: 8px 13px;
  font-size: 20px;
  transition: background 0.15s linear;
}

.call span:hover {
  background: rgba(255, 255, 255, 0.1);
  cursor: pointer;
}
/* 
  Columns 
*/

.col {
  float: left;
  padding: 0;
  margin: 0;
  position: relative;
}

.col.four {
  width: 23%;
  margin: 0 1%;
}

.col.three {
  width: 31.3%;
  margin: 0 1%;
}

.col.two {
  width: 40%;
  margin: 0 2.5%;
  padding: 0 2.5%;
}

.col.extrapad {
  padding-top: 20px;
  padding-bottom: 20px;
}

.col .service,
.col .feature {
  font-size: 21px;
  font-weight: 300;
  font-family: "Roboto Slab", sans-serif;
}

.col .service:after {
  content: "";
  width: 50px;
  position: relative;
  border-bottom: 1px solid #eee;
  display: block;
  text-align: center;
  margin: auto;
  margin-top: 15px;
}

.col .feature {
  font-size: 19px;
}

.col h1.side,
.col p.side,
.col span.side:first-of-type {
  margin-left: 50px;
  text-align: left;
}

.col .icon {
  border-radius: 50%;
  height: 85px;
  width: 85px;
  line-height: 85px;
  text-align: center;
  margin: 0 auto;
  transition: background 0.25s linear, color 0.25s linear;
}

.col .icon.side {
  position: absolute;
  padding: 0;
  margin: 0;
  top: -15px;
  height: 50px;
  width: 50px;
}

.col:hover > .icon {
  background: #f44336;
  color: white;
}

.col:hover > .icon.side {
  background: initial;
  color: initial;
}

.responsivegroup {
  display: none;
}
/*
  Column specifics
*/

.col p,
.col h1 {
  padding: 0 1%;
  text-align: center;
}

.group.margin {
  margin-bottom: 20px;
}

.col .imgholder {
  height: 300px;
  width: 100%;
  background: #333;
  transition: background 0.3s linear;
}

.col.bg {
  background: #fff;
}

.col.pointer {
  cursor: pointer;
}

.col.bg:hover .imgholder {
  background: #555;
}

.col span.feature {
  font-size: 20px;
}
/*
  Text
*/

.container > h1:not(.hero) {
  margin-bottom: 30px;
  text-align: center;
}

.container > h1:after {
  content: "";
  width: 30px;
  position: relative;
  border-bottom: 1px solid #aaa;
  display: block;
  text-align: center;
  margin: auto;
  margin-top: 15px;
}

h2 {
  font-family: "Roboto Slab", sans-serif;
  text-align: center;
  font-weight: 400;
  font-size: 18px;
}

.left,
.left > h1,
.left > p {
  text-align: left;
}

.reset {
  text-align: left !important;
}

.reset:after {
  display: none !important;
}
/* 
  Slider with Content
*/

.white h1,
.white h2,
.white p,
.white div,
.white a {
  color: #fff;
}
/*
  Responsive
*/

.group:after {
  content: "";
  display: table;
  clear: both;
}

@media all and (max-width: 768px) {
  .container {
    width: 95%;
  }
  .col.four {
    width: 48%;
    margin: 1%;
  }
  .col.three {
    display: block;
    width: 95%;
    padding: 0;
    margin: 0 auto;
    float: none;
  }
  .header {
    height: auto;
    background: #eee;
  }
  #logo {
    position: initial;
    float: none;
    display: block;
    transform: none;
    margin: 10px auto 0 auto;
  }
  ul.nav {
    float: none;
    display: block;
    text-align: center;
    margin: 0 auto;
  }
  ul.nav li {
    float: initial;
    display: inline-block;
  }
  .responsivegroup {
    display: block;
  }
  .responsivegroup:after {
    content: "";
    display: table;
    clear: both;
  }
}

@media all and (min-width: 768px) {
    
 :target:before {
content:"";
display:block;
height:90px; /* fixed header height*/
margin:-90px 0 0; /* negative fixed header height */
}

.section {    margin-top: 6%;}
    
    #carousel-vertical { margin-top:80px;}
  .container {
    width: 750px;
  }
}

@media all and (min-width: 992px) {
  .container {
    width: 970px;
  }
}

@media all and (min-width: 1200px) {
  .container {
    width: 1170px;
  }
}

@media all and (max-width: 450px) {
  .col,
  .col.four,
  .col.three,
  .col.two {
    display: block;
    width: 95%;
    padding: 0;
    margin: 0 auto;
    float: none;
  }
  .col.extrapad {
    padding: 1%;
    margin-bottom: 10px;
  }
  .group {
    display: none;
  }
}
</style>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


</head>
<body>

    
<div class="hold">
  <div class="header">
    <div class="container">
      <a href="<?php echo $url_mapper['login/']; ?>" target="_blank"><div id="logo"><h2 class="target">Visit Platform</h2>
      </div></a>
      <ul class="nav">
        <li><a href="#about-us">About us/ Goal</a></li>
        <li><a href="#for-collaborators">Collaborators</a></li>
        <li><a href="<?php echo $url_mapper['thankyou']; ?>">Hall of Fame</a></li>
        <li><a href="mailto:connect@pleasezoom.in?Subject=For%20%The20Change" target="_top">Contact Us</a></li>
      </ul>
    </div>
  </div>
</div>




<div class="section">
     <div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">Thank You so Much (:</h1>
      <h2 class="hero">You made a step towards Yourself</h2>
      <div class="call"><span>👏</span></div>
    </div>
    </div>
</div>

<div class="section bg">
  <div class="container">
    <h1>Imagine one day, you wake up & see a completely different world </h1>
    <h2>The Scenario may look like below</h2>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/positive/flag-all-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Unity in diversity</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/positive/smile1-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p  >Smile full India</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/positive/future-india-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Rapid Development</p></p>
    </div>
    <div class="group margin"></div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/positive/women-leading-min.jpeg"  /></div>
      <h1 class="feature"></h1>
      <p>Future ready</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/positive/smile2-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Turning someone's dream to reality</p>    
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/positive/Smile.webp"  /></div>
      <h1 class="feature"></h1>
      <p>Women Empowerment</p>
    </div>
    <div class="group"></div>
  </div>
</div>



<div class="section">
 <div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">Yes, and it's Super Easy</h1>
      <h2 class="hero">Indeed. this is possible, as easy as 1,2,3 . </h2>
      <div class="call"><span>Collaboration is the key</span></div>
    </div></div>
    </div>
    
<div class="section bg">
  <div class="container">
    <h1>Current Scenario</h1>
    <h2>Everything around us is not fair. Right?</h2>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/rape-in-india-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Rape Protests every other day</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/rainy-roads-cities-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Broken Roads</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/indian-railways-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>OverFilled Trains killing hundreds of people daily</p>
    </div>
    <div class="group margin"></div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/Girls-Eve-Teasing-2-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Eve Teasing with Women</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/cows-eating-garbage-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Animals searching for food in garbage</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/bus-fire-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Ultra Violent Protests</p>
    </div>
    <div class="group"></div>
    <div class="group margin"></div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/water-problem-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>people are in queue for daily water needs </p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/dog-car-accident-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Innocent Dogs and animals suffering on roads each day</p>
    </div>
    <div class="col three bg nopad pointer">
      <div class="imgholder"><img class="imgholder" src="http://pleasezoom.in/public/assets/images/negative/beggars-min.jpg"  /></div>
      <h1 class="feature"></h1>
      <p>Kids Begging for food and money around us</p>
    </div>  
  </div>
</div>
    

<div class="section">
  <div class="slider">

    <div class="container slidercontent">
      <h1 class="hero">Don't be sad, Please </h1>
      <h2 class="hero">This is the truth, but if we wait for the government or anyone else to do something about this we may keep waiting forever. but the solution is 100% possible , if we really think to solve the issue  </h2>
      <div class="call"><span>Collaboration is the Key</span></div>
    </div>
  </div>
<div class="slider">
     <div class="container slidercontent">
      <h1 class="hero">What makes someone a Terrorist?</h1>
      <h2 class="hero">Everything is not fair with everyone, we have a biased world . Gender biased, cast biased, religion biased and many more. </h2>
      <div class="call"><span>Why girls don't live their life like boys do??? What Stops you. let's put a permanent full stop there</span></div>
    </div></div>
    


  <div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">Blaming is not a solution. We're resposible for our conditions </h1>
      <h2 class="hero">It's No Government , no politician , no individual except you is responsible for the things happening around you.</h2>
      <div class="call"><span>90% of the problem solutions don't require government's attention to solve'em</span></div>
    </div>
  </div>

  <div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">No more politics , Please</h1>
      <h2 class="hero">Why are we using Bull cart when rest of world in already on bullet train>? Our Government works like a tortoise with old procedures to get something done to make some decisions. It's time to change everything. </h2>
      <div class="call"><span></span></div>
    </div></div>

<div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">What if all this happened to you?</h1>
      <h2 class="hero">What if your sister/you got raped/ what if your mom is ambulance, that couldn't reach hospital on time due to traffic/ what if someone hit your car by their mistake and than harm you phsyically too/ what if your kid fall in a open Gutter/Channel/ What if your dad got murdered by some drunk folks.. What would you do ?
 --There are thousand similar situations which can happen to you or your family anytime, maybe tomorrow or very next moment.
But Changing all this is possible, yes yes .  , We are the government ,,, we need to make it happen     </h2>
      <div class="call"><span>No More Ignoring / Next in the news can be you</span></div>
    </div>       
   </div>
   
   <div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">This is the time, Now or Never</h1>
      <h2 class="hero">Not tomorrow, not next hour, not next minute, think now </h2>
      <div class="call"><span></span></div>
    </div></div>
  
  
  <div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">Solution - *Collaboration* </h1>
      <h2 class="hero">When everyone collaborate to take decison/solve-problem we face everyday , We can achieve any impossible. No problem is large and the decision is 1 million times better than to those whom we elected or any educated government employee would have taken for us, only incase you're lucky enough to get your problem highlighted in their eyes.    </h2>
      <div class="call"><span>Real Democracry</span></div>
    </div></div>
  
  
  
  


</div>
    
    
    


<div class="section">
  
 

<div class="section bg">
  <div class="container">
      <h1>Basic Idea</h1>
    <div class="col four">
      <h1 class="icon">[]</h1>
      <h1 class="service">Join a Discussion</h1>
      <p></p>
    </div>
    <div class="col four">
      <h1 class="icon">[]</h1>
      <h1 class="service">Submit Your Problem</h1>
      <p></p>
    </div>
    <div class="responsivegroup"></div>
    <div class="col four">
      <h1 class="icon">[]</h1>
      <h1 class="service">Propose Solution</h1>
      <p></p>
    </div>
    <div class="col four">
      <h1 class="icon">[]</h1>
      <h1 class="service">Create a meeting room/event </h1>
      <p></p>
    </div>
    <div class="group"></div>
  </div>
</div>


<div class="section bg">
  <div class="container">
    <h1>Power of Collaboration</h1>
    <h2>Best possible Decisons Super Duper Fasttttt</h2>
    <div class="col three">
      <h1 class="icon side">[]</h1>
      <h1 class="feature side">We can achieve almost anything</h1>
      <p class="side">There's no problem if everyone aroud us collaborate and work together on it we can solve any thing which would even seem impossible to most of people now</p>
    </div>
    <div class="col three">
      <h1 class="icon side">[]</h1>
      <h1 class="feature side">The Ultimate Change</h1>
      <p class="side">We humans have potential beyond any measure, Our minds are much powerful than any computer in the universe. We can change any scenario as we like using our so called brain</p>
    </div>
    <div class="col three">
      <h1 class="icon side">[]</h1>
      <h1 class="feature side">Real Democracy</h1>
      <p class="side">Real Democracy is when people take decisions for their wellness? than why do we elect someone to take charge of us on our behalf. We can take any decision and better than those with highest degree if we use our minds together to get the best of best possible solution out </p>
    </div>
    <div class="group margin"></div>
    <div class="col three">
      <h1 class="icon side">[]</h1>
      <h1 class="feature side">Impossible will die</h1>
      <p class="side">Sky will have no limits , when we're together on same platform discussing on any topic . We'll definitely find a answer </p>
    </div>
    <div class="col three">
      <h1 class="icon side">[]</h1>
      <h1 class="feature side">Rapid Growth </h1>
      <p class="side">We can achieve any big thing in least time possible , if we collaborate and work together to find out solution to any problem in the world from Infrastructure to books to any desire.  it's all easy</p>
    </div>
    <div class="col three">
      <h1 class="icon side">[]</h1>
      <h1 class="feature side">It's super easy</h1>
      <p class="side">Most of us know that we're doing this for business , than why we don't think of applying it in our life that is our country , our government. because the good our country is the good we will be...it's directly propotional...</p>
    </div>
    <div class="group margin"></div>
  </div>
</div>




<div class="section">
<div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">The Unseen Truth </h1>
      <h2 class="hero">The truth is we been practioning all this in our work for businesses around the world but not for the most important business i.e. our life/ourself or Government, which directly affects evrything around us  </h2>
      <div class="call"><span>Priority 1</span></div>
    </div></div>

<div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">Your opinion matters </h1>
      <h2 class="hero">No more wasting time discussion your views or sokution on streets, It's time to put views on the platform   </h2>
      <div class="call"><span>Earn Rewards for your time</span></div>
    </div></div>

<div class="slider">
    <div class="container slidercontent">
      <h1 class="hero">Dear Government </h1>
      <h2 class="hero">Thank you so much for your effort support, you're the reason we're here :). grown and developed so much in last 73 years from independence.It's time to get some rest for you. Save your time, outsource tasks to people , they'll manage their tasks best. Solutions will be best, growth will be rapid. Just support with Good, let's not waste tim in politics. Let's Collaborate :)  </h2>
      <div class="call"><span>Thank You :)</span></div>
    </div></div>
</div>



<div class="section bg" id="about-us">
  <div class="container">
    <h1>Mission / About us</h1>
    
    <h2>We're YOU. We're the Change. You are the owner of this thought/this website code etc everything is available for all and everyone. The goal is super clear to change everthing around us. Let's do this in this lifespan, Let's make it happen. This is just start of journey, Let the game begin</h2>
    <h2><img src="http://pleasezoom.in/public/assets/images/mission-min.jpg" /> </h2>
    <div class="col two bg margin extrapad">
      <h1 class="icon side">[]</h1>
      <span class="feature side">Feasible</span><span class="side"> </span>
      <p class="side">It's practically possible now for millions of people, billions of people collaborate at one platform.</p>
    </div>
    <div class="col two bg margin extrapad">
      <h1 class="icon side">[]</h1>
      <span class="feature side">Rapid Change</span><span class="side"> </span>
      <p class="side">Lets change the whole world around us, decision making will be suerfast that we'll grow like 1000000000*times growth rate faster than now</p>
    </div>
    <div class="group margin"></div>
    <div class="col two bg margin extrapad">
      <h1 class="icon side">[]</h1>
      <span class="feature side">Limitless</span><span class="side"> </span>
      <p class="side">We waste alot of time talking about problems to different people around us. Which lead to 0 i.e nothing ,,it also deals us to negativity in us. A platform to discuss the problems and solutions/views of people for the issue can make a huge difference</p>
    </div>
    <div class="col two bg margin extrapad">
      <h1 class="icon side">[]</h1>
      <span class="feature side">No more blaming</span><span class="side"> =</span>
      <p class="side">We wasted so many years blaming each other for problems around us, we see this everyday on news channel and all those political shit, wasting time in real we all know. The real democracy is when people tae decisions and when millions of people work together on a same problem no problem is big and the solution which we get out of it will be million times much better than the solution which will be proposed by a any Minister/ IAS/ or any government individual </p>
    </div>
    <div class="group"></div>
  </div>
</div>
<div class="section bg">
  <div class="container">
    <div class="col two">
      <h1 class="icon">[]</h1>
      <h1 class="service">People who have problems</h1>
      <p>We have lot of problems around us , if we see , we ignore them regularly or discuss with someone who can't actually help with that problem, Problems is what makes out solution. Imagine that problem you facing has been solved, so it's time to turn these imaginations into reality </p>
    </div>
    <div class="col two">
      <h1 class="icon">[]</h1>
      <h1 class="service">For People Who Provide Solutions</h1>
      <p>You're great :) ,helping millions of people providing a way to get out of the problem. You're the one who are Shaping the future.</p>
    </div>
    <div class="group"></div>
  </div>
</div>



<div class="section">
  <div class="footer" id="for-collaborators">
    <div class="container white">
      <div class="col four left">
        <h1>Are you a Subject Matter Expert in any domain?</h1>
        <p>Your solution /vision to specific problem may change life of millions, we'll try our best to provide you extra badge/reputation and rewards for same </p>
        <p>People with any background can contribute, you can contribute to platform(www.pleasezoom.in) too.<a href="mailto:collaborations@pleasezoom.in"> Click here </a> if you have any collaborative idea </p>

      </div>
      <div class="col four left">
        <h1>Are you a government official or politician?</h1>
        <p>See what problem people are facing in your locality or in India as whole, and the best solution which is feasible for you to accomplish. Eventually it can save your time and your team to find out solution and the focus will be more on implementing the solution for a better tomorrow  and eventually better you :)</p>
        <p></p>
        
      </div>
      <div class="col four left">
        <h1>Are you a Web Developer?</h1>
        <p>Collborate with your Code or ideas to achieve this amazing Goal of Humanity</p>
        <p>To get Source Code : <a href="https://https://github.com/MadeForChange/egoverment"> open this github link </a> and download/clone the repo and try something amazing, because it's done by single developer and when multiple people work on same code the result could be seriously amazing ^.^</p>
      </div>
      <div class="col four left">
        <h1>Donations?</h1>
        <p>Donations makes us Rich, you can donate to a specific problem which requires funds to solve the problem, maybe in your locality.. even 1 Rs will count  a lot :) </p>
        <p>You can even donate to people who are giving best solutions as a reward or prize too<a href="https://pleasezoom.in/donate">Click here to Donate</a> or <a href="mailto:donations@pleasezoom.in"> E-mail us </a> incase of any query.</p>
      </div>
      <div class="group"></div>
    </div>
  </div>
</div>


<div class="section bg">
  <div class="container">
    <h1 class="reset">
     or You can Share :) </h1>
  </div>
</div>
<div class="addthis_inline_share_toolbox"></div>


<div class="section bg">
  <div class="container">
    <h1 class="reset">&& Yes, this is not the end. THIS IS JUST A BEGGINING For a completely DIfferent and New FUTURE. This is a change thought by 1 individual just like you :) Your Collaboration in this *change* can change your life both ways :) 
 This is version 1, It's upto you now how you change it and take it the path too , Everything here you can suggest a change and download the code from Github for same too.
 
 Goal is super clear :)
    
  Let's do it 👊 </h1>
  </div>
</div>



<script type="text/javscript">
    window.onscroll = function() {
  var el = document.getElementsByClassName('header')[0];
  var className = 'small';
  if (el.classList) {
    if (window.scrollY > 10)
      el.classList.add(className);
    else
      el.classList.remove(className);
  }
};

</script>
<script> 
$(document).ready(function() {
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
</script>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d7b55d19a573b63"></script>


            
</body>
</html>
