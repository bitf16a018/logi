<?php

  class Docs_File extends Docs_Access
  {
    var $fileID;
    var $directoryID;
    var $name;
    var $type;
    var $mime;
    var $title;
    var $abstract;
    var $posted;
    var $_base;

    function Docs_File()
    {
      $this->Docs_Access();

      $this->fileID     = null;
      $this->name       = null;
      $this->type       = null;
      $this->title      = '';
      $this->abstract   = '';
      $this->posted     = 0;
      $this->_base      = CONTENT_PATH.'docs';

      $this->_groupsTable = 'docs_files_groups';
      $this->_groupsField = 'fileID';
    }

    function getFileById($fileID)
    {
      $sql = "SELECT F.*,R.directoryID 
              FROM docs_files AS F, docs_directories_files AS R 
              WHERE F.fileID=R.fileID AND 
                    F.fileID='$fileID'";

      $result = $this->db->queryOne($sql);
      if(is_array($this->db->record) && count($this->db->record))
      {
        $this->setFrom($this->db->record);
        return true;
      }

      return false;
    }

    function getFileByName($name)
    {
      return Docs_Error('Docs_File::getFileByName is deprecated');
    }

    function getFiletype($name=null)
    {
      if($name === null)
      {
        $name = $this->name;  
      }

      $parts = explode('.',$name);

      return $parts[(count($parts) - 1)];
    }

    function isValid($file)
    {
      return true;    
    }

    function write($file,$directoryID)
    {
      $filetype = & new Docs_Filetype();
      if(!$filetype->isValid($this->getFiletype($file['name'])))
      {
        return new Docs_Error('You cannot upload that filetype');
      }

      switch($file['error'])
      {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
          return new Docs_Error('File is too large to upload');
          break;
        case UPLOAD_ERR_PARTIAL:
        case UPLOAD_ERR_NO_FILE:
          return new Docs_Error('Error with uploaded file');
          break;
      }
      

      if($this->_createPath($file['name']) && 
         is_uploaded_file($file['tmp_name']))
      {
        $dest = $this->_getPath($file['name']).'/'.$directoryID.$file['name'];
        if(move_uploaded_file($file['tmp_name'],$dest))
        {

          $sql = "SELECT * 
                  FROM docs_files AS F, docs_directories_files AS R
                  WHERE F.fileID=R.fileID AND 
                        R.directoryID='$directoryID' AND
                        F.name='".$file['name']."'";

          $this->db->query($sql);
          if($this->db->getNumRows())
          {
            $sql = "UPDATE docs_files
                    SET username='".$this->user->username."',
                        mime='".$file['type']."',  
                        title='',
                        abstract='',
                        posted='".time()."'";

            $this->db->query($sql);

            return true;
          }
          else
          {
            $sql = "INSERT INTO docs_files
                    SET username='".$this->user->username."',
                        name='".$file['name']."',
                        type='".$this->getFiletype($file['name'])."',  
                        mime='".$file['type']."',  
                        title='',
                        abstract='',
                        posted='".time()."'";

            $this->db->query($sql);
            $fileID = $this->db->getInsertID();
            if($fileID > 0)
            {
              $sql = "INSERT INTO docs_directories_files
                      SET directoryID=$directoryID,
                          fileID=$fileID"; 
  
              $this->db->query($sql);
  
              return true;
            }
            else
            {
              return new Docs_Error('Error creating file in database');
            }
          }
        }
        else
        {
          return new Docs_Error('An error occurred while copying the file ');
        }
      }  

      return new Docs_Error('An error occurred while writing the file');
    }

    function display()
    {
      $sql = "UPDATE docs_files
              SET hits=(hits + 1)
              WHERE fileID='".$this->fileID."'";

      $this->db->query($sql);

      $file = $this->_getPath($this->name).'/'.$this->directoryID.$this->name;
      header("Content-type: ".$this->mime);
      readfile($file);
      exit();
    }

    function remove()
    {
      $sql   = array();
      $sql[] = "DELETE 
                FROM docs_directories_files
                WHERE fileID='".$this->fileID."'";

      $sql[] = "DELETE 
                FROM docs_files
                WHERE fileID='".$this->fileID."'";

      $sql[] = "DELETE 
                FROM docs_files_groups
                WHERE fileID='".$this->fileID."'";

      $file = $this->_getPath($this->name).'/'.$this->directoryID.$this->name;
      if(unlink($file))
      {
        for($i = 0 ; $i < count($sql) ; ++$i)
        {
          $this->db->query($sql[$i]);
        }
      }
    }

    function _getPath($file)
    {
      return $this->_base.'/'.substr($file,0,1).'/'.substr($file,1,1);
    }

    function _createPath($file)
    {
      $dir1 = $this->_base.'/'.substr($file,0,1);
      $dir2 = $dir1.'/'.substr($file,1,1);

      if(!is_dir($dir1))
      {
        mkdir($dir1,0755);
      }

      if(!is_dir($dir2))
      {
        mkdir($dir2,0755);
      }

      return true;
    }

    function _Docs_File()
    {
      $this->_Docs_Access();
    }
  }

?>
