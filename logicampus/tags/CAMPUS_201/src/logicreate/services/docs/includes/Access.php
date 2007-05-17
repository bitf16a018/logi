<?php

  /**
  * Docs_Access
  *
  * Provides access permission controls for both the file and directory 
  * classes. Each file and each directory has access permissions based on
  * groups. The access permissions cascade down directories; meaning that 
  * if directories B and C are subdirectories of A and you do *NOT* have 
  * permissions to view A you will not be able to see A (this does not, 
  * however, mean you can't write to B or C if you have view permissions 
  * on A).
  *
  * @author Joe Stump <jstump@tapinternet.com>
  * @package Docs
  */
  class Docs_Access extends Docs_Base
  {
    var $groups;
    var $_groupsTable;
    var $_groupsField;
    var $_gotGroups;

    function Doc_Access()
    {
      $this->groups       = array();
      $this->_gotGroups   = false;
      $this->_groupsTable = null;
      $this->_groupsField = null;

      $this->Docs_Base();
    }

    /**
    * _getGroups
    *
    * Get the groups that have access to this specific file/directory. If 
    * the groups have already been grabbed we return the cached version. It is
    * important to note that if the count() on this array returns 0 anyone 
    * will have access to that file/directory.
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access protected
    * @return mixed
    */
    function _getGroups()
    {
      if(!$this->_gotGroups)
      {
        $sql = "SELECT * 
                FROM ".$this->_groupsTable."
                WHERE ".$this->_groupsField."='".$this->{$this->_groupsField}."'";

        $this->db->query($sql);
        if($this->db->getNumRows())
        {
          while($this->db->next_record())
          {
            $this->groups[] = $this->db->Record['gid'];
          }
        }
      }

      return $this->groups;
    } 

    function _r()
    {
      $groups = $this->_getGroups();
      if(!count($groups))
      {
        return true; // if no perms are set return true
      }
      else
      {
        while(list(,$group) = each($this->user->groups))
        {
          if(in_array($group,$groups))
          {
            return true;
          }
        }
      }

      return false;
    }

    /**
    * _w
    *
    * Returns true if the current user has write access to the current
    * directory. This currently only works for this, but could be easily
    * altered to work with other systems (ie. check databases, etc.).
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access public
    * @return bool
    */
    function _w()
    {
      $groups = $this->user->groups;
      if(is_array($groups) && count($groups))
      {
        while(list(,$group) = each($groups))
        {
          if(in_array($group,array('admin','dlstaff')))
          {
            return true;
          }
        }
      }

      return false;
    }

    /**
    * _x
    *
    * Would it be UNIX permissions if it didn't have an x bit? I think not.
    *
    * @author Joe Stump <jstump@tapinternet.com>
    * @access public
    * @return bool
    */
    function _x()
    {
      return true;
    }

    function isValid($file)
    {
      return true;    
    }

    function _Docs_Access()
    {
      $this->_Docs_Base();
    }
  }

?>
