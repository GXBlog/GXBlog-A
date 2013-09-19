<?php
/**
 * IMPORT GX CLASSES
 */

/**
 * IMPORT SYSTEM CONF FILE
 * 
 * DECLARE SOME CONSTANTSS
 */
require_once dirname(dirname(dirname(__FILE__))) . '/conf/site.inc.php';

/**
 * IMPORT SYSTEM LIBS MODEL PACKAGE
 * 
 * RESPONSIBLE FOR THE BACKGROUND DATA PROCESSIONG 
 */
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/BaseModel.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/ArticleModel.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/CommentModel.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/UserModel.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/MoodSayModel.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/ISayModel.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/SiteInfoModel.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/DB.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/model/User.class.php';

/**
 * IMPORT SYSTEM LIBS TOOLS PACKAGE
 * 
 * UTILITY TOOLS
 */
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXEngien.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXException.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXFilter.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/TextFilter.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/Cache.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/SqlRequire.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/LogicSqlRequire.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/RelationSqlRequire.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/SingleSqlRequire.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/StaticArticleLink.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/TrueStaticArticleLink.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/FalseStaticArticleLink.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/StaticArticleLink.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/TrueStaticTagLink.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/FalseStaticTagLink.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/Admin.Interface.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/AdminFacade.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXPlugin.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/ObjectType.interface.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/ObjectManager.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/LoadTheme.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GenerateHtml.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXQuery.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXTemplate.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXActionTheme.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXPage.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GX404Page.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/tools/GXParamErrorPage.class.php';

/**
 * IMPORT SYSTEM LIBS ACTION PACKAGE
 * 
 * RESPONSIBLE FOR THE LOGICAL PROCESSIONG 
 */
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/action/HomeAction.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/action/AdminAction.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/action/InstallAction.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/action/ShowAction.class.php';
require_once ROOT_PATH . SYSTEM_FOLDER . '/libs/action/ShowActionAdapter.class.php';

/**
 * IMPORT CONTENT THEMES
 * 
 * ACCORDING TO THE 'SITE.INC.PHP' FILE TO LOAD THE SPECIFIC THEME
 */
if(file_exists(ROOT_PATH . CONTENT_FOLDER . '/themes/' . TPL_NAME . '/TemplateAction.class.php')){
	require_once ROOT_PATH . CONTENT_FOLDER . '/themes/' . TPL_NAME . '/TemplateAction.class.php';
}