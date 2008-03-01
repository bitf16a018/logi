<?

/*
 * LcEmail class
 *
 * use to send regular text mail, or to attach text, html or external files 
 * to an email.
 *
 * sample usage
 * ------------
 * $m = new LcEmail("eat@joes.com","pres@un.org","Subject","Regular message");
 * $m->send();
 *
 * $m = new LcEmail("eat@joes.com","pres@un.org","Subject","Regular message");
 * $m->attachFile("/path/to/home/file.pdf");
 * $m->send();
 * 
 * $m = new LcEmail("eat@joes.com","pres@un.org","Subject");
 * $m->inlineHTML("<table width='500'><tr><td>TABLE CELL</td></tr></table>");
 * $m->returnpath = "foo@com.com";
 * $m->replyto = "noone@home.com";
 * $m->cc = "keith@imaho.com";
 * $m->send();
 *
 *
 * this assumes 7bit content-transfer-encoding 
 * can be changed with $m->encoding = "8bit";
 * 
 * calling this a full 'mailer' class is a bit much at this point - 
 * it doesn't do smtp mailing or anything - it's currently just using 
 * the php mail() command
 * 
 * mgk 3/21/03
 *
 */

class LcEmail{

	var $to = '';
	var $from = '';
	var $subject = '';
	var $body = '';
	var $cc = '';
	var $bcc = '';
	var $returnpath = '';
	var $replyto = '';
	var $xmailer = "LogiCreate Mail";
	var $charset = "us-ascii";
	var $encoding = "7bit";
	var $crflag = false;
	var $hasPlainText = false;	

	function LcEmail($to='',$from='',$subject='',$body='') { 
		$this->to = $to;
		$this->from = $from;
		$this->returnpath = $from;
		$this->replyto = $from;
		$this->subject = $subject;
	#	$this->inlineText($body);
		if (trim($body )) { 
			$this->body = $body;
			$this->hasPlainText = true;
		}
		
	}
	
	function attachFile($file, $name='', $enctype='BASE64') { 
		$fp = fopen($file,"rb");
		$f = fread($fp,filesize($file));
		fclose($fp);
		if ($enctype=='BASE64') { 
			$f = base64_encode($f);
		}
		$f = wordwrap($f,76,"\n",1);
		if ($name=='') { 
		$temp = explode("/",$file);
		$temp = array_reverse($temp);
		$desc = $temp[0];
		} else {
		$desc = $name;
		}
		$this->parts[] = array($enctype,$f, $desc,"attach",$this->charset);
		$this->hasFiles = true;
	}

	function attachText($f, $enctype='text/plain') { 
		static $textcount;
		if ($desc=='') { $desc = "text".$textcount++; }
		$this->parts[] = array($enctype,$f, $desc,"attach",$this->charset);
	}

	function inlineText($f, $desc='inline', $enctype='text/plain') { 
		static $textcount;
		if ($desc=='') { $desc = "text".$textcount++; }
		$this->parts[] = array($enctype,$f, $desc, "inline",$this->charset);
	}

	function attachHTML($f, $desc='', $enctype='text/html') { 
		static $htmlcount;
		if ($desc=='') { $desc = "html".$htmlcount++; }
		$this->parts[] = array($enctype,$f, $desc, "attach",$this->charset);
		$this->hasHTML = true;
	}
	function inlineHTML($f, $desc='', $enctype='text/html') { 
		static $htmlcount;
		if ($desc=='') { $desc = "html".$htmlcount++; }
		$this->parts[] = array($enctype,$f, $desc,"inline",$this->charset);
		$this->hasHTML = true;
	}
	function build() {
		$this->boundary = "LC_".time();
		$this->isBuilt = true;
		if ($this->hasPlainText) { 
			if (@count($this->parts)==0) {
				$this->message = $this->body;
			} else {
				$this->inlineText($this->body);
				$this->parts = array_reverse($this->parts);
			}
		}
		while(list($k,$v) = @each($this->parts)) {
			$enctype = $v[0];
			$data = $v[1];
			$desc = $v[2];
			$disp = $v[3];
			$charset = $v[4];
			
			if ($enctype=='text/plain') {
				$header = "Content-Type: text/plain;\n";
				$header .= "  charset=\"$charset\";\n";
				if ($desc!='inline') { 
					$header .= "  name=\"$desc\"\n";
				}
				$header .= "Content-Transfer-Encoding: {$this->encoding}\n";
				$header .= "Content-Disposition: $disp; ";
					if ($desc!='inline') { $filename="\"$desc\""; }
			}
			if ($enctype=='text/html') {
				$header = "Content-Type: text/html;";
				$header .= " charset=\"$charset\";\n";
				$header .= "Content-Transfer-Encoding: {$this->encoding}\n";
			}
			if ($enctype=='BASE64') {
				$header = "Content-Type: application/octet-stream;\n";
				$header .= "  name=\"$desc\"\n";
				$header .= "Content-Transfer-Encoding: base64\n";
				$header .= "Content-Disposition: $disp; filename=\"$desc\"";
			}			
			$x[] = $header."\n\n".$data."\n";	
		}
		if (is_array($x)) { 
			$this->message .= "--".$this->boundary."\n".implode("--".$this->boundary."\n",$x)."\n--".$this->boundary."--";
			$this->contenttype = "Content-Type: multipart/mixed;  boundary=\"".$this->boundary."\"\n";
		} else {
			$this->contenttype = "Content-Type: text/plain;\n";
		}
	}
	
