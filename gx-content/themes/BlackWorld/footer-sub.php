  <footer style="height:50px;">
      <p><?php site_copyright();?> | <a href="<?php  site_link(); ?>" target="_self"><?php  site_title(); ?></a> | <?php  site_record(); ?> | Powered by <a href="http://gxblog.lofter.com/"  target="_blank">GXBlog</a></p>
    </footer>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="<?php site_link(); ?>/gx-content/themes/blackworld/js/jquery.js"></script>
  <script type="text/javascript" src="<?php site_link(); ?>/gx-content/themes/blackworld/js/jquery.easing-sooper.js"></script>
  <script type="text/javascript" src="<?php site_link(); ?>/gx-content/themes/blackworld/js/jquery.sooperfish.js"></script>
  <script type="text/javascript" src="<?php site_link(); ?>/gx-content/themes/blackworld/js/image_fade.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('ul.sf-menu').sooperfish();
    });
  </script>
  <?php 	trigger('SYNTAXHIGHLIGHTER_SHOW'); ?>
  <!-- 百度统计js Start -->
<div id="baiduscript" style="display:none;">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F1d4d6b5288d5ddd445a4b43a534065f8' type='text/javascript'%3E%3C/script%3E"));
</script>
</div>
<!-- 百度统计JS Over -->
</body>
</html>
