<?

/**
 * Contains a definition of a java class (POJO).
 */
class PlainJavaParsedClass extends ParsedClass {

	var $codeName = 'java';
	var $class = '';		//code to define class
	var $peer = '';			//code to define peer 
	var $basePeer = '';			//code to define base class
	var $baseClass = '';		//code to define base peer

	function  printPea() {
		$ret .="\tprivate __attributes = array(\n";
		reset ($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			if ($v->complex) {
			$ret .= "\t'".$v->name."'=>'".$v->type."',\n";
			} else {
			$ret .= "\t'".$v->name."'=>'".$v->type."',\n";
			}
		}
		$ret = substr($ret,0,-2);
		$ret .= ");\n";
		return $ret;
	}



	/**
	 * Create basic class attributes
	 */
	function  printAttribs() {
	  $ret = '';
		reset ($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .= "\t".$v->toJava().";\n";
		}
		return $ret;
	}



	/**
	 * Create all the java get/set methods
	 */
	function printGetSet() {
	  $ret = '';
		reset ($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .= '

	public '.$v->codeType.' get'.$v->name.'() {
		return this.'.$v->name.';
	}


	public void set'.$v->name.'('.$v->codeType.' val) {
		this._modified = true;
		this.'.$v->name.' = val;
	}
';
		}
		return $ret;
	}


	/**
	 * Create basic one to many relationships
	 */
	function printRelations() {
		//foreign (assume one to many)
		reset($this->relations);
		while ( list ($q,$col) = @each($this->relations) ) {
			$fcol = $col[0];
			$lcol = $col[1];

			$q = convertTableName($q);
			if ( substr($q,-1) == 's' ) { $s = ''; } else { $s ='s'; }
			$ret .= "\tpublic Vector get".$q.$s."() throws Exception {\n";
			$ret .= "\t\tVector ret = ".$q."Peer.doSelect(\"".$lcol." = '\"+this.getPrimaryKey()+\"'\");\n";
			$ret .= "\t\treturn ret;\n";
			$ret .= "\t}\n\n";
		}

		//local (assume one to one)
		@reset($this->localRelations);
		while ( list ($col,$qs) = @each($this->localRelations) ) {
			$q = $qs[0];
			$fcol = $qs[1];
			$q = convertTableName($q);
			$ret .= "\tpublic $q get".$q."() throws Exception {\n";
			$ret .= "\t\tVector ret = ".$q."Peer.doSelect(\"".$fcol." = '\"+this.".convertColName($col)."+\"'\");\n";
			$ret .= "\t\tif ( ret.size() > 1 ) { throw new Exception(\"multiple objects on one-to-one relationship\"); }\n";
			$ret .= "\t\treturn (".$q.") ret.get(0);\n";
			$ret .= "\t}\n\n";
		}

		return $ret;
	}

	function baseClassToJava($extended = true) {
		while ( list ($k,$v) = @each($this->attributes) ) {
			if ( $v->complex ) {
				$complex[] = $v;
			}
		}
		@reset($this->attributes);



		$ret = 'package com.ql.data;

import java.sql.*;
import java.sql.PreparedStatement;
import java.sql.CallableStatement;
import java.sql.ResultSet;
import java.util.Enumeration;
import java.util.*;
import java.sql.SQLException;
import javax.sql.DataSource;
import java.sql.Connection;
import java.sql.DriverManager;
import com.ql.data.util.*;
import com.ql.data.*;

public class '.$this->name.'Base {

	private boolean _new = true;		//not pulled from DB
	private boolean _modified = false;	//set() called
	private double _version = '.PBDO_VERSION.';	//PBDO version number
	private double _entityVersion = '.$this->sourceVersion.';	//Source version number
'.$this->printAttribs().'
'./*$this->printPea().*/'
'.$this->printRelations().'


	public int getPrimaryKey() {
		return this.'.$this->getOID().';
	}


	public void setPrimaryKey(int val) {
		this.'.$this->getOID().' = val;
	}
	

	public boolean isNew() {
		return this._new;
	}


	public void touch() {
	  this._new = false;
	  this._modified = false;
	}


	public void  save() throws Exception {
		if ( this.isNew() ) {
			this.setPrimaryKey('.$this->name.'Peer.doInsert(('.$this->name.')this));
		} else {
			'.$this->name.'Peer.doUpdate(('.$this->name.')this);
		}
	}


	public static '.$this->name.' load(int key) throws Exception {
		String where = "'.$this->getPkey().'= "+key;
		Vector ret = '.$this->name.'Peer.doSelect(where);
		return ('.$this->name.') ret.get(0);
	}


	public static '.$this->name.' load(String[] keyval ) throws Exception {
			String where = "";
			//how do you do string array traversal?
			/*
			while (list (k,v) = @each(key) ) {
			where .= "k=\'v\' and ";
			}
			where = substr($where,0,-5);
			*/

		Vector ret = '.$this->name.'Peer.doSelect(where);
		return ('.$this->name.') ret.get(0);
	}


	public void erase() throws Exception {
	  this.erase(false);
	}


	public void erase(boolean deep) throws Exception {
		'.$this->name.'Peer.doDelete(('.$this->name.')this,deep);
	}


	public boolean isModified() {
		return this._modified;

	}


'.$this->printGetSet().'


}
';
	return $ret;
	}

