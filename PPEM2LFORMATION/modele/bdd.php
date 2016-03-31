<?php
class Bdd
{
	private static $_instance = null;
	
	public static function getInstance() {

		if(is_null(self::$_instance))
		{
			try {
				self::$_instance = new PDO('mysql:host=localhost;dbname=m2lpoivey;charset=utf8', 'root', '');
			} catch (Exception $e) {
				die('Erreur : '.$e->getMessage());
			}
		}
			
		return self::$_instance;
	}

}
