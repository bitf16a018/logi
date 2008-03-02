<?php

/**
 * Process Learning Object XML formats
 */
class Lc_Lob_Xml {

	/**
	 * return an Lc_Lob object
	 *
	 * @param $tempDir string   The location of the unzipped backup file (/tmp/campus9999/).
	 * @static
	 */
	function parseNode($n,$tempDir='/tmp/') {
		$result = $n->getElementsByTagname('type');
		$type = $result->item(0);
		$children = $type->childNodes;
		$content = '';
		if ($children->length) {
			$content = trim($children->item(0)->nodeValue);
			$guid = $n->getAttribute('guid');
			$dbid = $n->getAttribute('dbid');
		}
		else {
			die ('unknown class: '. get_class($type)); 
			return null;
		}
		$lob = null;
		$lob    = new LobRepoEntry();
		$lob->set('lobGuid',$guid);
		switch ($content) {
			case 'content':
				$lob->set('lobType','content');
				break;
			case 'activity':
				$lob->set('lobType','activity');
				break;
			case 'test':
				$lob->set('lobType','test');
				break;
		}
		if ($lob->lobType == '') { return null; die ('unknown type '. $content); }


		$result = $n->getElementsByTagname('title');
		$node = $result->item(0);
		$children = $node->childNodes;
		$lob->set('lobTitle', trim($children->item(0)->nodeValue) );

		$result = $n->getElementsByTagname('content');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobContent', trim($children->item(0)->nodeValue) );
		}

		$result = $n->getElementsByTagname('filename');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobFilename', trim($children->item(0)->nodeValue) );

			$urlTitle = Lc_Lob_Util::createLinkText(trim($children->item(0)->nodeValue));
			$lob->set('lobUrltitle', $urlTitle );
			$lob->set('lobBinary', file_get_contents($tempDir.'/content/'.trim($children->item(0)->nodeValue)) );
		} else {
			$urlTitle = Lc_Lob_Util::createLinkText(trim( $lob->get('lobTitle')) );
			$lob->set('lobUrltitle', $urlTitle );
		}

		$result = $n->getElementsByTagname('description');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobDescription', trim($children->item(0)->nodeValue) );
		}


		$result = $n->getElementsByTagname('subtype');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobSubType', trim($children->item(0)->nodeValue) );
		}

		$result = $n->getElementsByTagname('mime');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobMime', trim($children->item(0)->nodeValue) );
		}

		$lobMetaObj = Lc_Lob_Xml::processLobMeta($n);
		//make the final wrapper object
		$lcLob = new Lc_Lob();
		$lcLob->repoObj = $lob;
		$lcLob->lobMetaObj = $lobMetaObj;
		$lcLob->type = $lob->lobType;

		$lobSub = null;

		if ($lob->lobType == 'content') {
			$lobSub = $this->makeContentNode($n);
		}
		if ($lob->lobType == 'activity') {
			$lobSub = $this->makeActivityNode($n);
		}

		if ( is_object($lobSub) ) {
			$lcLob->lobSub = $lobSub;
		}

		return $lcLob;
	}

	/**
	 * return a lob metadata object
	 */
	function processLobMeta($n) {
		$result = $n->getElementsByTagname('metadata');
		$meta = $result->item(0);
		$children = $meta->childNodes;


		$meta = new LobMetadata();

		foreach($children as $childNode) {
			if ($childNode->nodeType == XML_TEXT_NODE) {
				continue;
			}

			$tag = $childNode->tagName;
			//remove the XML namespace
			if ( substr($tag,0,4) == 'lob:') {
				$tag = substr($tag,4);
			}
			$subchild = $childNode->childNodes;
			$meta->set($tag, trim($subchild->item(0)->nodeValue) );
		}
		return $meta;
	}
/*

		$result = $n->getElementsByTagname('lobtitle');
		$node = $result->item(0);
		$children = $node->childNodes;
		$lob->set('lobTitle', trim($children->item(0)->nodeValue) );

		$result = $n->getElementsByTagname('lobcontent');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobContent', trim($children->item(0)->nodeValue) );
		}

		$result = $n->getElementsByTagname('lobfilename');
		$node = $result->item(0);
		if (is_object($node) ){
			$children = $node->childNodes;
			$lob->set('lobFilename', trim($children->item(0)->nodeValue) );
			$lob->set('lobUrltitle', urlencode(trim($children->item(0)->nodeValue)) );
		} else {
			$urltitle = $lob->get('lobTitle');
			$urltitle = str_replace(' ', '_', $urltitle);
			$urltitle = urlencode($urltitle);
			$lob->set('lobUrltitle', $urltitle );
		}

		$result = $n->getElementsByTagname('lobdescription');
		$node = $result->item(0);
 */
}


?>
