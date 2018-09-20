<?php
/**
 * Created by PhpStorm.
 * User: arneunruh
 * Date: 20.09.18
 * Time: 10:20
 */

namespace Tien\Controller;

//http://freegento.com/doc/d8/dcb/class_mage.html

final class MageDump {

  /**
   * @var MageDump
   */
  private static $instance;

  /**
   * gets the instance via lazy initialization (created on first usage)
   */
  public static function getInstance(): MageDump
  {
    if (null === static::$instance) {
      static::$instance = new static();
    }

    self::$instance->glsProvider = 'GLS Service Provider';
    self::$instance->glsMessage = 'GLS Service Message';
    self::$instance->glsService = 'express';
    self::$instance->glsTagString = "ein,zwei,drei";



    return static::$instance;
  }

  /**
   * is not allowed to call from outside to prevent from creating multiple instances,
   * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
   */
  private function __construct()
  {
  }

  /**
   * prevent the instance from being cloned (which would create a second instance of it)
   */
  private function __clone()
  {
  }

  /**
   * prevent from being unserialized (which would create a second instance of it)
   */
  private function __wakeup()
  {
  }

  /**
   * Return Fake Obkect
   */
  public static function getModel($string = ''){
    return self::getInstance();
  }

  /**
   * Stores Tags in Object or Database
   */
  public static function importValues($tags){
    self::$instance->glsTags = $tags;
  }

  /**
   * Return Fake Data from Mage Object
   */
  public static function getData(){

    return new \stdClass();

  }

  /**
   * Return Fake Object Instance for Learning OOP and Pattern
   */
  public static function getFirstItem(){


    return self::getInstance();
  }

  /**
   * Return Fake String for Exploding
   */
  public static function getGlsMessage(){

    return self::$instance->glsTagString;

  }

  /**
   *Return Fake String
   */
  public static function getService(){
    return self::$instance->glsService;
  }

}