<?php
/**
 * 配置文件
 * 
 * 本文件包含以下配置选项：数据库设置、路径设置、时区设置、管理员设置、开发者设置、系统设置和其它设置。
 */

 
// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** 数据库的名称 */
define('DB_NAME', 'database_name_here');

/** MySQL 数据库用户名 */
define('DB_USER', 'username_here');

/** MySQL 数据库密码 */
define('DB_PASSWORD', 'password_here');

/** MySQL 主机 */
define('DB_HOST', 'localhost');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');
 
/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'UTF8');

/**
 * GXBlog 数据表前缀。
 *
 * 如果您有在同一数据库内安装多个 GXBlog 的需求，请为每个 GXBlog 设置不同的数据表前缀。
 * 前缀名只能为数字、字母加下划线。
 */
define('TABLE_PREFIX', 'gx_');


// ** 路径的设置  ** //
/** 模板名称  */
define('TPL_NAME','blueDiv');

/** 网站的相对地址  */
define('ROOT_PATH',dirname(dirname(dirname(__FILE__))).'/');

/** 网站的绝对地址 */
define('HOME_PATH','site_path_here');


// ** 时区的设置 ** //
/** 时区设置 */
date_default_timezone_set('Asia/Shanghai');


// ** 管理员设置 ** //
/** 伪静态开关 */
define('FALSE_STATIC',FALSE);

/** 插件开关 */
define('PLUGIN',TRUE);

/** 缓存开关 */
define('CACHE',FALSE);

/** 缓存周期 */
define('CACHE_LIFE',600);


// ** 开发者设置 ** //
/** 调试开关 */
define('DEBUG',FALSE);

// ** 系统设置 ** //
/** 程序部署的开关 */
define('INSTALL',TRUE);

/** 后台文件夹常量 */
define('ADMIN_FOLDER','gx-admin');

/** 系统文件夹常量 */
define('SYSTEM_FOLDER','gx-system');

/** 扩展文件夹常量 */
define('CONTENT_FOLDER','gx-content');


// ** 其它设置 ** //

