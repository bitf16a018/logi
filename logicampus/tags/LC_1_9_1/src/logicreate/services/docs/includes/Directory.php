<?php

  class Docs_Directory extends Docs_Access
  {
    var $directoryID;
    var $parentID;
    var $name;
    var $posted;

    function Docs_Directory()
    {
      $this->Docs_Access();  

      $this->directoryID  = null;
      $this->name         = null;
      $this->post         = null;

      $this->_groupsTable = 'docs_directories_groups';
      $this->_groupsField = 'directoryID';
    }

    function getDirectoryById($directoryID)
    {
      $sql = "SELECT *
              FROM docs_directories
              WHERE directoryID='$directoryID'";

      $result = $this->db->queryOne($sql);
      if(is_array($this->db->Record) && count($this->db->Record))
      {
        $this->setFrom($this->db->Record);
        return true;
      }

      return false;

    }

    function getDirectoryByName($name)
    {
      $sql = "SELECT *
              FROM docs_directories
              WHERE name='$name'";

      $result = $this->db->queryOne($sql);
      if(is_array($this->db->Record) && count($this->db->Record))
      {
        $this->setFrom($this->db->Record);
        return true;
      }

      return false;
    }

    function getDirectories()
    {
      $ret = array();
      $sql = "SELECT * 
              FROM docs_directories
              WHERE parentID='".$this->directoryID."'
              ORDER BY name";;

      $this->db->query($sql);
      if($this->db->getNumRows())
      {
        while($this->db->next_record())
        {
          $dir = & new Docs_Directory();
          $dir->setFrom($this->db->Record);

          $ret[] = $dir;
        }
      }

      return $ret;
    }

    function getFiles()
    {
      if($this->directoryID !== null)
      {
        $ret = array();
        $sql = "SELECT F.*,R.directoryID
                FROM docs_files AS F, docs_directories_files AS R 
                WHERE F.fileID=R.fileID AND
                      R.directoryID='".$this->directoryID."'
                ORDER BY F.name";

        $this->db->query($sql);
        if($this->db->getNumRows())
        {
          while($this->db->next_record())
          {
            $file = & new Docs_File();
            $file->setFrom($this->db->Record);

            $ret[] = $file;
          }
        }
      }

      return $ret;
    }

    function mkdir($name,$user)
    {
      $dir = & new Docs_Directory();
      if($dir->getDirectoryByName($name))
      {
        if($dir->parentID == $this->directoryID)
        {
          return new Docs_Error('Directory already exists');
        }
      }

      $sql = "INSERT INTO docs_directories
              SET parentID='".$this->directoryID."',
                  username='".$user->username."',
                  name='".$name."',
                  posted='".time()."'";

      $this->db->query($sql);

      return true;
    }

    function deltree($directoryID)
    {
      $dir = & new Docs_Directory();
      if($dir->getDirectoryById($directoryID))
      {
        $files = $this->getFiles();
        if(count($files))
        {
          for($i = 0 ; $i < count($files) ; ++$i)
          {
            $files[$i]->remove();
          }
        }

        $dirs = $this->getDirectories();
        if(count($dirs))
        {
          for($i = 0 ; $i < count($dirs) ; ++$i)
          {
            $dirs[$i]->deltree($dirs[$i]->directoryID);
          }
        }

        $sql   = array();
        $sql[] = "DELETE
                  FROM docs_directories
                  WHERE directoryID='$directoryID'"; 

        $sql[] = "DELETE
                  FROM docs_directories_files
                  WHERE directoryID='$directoryID'"; 

        $sql[] = "DELETE
                  FROM docs_directories_groups
                  WHERE directoryID='$directoryID'"; 

        for($i = 0 ; $i < count($sql) ; ++$i)
        {
          $this->db->query($sql[$i]);
        }
      }
    }

    function _Docs_Directory() 
    { 
      $this->_Docs_Access();
    }
  }

?>
