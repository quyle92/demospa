<title>ZinSpa-Quản lý Spa chuyên nghiệp</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->

<link href="css/style1.css" rel='stylesheet' type='text/css' />

<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script
src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<style> 
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: green;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 12px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/

#myDIV {
    margin: 10px; /*original: 25px */
    width: 100%; /*original: 550px */
    background: orange;
    position: relative;
    font-size: 20px; /*original: 20px */
    text-align: center;
    -webkit-animation: mymove 3s infinite; /* Chrome, Safari, Opera 4s */
    animation: mymove 3s infinite;
}
@media (max-width:414px) {
  .col-md-12 .nhom-hang-ban .grid{
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      box-sizing: border-box;
      margin-left: -5px;
      grid-row-gap: 7px;
     
  }

  button.hangban img, button.hangban_active img {
    width:80px; 
    height: 65px;
    position: absolute;
    left: 20px;
    bottom: -21px;
  }
}
@media (min-width:415px) and (max-width: 1024px){
  .grid.hang-ban{
  display: grid;
  grid-template-columns: 1fr 1fr;
  }
  button.hangban img, button.hangban_active img {
    width:80px; 
    height: 65px;
    position: absolute;
    left: 20px;
    bottom: -21px;
  }
  .menu-content {
      border-right: 1px solid #e0e6e3;
  }

  .col-md-12 .nhom-hang-ban .grid{
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
      box-sizing: border-box;
      margin-left: -5px;
      grid-row-gap: 7px;
     
  }
}

@media (min-width:1025px) {
    .grid.hang-ban{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
  }

  button.hangban img, button.hangban_active img {
    width:80px; 
    height: 65px;
    position: absolute;
    left: 20px;
    bottom: -21px;
  }

  .menu-content {
      border-right: 1px solid #e0e6e3;
  }

  .col-md-12 .nhom-hang-ban .grid{
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
      box-sizing: border-box;
      margin-left: -5px;
      grid-row-gap: 7px;
     
  }
}

@media (min-width:900px)  { 
.titledieutour {
  font-size: 2em;
  }
}


/* Chrome, Safari, Opera from {top: 0px;}
    to {top: 200px;}*/
@-webkit-keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

@keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.nhomhb_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
  }

  .nhomhb {
    background: #A9FFD0; /*#0073aa;*/
    color: #000; /* #fff;*/
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
  }

.hangban_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 80px;
   /* height: 100px;*/
    height:38px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
  }

  .hangban {
    background: #0073aa;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 80px;
    /*height: 100px;*/
    height:38px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
  }

#page-wrapper {
  margin: 0 0 0 0px !important;
}

/*
*************menu list hang-ban************
 */
body { -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; font-family: 'Lato', sans-serif; letter-spacing: 0px; font-size: 16px; color: #6e726e; font-weight: 400; line-height: 27px; }
h1, h2, h3, h4, h5, h6 { color: #121312; margin: 0px 0px 15px 0px; font-weight: 400; font-family: 'Zilla Slab', serif; }
h1 { font-size: 38px; line-height: 48px; }
h2 { font-size: 36px; line-height: 42px; }
h3 { font-size: 26px; line-height: 36px; }
h4 { font-size: 20px; line-height: 26px; }
h5 { font-size: 16px; }
h6 { font-size: 12px; }
p { margin: 0 0 24px; line-height: 1.6; }
p:last-child { margin: 0px; }
ul, ol { list-style: none; margin: 0; padding: 0; }
a { text-decoration: none; color: #121312; -webkit-transition: all 0.3s; -moz-transition: all 0.3s; transition: all 0.3s; }
a:focus, a:hover { text-decoration: none; color: #1aa644; }







/*.menu-block { margin-bottom: 30px; }*/
.menu-title { border-bottom: 3px solid #e0e6e3; margin-bottom: 36px; padding-bottom: 10px; }
.menu-content { border-bottom: 1px solid #e0e6e3; /*margin-bottom: 30px;*/ padding: 10px 0;}
.dish-img { }
.dish-content { margin-top: 12px;  }
.dish-meta { font-size: 12px; text-transform: uppercase; display: block; width: 130px; line-height: 1.7; }
.dish-title { margin-bottom: 6px; font-size: 14px; text-transform: uppercase; font-weight: 500; position: relative; }
.dish-price { /*position: absolute; right: 16px; top: 0px;*/ margin-top: 12px; font-size: 20px; color: #e03c23; font-weight: 600; font-family: 'Zilla Slab', serif; }
.well-block .dish-meta { width: 100%; }
.well-block .dish-price { font-size: 26px; color: #e03c23; font-weight: 500; font-family: 'Zilla Slab', serif; position: inherit; }


aside.floating {
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9999999;
    background-color: #395ca3;
    -webkit-box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    -moz-box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    font-size: 1.2em;
}
.cover {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
}
aside.floating section.chatus, aside.floating section.inside > a {
    float: left;
    border-right: 1px dotted #ccc;
    vertical-align: middle;
    color: #fff;
    text-align: center;
    width: 20%;
    padding: 15px 0;
    cursor: pointer;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    position: relative;
}
aside.floating section.inside > a {
    font-size: 1em;
}
</style>
