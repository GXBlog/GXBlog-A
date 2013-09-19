<?php
/**
 * 全局对象引用类型常量接口
 *
 */
interface ObjectType{
	
	/**
	 * 前台控制器TemplateAction所持有的GXEngien引用对象，其用于相应模板文件的模板引擎动作。
	 * 
	 */
	const TemplateActionGXEngien = 'TemplateActionGXEngien';
	
	/**
	 * 前台控制器TemplateAction所持有的Cache引用，其用于缓存操作。
	 */
	const TemplateActionCache	 = 'TemplateActionCache';
	
	/**
	 * 过滤参数的引用
	 */
	const GXFILTER				 = 'GXFilter';
}