	function send() {
		if (!$this->isBuilt) { $this->build(); }
		$this->_extraheaders = '';
		if ($this->extraheaders) { $this->_extraheaders=$this->extraheaders."\n"; }
#		if ($this->body!='') { $this->message = $this->body."\n\n".$this->message; }
		if ($this->cc!='') { $this->_extraheaders.="CC: ".$this->cc."\n"; }
		if ($this->bcc!='') { $this->_extraheaders.="BCC: ".$this->bcc."\n"; }
		if ($this->returnpath!='') { $this->_extraheaders.="Return-path: ".$this->returnpath."\n"; }
		if ($this->replyto!='') { $this->_extraheaders.="Reply-to: ".$this->replyto."\n"; }
		if ($this->xmailer!='') { $this->_extraheaders.="X-Mailer: ".$this->xmailer."\n"; }
		if ($this->contenttype) { $this->MIME = "MIME-Version: 1.0\n"; }
// trying to resolve this for kendallhoward, at least
// configs put in in unix don't display right in outlook mail???
		if ($this->crflag) { 
			$this->message = str_replace("\r","",$this->message);
			$this->message = str_replace("\n","\r\n",$this->message);
		}
#		return;
		$s = new smtp_client('dl.tccd.edu');
		$s->email($this->from, $this->to,$this->to,($this->MIME.$this->contenttype.$this->_extraheaders),$this->subject,$this->message);
		#mail($this->to,$this->subject,$this->message,"From: {$this->from}\n{$this->contenttype}{$this->_extraheaders}");
		#mail($this->to,$this->subject,$this->message,"From: <{$this->from}>\n{$this->contenttype}\n{$this->_extraheaders}");
	}
			
}
class smtp_client { 
    var $connection; 
    var $server; 
    var $elog_fp; 
    var $log_file='/tmp/smtp_client.log'; 
    var $do_log= true; 
     
 
     // default constructor 
     function smtp_client($server='') { 
         if (!$server) $this->server="localhost"; 
         else $this->server=$server; 
          
         $this->connection = fsockopen($this->server, 25); 
         if ($this->connection <= 0) return 0; 
  
          $this->elog(fgets($this->connection, 1024)); 
          $this->elog("HELO xyz\r\n", 1); 
          fputs($this->connection,"HELO xyz\r\n"); 
          $this->elog(fgets($this->connection, 1024)); 
          } 

       function email($from_mail, $to_mail, $to_name, $header, $subject, $body) {
           if ($this->connection <= 0) return 0;

           $this->elog("MAIL FROM:$from_mail", 1);
           fputs($this->connection,"MAIL FROM:$from_mail\r\n");
           $this->elog(fgets($this->connection, 1024));

            $this->elog("RCPT TO:$to_mail", 1);
            fputs($this->connection, "RCPT TO:$to_mail\r\n");
            $this->elog(fgets($this->connection, 1024));

             $this->elog("DATA", 1);
             fputs($this->connection, "DATA\r\n");
             $this->elog(fgets($this->connection, 1024));

             $this->elog("Subject: $subject", 1);
             $this->elog("To: $to_name", 1);
             fputs($this->connection,"Subject: $subject\r\n");
             fputs($this->connection,"To: $to_name\r\n");

              if ($header) {
                  $this->elog($header, 1);
                  fputs($this->connection, "$header\r\n");
                  }

               $this->elog("", 1);
               $this->elog($body, 1);
               $this->elog(".", 1);
               fputs($this->connection,"\r\n");
               fputs($this->connection,"$body \r\n");
               fputs($this->connection,".\r\n");
               $this->elog(fgets($this->connection, 1024));

	        return 1;
	        }


	      function send() {
	          if ($this->connection) {
	              fputs($this->connection, "QUIT\r\n");
	              fclose($this->connection);
	              $this->connection=0;
	              }
	          }

	       function close() { $this->send(); }


	         function elog($text, $mode=0) {
	             if (!$this->do_log) return;

	              // open file
	              if (!$this->elog_fp) {
	                  if (!($this->elog_fp=fopen($this->log_file, 'a'))) return;
	                  fwrite($this->elog_fp, "\n-------------------------------------------\n");
	                  fwrite($this->elog_fp, " Sent " . date("Y-m-d H:i:s") . "\n");
	                  fwrite($this->elog_fp, "-------------------------------------------\n");
	                  }

	               // write to log
	               if (!$mode) fwrite($this->elog_fp, "    $text\n");
	               else fwrite($this->elog_fp, "$text\n");
	               }
	           }
?>