	function basePeerToJava($extended = true) {
	  $ret = '
package com.ql.data;

import java.sql.*;
import java.sql.PreparedStatement;
import java.sql.CallableStatement;
import java.sql.ResultSet;
import java.util.Enumeration;
import java.util.*;
import java.sql.SQLException;
import javax.sql.DataSource;
import java.sql.Connection;
import java.sql.DriverManager;
import com.ql.data.util.*;
import com.ql.data.*;


public class '.$this->name.'PeerBase {

	private String _tableName = "'.$this->tableName.'";


	/**
	 * convert a database result set into one object
	 */
	public static '.$this->name.' row2Obj(ResultSet rs) throws SQLException {
		'.$this->name.' ret = new '.$this->name.'();
';
		reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .="\t\t";
			$ret .= 'ret.'.$v->name.' = rs.get'.ucfirst($v->codeType).'("'.$v->colName.'");';
			$ret .="\n";
		}
		$ret .='
		ret.touch();
		return ret;
	}


	public static Vector doSelect() throws Exception {
		return '.$this->name.'Peer.doSelect("");
	}


	public static Vector doSelect(String where) throws Exception {
		//use this tableName
		Connection con = null;
		Statement stmt = null;
		ResultSet rs = null;
		Vector ret = new Vector();
		if (where.length() > 0) { where = " WHERE " + where; }


		  /* Using MSSQLServer*/
		  con = DtUtConnection.getRb2k4PoolConnection();
		  stmt = con.createStatement();
		  String selectQuery = "SELECT * FROM '.$this->tableName.' " + where;

		try {
		  rs = stmt.executeQuery(selectQuery);
		  while (rs.next())
		  {
			  ret.add( '.$this->name.'Peer.row2Obj(rs) );
		  }
		  rs.close();
	    } catch ( java.sql.SQLException sqle ) {
			throw new java.sql.SQLException( sqle.getMessage() + "\n Original Query: " + selectQuery);
	    } finally {
			//return to pool
			stmt.close();
			con.close();
	    }

	return ret; 
	}


	public static int doInsert('.$this->name.' obj) throws Exception {
        Connection con = null;
        Statement stmt = null;
		ResultSet rs = null;
        int key;

		  /* Using MSSQLServer*/
		  con = DtUtConnection.getRb2k4PoolConnection();
		  stmt = con.createStatement();

		String insertQuery = "INSERT INTO '.$this->tableName.' (";
';
		$num_attributes = count($this->attributes);
		$counter = 0;
		@reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
		    ++$counter;
			if ($v->name == $this->getOID()) continue;
			$ret .="\t\t";
			$ret .= 'insertQuery += "'.$k.'";';
			$ret .="\n";
			if ($counter < $num_attributes) $ret .= "\t\t".'insertQuery += ", ";' ."\n";
		}



		$ret .='
		insertQuery += ") VALUES (";
';
		$num_attributes = count($this->attributes);
		$counter = 0;
		@reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
		    ++$counter;
			if ($v->name == $this->getOID()) continue;
			$ret .="\t\t";
			$ret .= 'insertQuery += "\'"+obj.'.$v->name.'+"\'";';
			$ret .="\n";
			if ($counter < $num_attributes) $ret .= "\t\t".'insertQuery += ", ";' ."\n";
		}


		$ret .='
		insertQuery += " ) ";

		  try{
		  stmt.executeUpdate(insertQuery, Statement.RETURN_GENERATED_KEYS);
		  rs = stmt.getGeneratedKeys();
		  rs.next();
		  key = rs.getInt(1);
		  rs.close();
		  } catch ( java.sql.SQLException sqle ) {
			throw new java.sql.SQLException( sqle.getMessage() + "\n Original Query: " + insertQuery);
		  } finally {
			//return to pool
			stmt.close();
			con.close();
		  }

