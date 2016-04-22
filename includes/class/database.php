<?php
class Database
{
	static $connection;
	static $query;
	static $assoc;
	static $rows;
	public static function StartConnection($DB_DSN, $DB_USER, $DB_PASSWORD)
	{
		try { self::$connection = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
		      self::$connection->query("SET NAMES UTF8");        
		  	  self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);								      }
		catch (PDOException $error) { die('<center><span style="color:red"><i>'.$error->getMessage().'</i></span></center>'); }
	}
	public static function StopConnection() { self::$connection = NULL; }
	public static function Query($query) { return (self::$query = self::$connection->query($query)); }
	public static function Fetch_Assoc($query) { return (($query) ? self::$assoc = $query->fetch(PDO::FETCH_ASSOC) : self::$assoc = self::$query->fetch(PDO::FETCH_ASSOC)); }
	public static function Get_Rows($query) { return (($query) ? self::$rows = $query->rowCount() : self::$rows = self::$query->rowCount()); }
}
?>