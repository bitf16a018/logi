<?


class faqs extends PersistantObject {

	

	function _load($id) {
		if (!$id ) {
			$x = new faqs();
			return $x;
		}
		$x = PersistantObject::_load("faqs","lcFaqs",$id);
		$x->groups = explode("|",substr($x->groups,1,-1));
		return $x;
	}

	function getList() {
		$db = DB::getHandle();

		$sql = "select priority, pkey, category, question, clicks from lcFaqs order by category, clicks DESC, question";
		$db->query($sql);
		$db->RESULT_TYPE = MYSQL_ASSOC;

		while ($db->next_record()) {
			$retList[] = PersistantObject::createFromArray("faqs",$db->Record);
		}
	return $retList;
	}

        function getVisibleList(&$groups,$cat='') {
                $db = DB::getHandle();

                $where = "where ". createGroupCheck($groups);
                if ($cat) {
                        $where .= " and category='$cat' ";
                }
		$sql = "select priority, pkey, category, question, clicks from lcFaqs $where order by category, clicks DESC, question";
                $db->query($sql);
		$db->RESULT_TYPE = MYSQL_ASSOC;

		while ($db->next_record()) {
			$retList[] = PersistantObject::createFromArray("faqs",$db->Record);
		}
	return $retList;
	}

        function getVisibleListSearch(&$groups,$search,$cat='') {
                $db = DB::getHandle();

                $where = "where ". createGroupCheck($groups);
		$where .= " and (question like '%$search%' or answer like '%$search%') ";
                if ($cat) {
                        $where .= " and category='$cat' ";
                }
		
		$sql = "select priority, pkey, category, question, clicks from lcFaqs $where order by category, clicks DESC, question";
                $db->query($sql);
		$db->RESULT_TYPE = MYSQL_ASSOC;

		while ($db->next_record()) {
			$retList[] = PersistantObject::createFromArray("faqs",$db->Record);
		}
	return $retList;
	}


	function getFAQInfo() {
		$db = DB::getHandle();
		$faqid = $this->faqid;
		$sql = "select * from lcFaqs where pkey=$faqid";
		$db->query($sql);
		while ($db->next_record()) {
			$this->question = $db->Record["question"];
			$this->category = $db->Record["category"];
			$this->priority = $db->Record["priority"];
			$this->answer = $db->Record["answer"];
			$this->groups = explode("|",substr($db->Record["groups"],1,-1));

		}
	}




	function _delete($id) {
		PersistantObject::_delete("lcFaqs",$id);
	}


	function update() {
		if (is_array($this->groups) ) {
			$this->groups = '|'.join('|',$this->groups).'|';
		}
		$this->_save("lcFaqs");
	}



	function _getTransient() {
		return array("event");
	}
}

?>
