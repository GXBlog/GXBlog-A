<?php
/**
 * 
 * @name gx-syntaxhighlighter
 * @author GenialX
 * @version 0.1
 */
class SyntaxHighlighter{
	
	public function __construct(& $plugin){
		$plugin->register('SYNTAXHIGHLIGHTER_SHOW',$this,'show');
		$plugin->register('SYNTAXHIGHLIGHTER_GENERATE',$this,'generate');
	}
	
	public function show(){
		echo $this->get_scripts();
	}	
	
	public function generate(){
		$GXEngien = ObjectManager::get_object(ObjectManager::TemplateActionGXEngien);
		if($GXEngien){
			$content = $this->get_scripts();
			$GXEngien->append($content);
		}
	}
	
	private function get_scripts(){
		return "
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shCore.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushCpp.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushCss.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushDelphi.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushJava.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushJScript.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushPerl.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushPhp.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushPython.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushSql.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushVb.js'></script>
			<script type='text/javascript' src='".HOME_PATH."gx-content/plugins/syntaxhighlighter/scripts/shBrushXml.js'></script>
			<script type='text/javascript'>SyntaxHighlighter.all();</script>
			<link type='text/css' rel='stylesheet' href='".HOME_PATH."gx-content/plugins/syntaxhighlighter/styles/shCoreDefault.css'/>
		";
	}
}