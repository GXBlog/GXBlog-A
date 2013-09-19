<!DOCTYPE HTML>
<html>

<head>
  
  <meta name="keywords" content="<?php echo $_GET['tag']; ?>,胡旭,个人博客" />
  <meta name="description" content="<?php  echo $_GET['tag']; ?> - 胡旭个人博客" />
  
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title><?php echo $_GET['tag']; echo " - "; site_title();?></title>
  <link rel="stylesheet" type="text/css" href="<?php site_link(); ?>gx-content/themes/BlackWorld/css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="<?php site_link(); ?>gx-content/themes/BlackWorld/js/modernizr-1.5.min.js"></script>
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <!-- class="logo_colour", allows you to change the colour of the text -->
        <h1 style="font-size:36px;"><a href="<?php site_link(); ?>" target="_self"><?php echo $_GET['tag']; ?> <span class="logo_colour" style="font-size:18px;"><?php site_title();  ?></span></a></h1>
      </div>
      <nav>
        <ul class="sf-menu" id="nav">
          <li><a href="<?php site_link(); ?>" target="_self">首页</a></li>
          <li><a href="http://gxblog.lofter.com" target="_blank">GXBlog官博</a></li>
          <li><a href="#">Example Drop Down</a>
            <ul>
              <li><a href="#">Drop Down One</a></li>
              <li><a href="#">Drop Down Two</a>
                <ul>
                  <li><a href="#">Sub Drop Down One</a></li>
                  <li><a href="#">Sub Drop Down Two</a></li>
                  <li><a href="#">Sub Drop Down Three</a></li>
                  <li><a href="#">Sub Drop Down Four</a></li>
                  <li><a href="#">Sub Drop Down Five</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down Three</a></li>
              <li><a href="#">Drop Down Four</a></li>
              <li><a href="#">Drop Down Five</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </header>