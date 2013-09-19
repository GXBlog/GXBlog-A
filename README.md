GXBlog-A
========

GXBlog is an open source PHP bloging program that can let you build own blog easily or a framework.

【GXBlog官博】		http://gxblog.lofter.com

【QQ Group】		147380389

【GenialX‘s Blog】	http://www.ihuxu.com

1、程序介绍

【GXBlog】,是一个"暂时"简陋的单用户个人博客管理系统。在PHP+MySQL+Apache环境下，尽可能完善地利用
面向对象思想，来构造一个简洁、个性、快速的博客管理系统。目前，GXBlog处于测试阶段(Alpha Stage)。

2、功能介绍

（1）【缓存功能】(仅实现Action主题机制的缓存) - 让博客飞起来。

（2）【两种主题模板扩展机制】 - 用最简单的方式，展示最个性的自己。

（3）【插件机制】 - 只有想不到，没有做不到！

（4）【自动安装】 - 安装只需铭记‘下一步’。

3、程序安装

（1） 服务器环境

      PHP version 5 or newer
      MySQL version 5 or newer
      Apache version 2 or newer
      
（2）
	将本程序解压到根目录下，通过地址栏访问根目录可随向导【自动安装】。
	
	在安装过程中，需要手动创建一个数据库，比如'gxblog'。然后将数据库名字填入相应向导表格中。
	

4、注意

（1）由于程序简陋，没有完善的错误处理机制和管理机制。正因如此，程序也非常需要大家的测试来使其更完善，
	 来构造更优雅、简洁的代码。
	
（2）部分配置开关可以到【gx-system/conf/site.inc.php】文件中手动修改。

（3）主题扩展和插件机制尚未成熟，所以暂时不提供帮助文档。

（4）Apache下伪静态规则(适用于Alpha 0.1.0)：

	RewriteEngine on
  	RewriteRule ^/gxblog/p/(.*).html$ /gxblog/index.php?p=$1
	RewriteRule ^/gxblog/tag/(.*)/$ /gxblog/index.php?tag=$1
  	RewriteRule ^/gxblog/tag/(.*)$ /gxblog/index.php?tag=$1
  	
	
5、感谢
哎、Solo的悲伤。。。
