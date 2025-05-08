<?php

  /**
   * INI Class
   *
   * @yazilim cms pro
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_ini.php, v4.00 2014-03-05 10:12:05 Nurullah Okatan
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  final class INI
  {

      /**
       * INI::write()
       * 
       * @param mixed $filename
       * @param mixed $ini
       * @return
       */
      public static function write($filename, $ini)
      {
          $string = '';
          foreach (array_keys($ini) as $key) {
              $string .= '[' . $key . "]\n";
              $string .= INI::write_get_string($ini[$key], '') . "\n";
          }
          if (file_put_contents($filename, $string))
              return true;
      }

      /**
       * INI::write_get_string()
       * 
       * @param mixed $ini
       * @param mixed $prefix
       * @return
       */
      private static function write_get_string(&$ini, $prefix)
      {
          $string = '';
          ksort($ini);
          foreach ($ini as $key => $val) {
              if (is_array($val)) {
                  $string .= INI::write_get_string($ini[$key], $prefix . $key . '.');
              } else {
                  $string .= $prefix . $key . ' = ' . str_replace("\n", "\\\n", INI::set_value($val)) . "\n";
              }
          }
          return trim($string);
      }

      /**
       * INI::set_value()
       * 
       * @param mixed $val
       * @return
       */
      private static function set_value($val)
      {
          if ($val === true) {
              return 'true';
          } else
              if ($val === false) {
                  return 'false';
              }
          return $val;
      }

      /**
       * INI::read()
       * 
       * @param mixed $filename
       * @return
       */
      public static function read($filename)
      {
          if (!file_exists($filename)) {
              Filter::msgError('Configuration file: {' . $filename . '} is missing');
              exit;
          } else {
              $ini_array = parse_ini_file($filename, true);

              if (!$ini_array)
                  throw new Exception('Error on parsing ini file!', -1);

              $ini = new stdClass();

              //Parse section...
              foreach ($ini_array as $namespace => $prop) {

                  $section = $namespace;
                  $ext = explode(':', $namespace);

                  if (count($ext) == 2) {

                      $section = trim($ext[0]);
                      $extend = trim($ext[1]);

                      if (!isset($ini->$extend))
                          throw new Exception('Parent section doesn\'t exists!', -1);

                      $ini->$section = clone $ini->$extend;

                  } else {
                      $ini->$section = new stdClass();

                      foreach ($prop as $key => $value) {

                          $arr = explode('.', $key);
                          $n = count($arr) - 1;

                          if ($n) {
                              $aux = $ini->$section;
                              for ($i = 0; $i < $n; ++$i) {

                                  if (!isset($aux->$arr[$i]))
                                      $aux->$arr[$i] = new stdClass();

                                  $aux = $aux->$arr[$i];
                              }
                              $aux->$arr[$n] = $value;
                          } else {
                              $ini->$section->$key = $value;
                          }
                      }

                  }

              }

              return $ini;

          }
      }

      /**
       * INI::get_value()
       * 
       * @param mixed $val
       * @return
       */
      private static function get_value($val)
      {
          if (preg_match('/^-?[0-9]$/i', $val)) {
              return intval($val);
          } else {
              if (strtolower($val) === 'true') {
                  return true;
              } else {
                  if (strtolower($val) === 'false') {
                      return false;
                  } else {
                      if (preg_match('/^"(.*)"$/i', $val, $m)) {
                          return $m[1];
                      } else {
                          if (preg_match('/^\'(.*)\'$/i', $val, $m)) {
                              return $m[1];
                          }
                      }
                  }
              }
          }
          return $val;
      }

      /**
       * INI::get_key()
       * 
       * @param mixed $val
       * @return
       */
      private static function get_key($val)
      {
          if (preg_match('/^[0-9]$/i', $val)) {
              return intval($val);
          }
          return $val;
      }

      /**
       * INI::manage_keys()
       * 
       * @param mixed $ini
       * @param mixed $key
       * @param mixed $val
       * @return
       */
      private static function manage_keys(&$ini, $key, $val)
      {
          if (preg_match('/^([a-z0-9_-]+)\.(.*)$/i', $key, $m)) {
              INI::manage_keys($ini[$m[1]], $m[2], $val);
          } else {
              if (preg_match('/^([a-z0-9_-]+)\[(.*)\]$/i', $key, $m)) {
                  if ($m[2] !== '') {
                      $ini[$m[1]][INI::get_key($m[2])] = INI::get_value($val);
                  } else {
                      $ini[$m[1]][] = INI::get_value($val);
                  }
              } else {
                  $ini[INI::get_key($key)] = INI::get_value($val);
              }
          }
      }

      /**
       * INI::replace_consts()
       * 
       * @param mixed $item
       * @param mixed $key
       * @param mixed $consts
       * @return
       */
      private static function replace_consts(&$item, $key, $consts)
      {
          if (is_string($item)) {
              $item = strtr($item, $consts);
          }
      }
  }

?>