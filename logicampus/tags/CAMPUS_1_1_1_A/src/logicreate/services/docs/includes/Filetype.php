<?php

  class Docs_Filetype extends Docs_Base
  {
    /**
    * $filetypes
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    */
    var $filetypes;

    /**
    * $_validTypesArray;
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    */

    /**
    * $_gotFileTypes
    * 
    * @author Joe Stump <jstump@tapinternet.com> 
    * @access private
    */
    var $_gotFiletypes;

    /**
    * $_derfaultIcon
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    * @var string $_defaultIcon
    */
    var $_defaultIcon;

    function Docs_Filetype()
    {

      $this->filetypes        = array();
      $this->_validTypesArray = array();
      $this->_gotFiletypes    = false;
      $this->_defaultIcon     = 'document.gif';

      $this->Docs_Base();
      $this->_getFileTypes();
    }

    function _getFiletypes()
    {
      if($this->_gotFiletypes === false)
      {
        $sql = "SELECT *
                FROM docs_filetypes";
    
        $this->db->query($sql);
        if($this->db->getNumRows())
        {
          while($this->db->next_record())
          {
            $type = $this->db->Record['type'];
            $icon = $this->db->Record['icon'];
            $this->filetypes[$type] = $icon;
            $this->_validTypesArray[] = $type;
          }
        }
      } 
    }

    function getIcon($type)
    {
      if(strlen($this->filetypes[$type]))
      {
        return $this->filetypes[$type];
      }

      return $this->_defaultIcon;
    }

    function isValid($type)
    {
      return true;
      // Uncomment this to do database validation
      // return (in_array($type,$this->_validTypesArray));
    }

    function _Docs_Filetype() 
    { 
      $this->Docs_Base();
    }
  }

?>
