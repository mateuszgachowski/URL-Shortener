<?php
class API {
  
  protected $db;
  private $baseUrl;

  /**
   * Database connection
   * 
   * @param StdClass $options Contains hostname, dbname, user, password for the db connection
   */
  public function __construct($options, $baseUrl = 'ur2.pl') {
    $this->db      = new PDO("mysql:host=$options->hostname;dbname=$options->database", $options->user, $options->password);
    $this->baseUrl = $baseUrl;
  }

  /**
   * Returns db row if url with given ID exists
   * 
   * @param  Int        $id ID of the url
   * @return Array/Null     Array of data or null if not found
   */
  public function getLinkById($id) {
    $result = $this->db->query("SELECT * FROM `links` WHERE `id` = $id")->fetch(PDO::FETCH_ASSOC);
    if ($result != null) {
      $result['id'] = (int)$result['id'];
      $result['fullURL'] = 'http://'.$this->baseUrl.'/'.$result['id'];
      return self::camelizeKeys($result);
    }
    return $result;
  }

  /**
   * Returns db row if given url exists in the db
   * 
   * @param  String     $url String containing url
   * @return Array/Null      Array of data or null if not found
   */
  public function getLinkByUrl($url) {
    $result = $this->db->query("SELECT * FROM `links` WHERE `url_shortened` = '$url'")->fetch(PDO::FETCH_ASSOC);
    if ($result != null) {
      $result['id'] = (int)$result['id'];
      $result['fullURL'] = 'http://'.$this->baseUrl.'/'.$result['id'];
      return self::camelizeKeys($result);
    }
    return $result;
  }

  /**
   * Adds url to the database (without checking if exists)
   * 
   * @param String $url String containing url
   * @return Int Last insert ID of the row
   */
  public function addLink($url) {
    $insertRequest = $this->db->query("INSERT INTO `links` VALUES (null, '".$url."', now(), null)");
    return $this->db->lastInsertId();
  }

  /**
   * Validates given url
   * 
   * @param  String   $url String containing url
   * @return Boolean       True if valid URL, false if not
   */
  public function validateUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
  }


  /**
   * Camelize all array keys
   * 
   * @param  Array $array Given array
   * @return Array        Array with camelized keys
   */
  private static function camelizeKeys($array) {
    $outputArray = array();

    foreach ($array as $key => $value) {
      $outputArray[self::camelize($key)] = $value;
    }

    return $outputArray;
  }

  /**
   * Camelize given string
   * 
   * @param  String  $value   Input string
   * @param  boolean $lcfirst Describes if the first letter should be lowercase, default true
   * @return String           Camelized string
   */
  private static function camelize($value, $lcfirst = true) {
    $value = preg_replace("/([_-\s]?([a-z0-9]+))/e", "ucwords('\\2')", $value);
    return ($lcfirst ? strtolower($value[0]) : strtoupper($value[0])).substr($value, 1);
  }
}