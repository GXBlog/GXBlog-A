<?php
/**
 * 对象引用管家 - 门面模式
 */
class ObjectManager implements ObjectType{
	private static $Objects = array();
	
	public static final function get_object($key){
		
		if(array_key_exists($key, ObjectManager::$Objects)){
			return ObjectManager::$Objects[$key];
		}
		return FALSE;
	}

	public static final function set_object($key, $Object){
		if(!array_key_exists($key, ObjectManager::$Objects)){
			ObjectManager::$Objects[$key] = $Object;
			return TRUE;
		}
		return FALSE;
	}
	
	public static final function clear_object($key){
		if(array_key_exists($key, ObjectManager::$Objects)){
			unset(ObjectManager::$Objects[$key]);
			return TRUE;
		}
		return FALSE;
	}
}