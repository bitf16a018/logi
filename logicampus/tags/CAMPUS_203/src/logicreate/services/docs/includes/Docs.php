<?php

  /**
  * Docs_Base
  *
  * @author Joe Stump <jstump@tapinternet.com> 
  * @package Docs
  * @link http://www.tapinternet.com
  */

  /**
  * Docs_Base
  *
  * The base wrapper class for the Document Library class structure. This
  * simple wrapper class is a simple holding place for a database handle. It
  * also provides a setFrom function for simple assigning.
  *
  * @author Joe Stump <jstump@tapinternet.com>
  * @package Docs
  */
  class Docs_Base
  {
    /**
    * $db
    *
    * LC database handle
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    * @var mixed $db
    */
    var $db;

    /**
    * $user
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    * @var mixed $user
    */
    var $user;

    /**
    * Docs_Base
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    * @return void
    */
    function Docs_Base()
    {
      $this->db   = DB::getHandle();
      $this->user = lcUser::getCurrentUser(); 
    }

    /**
    * setFrom
    *
    * This setFrom function takes an array (or object) and then assigns the
    * data in that array via $key => $val to an instance of this class or 
    * one of its children.
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access public
    * @param mixed $data
    */
    function setFrom($data)
    {
      if(is_object($data))
      {
        $data = get_object_vars($data);
      }

      if(!is_array($data))
      {
        return false; 
      }

      $vars = get_object_vars($this); // Get our vars and set accordingly
      while(list($var,) = each($vars))
      {
        if(isset($data[$var]) && !empty($data[$var])) 
        {
          $this->$var = $data[$var];
        }
      }

      return true;
    }

    function isError($object)
    {
      if(is_object($object) && is_a($object,'docs_error'))
      {
        return true;
      }

      return false;
    }

    /**
    * _Docs_Base
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    * @return void
    */
    function _Docs_Base() { }
  }

  class Docs_Error 
  {
    var $message;
    var $code; 

    function Docs_Error($message,$code=null)
    {
      $this->message = $message;
      $this->code    = $code;
    }

    function getMessage()
    {
      return $this->message; 
    }

    function getCode()
    {
      return $this->code; 
    }
  }

?>
