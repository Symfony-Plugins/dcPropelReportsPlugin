<?php
class dcPropelReflector 
{

  static public function getDatabaseConnections()
  {
    return include(sfContext::getInstance()->getConfigCache()->checkConfig('config/databases.yml'));
  }

  /* Returns the database map for specified name */
  public static function getDatabaseMap($name='propel')
  {
    self::loadMapBuilders();
    return Propel::getDatabaseMap($name);
  }

  /* Returns every tablemaps for this project */
  public static function getTableMaps($name='propel')
  {
    return self::getDatabaseMap($name)->getTables();
  }


  /* Loads every Object Mapping so we can inspect 
   */
  private static function loadMapBuilders()
  {
    $files = sfFinder::type('file')->name('*MapBuilder.php')->in(sfProjectConfiguration::getActive()->getModelDirs());
    foreach ($files as $file)
    {
      $omClass = basename($file, 'MapBuilder.php');
      if (class_exists($omClass) && is_subclass_of($omClass, 'BaseObject'))
      {
        $mapBuilderClass = basename($file, '.php');
        $map = new $mapBuilderClass();
        if (!$map->isBuilt())
        {
          $map->doBuild();
        }
      }
    }
  }
  
  public static function buildColumn($table_name, $column_name, $database_name='propel', $alias = null)
  {
  		$column_name = strtoupper($column_name);	
  		if (is_null($alias))
  		{
	  	    $class_name = self::getClassNameForTable($table_name, $database_name);
	  		$peer_name = constant("$class_name::PEER");
	  		return constant("$peer_name::$column_name"); 
  		}
  		else {
  			return "$alias.$column_name";
  		}	
  }
  
  
  public static function getTableMap( $table_name,$database_name='propel')
  {
  		return self::getDatabaseMap($database_name)->getTable($table_name);
  }
  
  public static function getColumnMap( $table_name, $column_name, $database_name='propel')
  {
  		$table_map = self::getTableMap( $table_name,$database_name);
  		return $table_map->getColumn($column_name);
  }

  public static function getColumnsAsOptions(TableMap $tmap)
  {
    $aux=array();
    if (!is_null($tmap))
    {
      foreach ($tmap->getColumns() as $col)
      {
        $aux[$col->getColumnName()]=$col->getColumnName();
      }
      asort($aux);
    }
    return $aux;
  }
  
  public static function getClassNameForTable($table_name, $database_name='propel')
  {
  		return self::getTableMap( $table_name,$database_name)->getClassName();
  }
  
}
