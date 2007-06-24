<?php

class LC_Lob_Renderer {


	function getMetadataForm() {

		$subject = array();
		$subject[] = array(
			'fieldName'     => 'md_subj',
			'displayName'   => 'Subject',
			'type'          => 'text',
		);

		$subdisc = array();
		$subdisc[] = array(
			'fieldName'     => 'md_subdisc',
			'displayName'   => 'Sub-Discipline',
			'type'          => 'text',
		);

		$author = array();
		$author[] = array(
			'fieldName'     => 'md_author',
			'displayName'   => 'Author',
			'type'          => 'text',
		);

		$copyright = array();
		$copyright[] = array(
			'fieldName'     => 'md_copyright',
			'displayName'   => 'Copyright Year',
			'type'          => 'text',
		);

		$license = array();
		$license[] = array(
			'fieldName'     => 'md_license',
			'displayName'   => 'License',
			'type'          => 'text',
		);

		return array($subject, $subdisc, $author, $copyright, $license);
		/*
[1] => Array
        (
            [0] => Array
                (
                    [pkey] => 2147483687
                    [formId] => 2147483654
                    [type] => text
                    [fieldName] => txTitle
                    [displayName] => Enter content title.
                    [defaultValue] => 
                    [exp] => 
                    [validationType] => default
                    [message] => 
                    [stripTags] => N
                    [allowedTags] => 
                    [min] => 2
                    [max] => 255
                    [req] => Y
                    [sort] => 1
                    [size] => 50
                    [maxlength] => 255
                    [selectOptions] => 
                    [checked] => 
                    [multiple] => 
                    [useValue] => 
                    [cols] => 0
                    [rows] => 0
                    [image] => 
                    [parentPkey] => 0
                    [rowStyle] => 
                    [groups] => Array
                        (
                            [0] => reg
                        )

                    [notgroups] => 
                    [row] => 1
                    [startYear] => 
                    [endYear] => 
                    [dateTimeBit] => 
                    [extra] => 
                )

        )
		 * */
	}

}

?>