		obj.setPrimaryKey(key);
		obj.touch();
		return key;
	}


	public static void doUpdate('.$this->name.' obj) throws Exception {
        Connection con = null;
        Statement stmt = null;

		String updateQuery = "UPDATE '.$this->tableName.' set  "+
';
		$num_attributes = count($this->attributes);
		$counter = 0;
		@reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
		    ++$counter;
			if ($v->name == $this->getOID()) continue;
			$ret .="\t\t";
			$ret .= '"'.$v->name.' = \'"+obj.'.$v->name.'+"\'"+';
			$ret .="\n";
			if ($counter < $num_attributes) $ret .= "\t\t".'", "+' ."\n";
		}

		$ret .='
		" WHERE '.$this->getOID().' = \'"+obj.getPrimaryKey()+"\' ";

		  /* Using MSSQLServer*/
		  con = DtUtConnection.getRb2k4PoolConnection();
		  stmt = con.createStatement();

		  try {
		  	stmt.executeUpdate(updateQuery);
		  } catch ( java.sql.SQLException sqle ) {
			throw new java.sql.SQLException( sqle.getMessage() + "\n Original Query: " + updateQuery);
		  } finally {
			//return to pool
			stmt.close();
			con.close();
		  }


		obj.touch();
	}


	public static void doDelete('.$this->name.' obj, boolean deep) throws Exception{
        Connection con = null;
        Statement stmt = null;

		String deleteQuery = "DELETE FROM '.$this->tableName.' WHERE  "+
		" '.$this->getOID().' = \""+obj.getPrimaryKey()+"\" ";

		/* Using MSSQLServer*/
		con = DtUtConnection.getRb2k4PoolConnection();
		stmt = con.createStatement();


		  try {
		  	stmt.executeUpdate(deleteQuery);
		  } catch ( java.sql.SQLException sqle ) {
			throw new java.sql.SQLException( sqle.getMessage() + "\n Original Query: " + deleteQuery);
		  } finally {
			//return to pool
			stmt.close();
			con.close();
		  }



		//not done yet
		if ( deep ) {
';

		@reset($this->relations);
		while ( list ($k,$v) = @each($this->relations) ) {
		$ret .='
			stmt = con.createStatement();
			stmt.executeUpdate("DELETE FROM '.$k.' WHERE '.$v[1].' = \""+obj.getPrimaryKey()+"\"");
';
		}
		$ret .='
		}
	}



	/**
	 * perform raw sql
	 */
	public static void doQuery(String query) throws Exception{
        Connection con = null;
        Statement stmt = null;


		/* Using MSSQLServer*/
		con = DtUtConnection.getRb2k4PoolConnection();
		stmt = con.createStatement();


		  try {
		  	stmt.executeUpdate(query);
		  } catch ( java.sql.SQLException sqle ) {
			throw new java.sql.SQLException( sqle.getMessage() + "\n Original Query: " + query);
		  } finally {
			//return to pool
			stmt.close();
			con.close();
		  }

	}


}
';
	return $ret;
	}

	function classToJava($extended) {
	  $ret = '
package com.ql.data;

import java.sql.*;
import java.sql.PreparedStatement;
import java.sql.CallableStatement;
import java.sql.ResultSet;
import java.util.Enumeration;
import java.util.*;
import java.sql.SQLException;
import javax.sql.DataSource;
import java.sql.Connection;
import java.sql.DriverManager;
import com.ql.data.util.*;
import com.ql.data.*;


//You can edit this class, but do not change this next line!
public class '.$this->name.' extends '.$this->name.'Base {


}
';
	return $ret;
}


	function peerToJava($extended) {
	  $ret = '
package com.ql.data;

import java.sql.*;
import java.sql.PreparedStatement;
import java.sql.CallableStatement;
import java.sql.ResultSet;
import java.util.Enumeration;
import java.util.*;
import java.sql.SQLException;
import javax.sql.DataSource;
import java.sql.Connection;
import java.sql.DriverManager;
import com.ql.data.util.*;
import com.ql.data.*;


public class '.$this->name.'Peer extends '.$this->name.'PeerBase {

}
';
		return $ret;
	}


	/**
	 * facade to get the proper language
	 */
	function toCode($extended = true) {
	  $this->baseClass = $this->baseClassToJava();
	  $this->basePeer = $this->basePeerToJava();
	  $this->class = $this->classToJava();
	  $this->peer = $this->peerToJava();
	}


}


?>
