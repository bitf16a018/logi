	HTMLArea.prototype._insertSwf = function ()
	{
		var editor = this;	// for nested functions
		
		this._popupLCDialog("<?=appurl('classdoclib/wysiwygswf/event=frame/');?>", function(param) {
			
			if (!param["f_url"]) {	// user must have pressed Cancel
				return false;
			}
			
			var sel = editor._getSelection();
			var range = editor._createRange(sel);

			var doc = editor._doc;
			
			var myimg =doc.createElement('object');
			
			
			
			var myparam3 =doc.createElement('param');
			myparam3.name = 'movie';
			myparam3.value = param["f_url"];
			
			myimg.appendChild(myparam3);
			
			var myparam1 =doc.createElement('param');
			myparam1.name = 'quality';
			myparam1.value = 'high';
			
			myimg.appendChild(myparam1);
			
			var myparam2 =doc.createElement('param');
			myparam2.name = 'bgcolor';
			myparam2.value = '#ffffff';
			
			myimg.appendChild(myparam2);
			
			var myembed =doc.createElement('embed');
			myembed.src =  param["f_url"];
			myembed.quality = 'high';
			myembed.bgcolor = '#ffffff';
			myembed.width = param["width"];
			myembed.height = param["height"];
			myembed.type = 'application/x-shockwave-flash';
			myembed.setAttribute('pluginspage','http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash');
			myimg.appendChild(myembed);
			
			var codebase;
			
			// codebase is a cab file download.. i need to determine which version of flash 
			// and then add that in.
			if (param["version"] == 4)
			{	codebase = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0';
			}
			if (param["version"] == 5)
			{	codebase = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0';
			}
			if (param["version"] == 6)
			{	codebase = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0';
			}
			
			myimg.setAttribute('codebase',codebase);
			
			myimg.setAttribute('classid',"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000");
			myimg.setAttribute('width',param["width"]);
			myimg.setAttribute('height',param["height"]);
			
			if (HTMLArea.is_ie) {
				range.pasteHTML(myimg.outerHTML);
			} else {
				editor.insertNodeAtSelection(myimg);
			}
			
			
			return true;
			
			
			}, null);
	}
	
	HTMLArea.prototype._insertContentLinks = function ()
	{
		var editor = this;	// for nested functions
		
		this._popupLCDialog("<?=appurl('classdoclib/wysiwyglinks/event=frame/');?>", function(param) {
			
			if (!param["f_url"]) {	// user must have pressed Cancel
				return false;
			}
			
			var sel = editor._getSelection();
			var range = editor._createRange(sel);

			var doc = editor._doc;
			
			var myimg =doc.createElement('a');
			
			myimg.href = param["f_url"];
				var myatext = doc.createTextNode(param["f_labeltext"]);
			myimg.appendChild(myatext);
			
			if (HTMLArea.is_ie) {
				range.pasteHTML(myimg.outerHTML);
			} else {
				editor.insertNodeAtSelection(myimg);
			}
			return true;
			
			
			}, null);
	}
	
	
	
	HTMLArea.prototype._insertDocLibContentLinks = function ()
	{
		var editor = this;	// for nested functions
		
		this._popupLCDialog("<?=appurl('classdoclib/wysiwygcontentlinks/event=frame/');?>", function(param) {
			
			if (!param["f_url"]) {	// user must have pressed Cancel
				return false;
			}
			
			var sel = editor._getSelection();
			var range = editor._createRange(sel);

			var doc = editor._doc;
			
			var myimg =doc.createElement('a');
			
			myimg.href = param["f_url"];
				var myatext = doc.createTextNode(param["f_labeltext"]);
			myimg.appendChild(myatext);
			
			if (HTMLArea.is_ie) {
				range.pasteHTML(myimg.outerHTML);
			} else {
				editor.insertNodeAtSelection(myimg);
			}
			return true;
			
			
			}, null);
	}



	HTMLArea.prototype._insertDocLibImage = function ()
	{
		var editor = this;	// for nested functions
		
		this._popupLCDialog("<?=appurl('classdoclib/wysiwygimages/event=frame/');?>", function(param) {
			
			if (!param["f_url"]) {	// user must have pressed Cancel
				return false;
			}
			
			var sel = editor._getSelection();
			var range = editor._createRange(sel);

			var doc = editor._doc;
			var myimg =doc.createElement("img");
			
			myimg.src = param["f_url"];
			myimg.alt = param["f_alt"];
			myimg.title = param["f_alt"];
			myimg.align = param["f_align"];
			
			if (HTMLArea.is_ie) {
				range.pasteHTML(myimg.outerHTML);
			} else {
				editor.insertNodeAtSelection(myimg);
			}
			return true;
			
			
			}, null);
	}
