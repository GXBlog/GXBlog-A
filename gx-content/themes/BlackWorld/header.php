<!DOCTYPE HTML>
<html>

<head>
  <meta name="keywords" content="胡旭,个人博客,个人网站,大学生,GenialX,晓煦,胡旭个人博客,胡旭个人网站,大学生个人网站,大学生个人博客" />
  <meta name="description" content="胡旭个人博客 || 一个自由大学生的琐碎 || 关注IT互联网的个人博客 ||曾安静过，也热情过；曾后悔过，也无悔过；曾追求过，也放弃过; 曾实在过，也低调过...
	当PHP浮现在眼前时，GXBlog雏形一闪而过，一秒钟的想法。所以,GenialX用PHP脚本搭建了本站。从此，走上了不归路...
	在这里，我会发表一些关于编程的想法、工科相关知识和亲身经历，愿与君共勉... 
	|| GXBlog Designed By GenialX" />
  
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title><?php site_title(); echo " - "; site_desc();?></title>
  <link rel="stylesheet" type="text/css" href="<?php site_link(); ?>gx-content/themes/BlackWorld/css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="<?php site_link(); ?>gx-content/themes/BlackWorld/js/modernizr-1.5.min.js"></script>
</head>

<body>
  <div id="main">
    <header>
      <div id="logo">
        <!-- class="logo_colour", allows you to change the colour of the text -->
        <h1><a href="<?php site_link(); ?>" target="_self"><?php site_title();  ?><span class="logo_colour" style="font-size:18px;"><?php echo " "; site_desc();?></span></a></h1>
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