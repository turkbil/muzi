if (!RedactorPlugins) var RedactorPlugins = {};
RedactorPlugins.snippets = {
  buttons_modal: String()
  + '<section id="redactor-modal-insert-buttons" class="tubi form">'
	    + '<div class="field">'
		+ '<label>Select Type:</label>'
		+ '<div class="inline-group">'
		+ '<label class="radio">'
		  + '<input id="rdoButtonType1" name="rdoButtonType" type="radio" value="tubi button" checked="checked">'
		  + '<i></i><a class="tubi small button">Primary Button</a></label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonType2" name="rdoButtonType" type="radio" value="tubi basic button">'
		  + '<i></i><a class="tubi small basic button">Basic Button</a></label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonType3" name="rdoButtonType" type="radio" value="tubi info button">'
		 + '<i></i><a class="tubi small info button">Info Button</a></label>'
		+ '<label class="radio">'
		 + ' <input id="rdoButtonType4" name="rdoButtonType" type="radio" value="tubi success button">'
		  + '<i></i><a class="tubi small success button">Success Button</a></label>'
		+ '</div>'
	  + '</div>'
	  + '<div class="field">'
	  + '<div class="inline-group">'
		+ '<label class="radio">'
		  + '<input id="rdoButtonType5" name="rdoButtonType" type="radio" value="tubi warning button">'
		  + '<i></i><a class="tubi small warning button">Warning Button</a></label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonType6" name="rdoButtonType" type="radio" value="tubi danger button">'
		 + '<i></i><a class="tubi small danger button">Danger Button</a></label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonType7" name="rdoButtonType" type="radio" value="tubi black button">'
		 + '<i></i><a class="tubi small black button">Black Button</a></label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonType8" name="rdoButtonType" type="radio" value="tubi teal button">'
		  + '<i></i><a class="tubi small teal button">Teal Button</a></label>'
		+ '</div>'
	  + '</div>'
	  + '<div class="field">'
	  + '<label>Select Size:</label>'
	  + '<div class="inline-group">'
		+ '<label class="radio">'
		  + '<input id="rdoButtonSize1" name="rdoButtonSize" type="radio" value="large">'
		  + '<i></i>Large</label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonSize2" name="rdoButtonSize" type="radio" value="" checked="checked">'
		  + '<i></i>Default</label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonSize3" name="rdoButtonSize" type="radio" value="small">'
		  + '<i></i>Small</label>'
		+ '<label class="radio">'
		  + '<input id="rdoButtonSize"4" name="rdoButtonSize" type="radio" value="mini">'
		  + '<i></i>Mini</label>'
	  + '</div>'
	  + '</div>'
	  + '<div class="tubi-grid">'
		+ '<div class="columns horizontal-gutters">'
		 + ' <div class="screen-40">'
		 + '<div class="field">'
		 + '<label>Preview: </label>'
			+ '<div id="divSnippet" class="tubi basic message" style="text-align:center;"> <a class="tubi button" href="">Buy Now</a> </div>'
		  + '</div>'
		  + '</div>'
		  + '<div class="screen-60">'
			+ '<div class="field">'
			 + ' <label>URL: </label>'
			  + '<input id="inpUrl" type="text" value="http://">'
			  + '<label>Button Text: </label>'
			  + '<input id="inpText" type="text" value="Buy Now">'
			+ '</div>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
  + '</section>'
  + '<section class="footer">'
	  + '<div class="tubi two fluid buttons">'
	  + '<button class="redactor_btn_modal_close tubi warning button">Cancel</button>'
	  + '<button class="redactor_modal_action_btn tubi positive button" id="redactorSaveBtn">Insert</button>'
	  + '</div>'
  + '</section>',
  
  
  labels_modal: String()
  + '<section id="redactor-modal-insert-label" class="content-center">'
	  + '<a class="tubi label">Default</a>&nbsp;'
	  + '<a class="tubi label positive">Positive</a>&nbsp;'
	  + '<a class="tubi label teal">Teal</a>&nbsp;'
	  + '<a class="tubi label info">Info</a>&nbsp;'
	  + '<a class="tubi label warning">Warning</a>&nbsp;'
	  + '<a class="tubi label negative">Danger</a>&nbsp;'
	  + '<a class="tubi label purple">Purple</a>'
  + '</section>'
  + '<section class="footer">'
  + '</section>',

  text_modal: String()
  + '<section id="redactor-modal-insert-text" style="overflow:auto;height:500px;">'
	  + '<div id="icomsg">'
		+ '<div class="tubi icon message"> <i class="inbox icon"> </i>'
		  + '<div class="content">'
			+ '<div class="header"> Have you heard about our mailing list? </div>'
			+ '<p>Get all the best inventions in your e-mail every day. Sign up now!</p>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	  + '<div class="tubi celled list">'
		+ '<div class="item"> <a class="right floated tubi small button" data-id="icomsg">Insert</a>'
		  + '<div class="content">'
			+ '<div class="header">Icon Message</div>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	  + '<div id="bmsg">'
		+ '<div class="tubi message">'
		  + '<div class="content">'
			+ '<div class="header"> Welcome back! </div>'
			+ '<p>It\'s good to see you again. I have had a lot to think about since our last visit. </p>'
		  + '</div>'
		+ '</div>'
	 + ' </div>'
	  + '<div class="tubi celled list">'
		+ '<div class="item"> <a class="right floated tubi small button" data-id="bmsg">Insert</a>'
		  + '<div class="content">'
			+ '<div class="header">Basic Message</div>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	  + '<div id="dismsg">'
		+ '<div class="tubi message"> <i class="close icon"> </i>'
		  + '<div class="header"> Congratulations, you are now a member! </div>'
		 + ' <p>Visit our registration page, then try again</p>'
		+ '</div>'
	  + '</div>'
	  + '<div class="tubi celled list">'
		+ '<div class="item"> <a class="right floated tubi small button" data-id="dismsg">Insert</a>'
		  + '<div class="content">'
			+ '<div class="header">Dismissable Message</div>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	  + '<div id="sucmsg">'
		+ '<div class="tubi positive message">'
		 + ' <div class="content">'
			+ '<p>It\'s good to see you again. I have had a lot to think about since our last visit. </p>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	  + '<div class="tubi celled list">'
		+ '<div class="item"> <a class="right floated tubi small button" data-id="sucmsg">Insert</a>'
		  + '<div class="content">'
			+ '<div class="header">Positive Message</div>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	 + ' <div id="negmsg">'
		+ '<div class="tubi negative message">'
		  + '<div class="content">'
			+ '<p>It\'s good to see you again. I have had a lot to think about since our last visit. </p>'
		  + '</div>'
		+ '</div>'
	 + ' </div>'
	  + '<div class="tubi celled list">'
		+ '<div class="item"> <a class="right floated tubi small button" data-id="negmsg">Insert</a>'
		  + '<div class="content">'
			+ '<div class="header">Negative Message</div>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	  + '<div id="infomsg">'
		+ '<div class="tubi info message">'
		  + '<div class="content">'
			+ '<p>It\'s good to see you again. I have had a lot to think about since our last visit. </p>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
	  + '<div class="tubi celled list">'
		+ '<div class="item"> <a class="right floated tubi small button" data-id="infomsg">Insert</a>'
		  + '<div class="content">'
			+ '<div class="header">Info Message</div>'
		  + '</div>'
		+ '</div>'
	 + ' </div>'
	  + '<div id="warmsg">'
		+ '<div class="tubi warning message">'
		 + ' <div class="content">'
			+ '<p>It\'s good to see you again. I have had a lot to think about since our last visit. </p>'
		  + '</div>'
		+ '</div>'
	 + ' </div>'
	  + '<div class="tubi celled list">'
		+ '<div class="item"> <a class="right floated tubi small button" data-id="warmsg">Insert</a>'
		  + '<div class="content">'
			+ '<div class="header">Warning Message</div>'
		  + '</div>'
		+ '</div>'
	  + '</div>'
  + '</section>'
  + '<section class="footer">'
  + '</section>',
  
    init: function() {
        var that = this;
        var dropdown = {};
        
		//Link Buttons
		dropdown['buttons'] = {
			title: 'Buttons',
			callback: function () {
				this.modalInit("Buttons", this.buttons_modal, 640, buttons_callback);
			}
		}

         var buttons_callback = $.proxy(function() {
			$('#inpText, #inpUrl').on('keyup', $.proxy(function (e) {
				this.setButtonPreview();
			}, this));
			
			$('input:radio[name=rdoButtonType], input:radio[name=rdoButtonSize]').on('click', $.proxy(function (e) {
				this.setButtonPreview();
			}, this));
			
	        this.insertButton();
         }, this);

        //Labels
		dropdown['labels'] = {
			title: 'Labels',
			callback: function () {
				this.modalInit("Labels", this.labels_modal, 600, labels_callback);
			}
		}

         var labels_callback = $.proxy(function() {
			$('#redactor-modal-insert-label').on('click', 'a.tubi.label', $.proxy(function (e) {
				var classname = e.target.className;
				this.insertHtml('<span class="' + classname + '">Label</span>&nbsp;');
			}, this));
         }, this);
		 
        //Formatted Text
		dropdown['text'] = {
			title: 'Formatted Text',
			callback: function () {
				this.modalInit("Formatted Text", this.text_modal, 500, text_callback);
			}
		}

         var text_callback = $.proxy(function() {
			$('#redactor-modal-insert-text').on('click', 'a.tubi.button', $.proxy(function (e) {
				$item = e.target;
				id = $($item).data("id");
				html = $("#" + id).html();
				this.insertHtml(html);
				this.modalClose();
			}, this));
         }, this);
		 
        this.buttonAddAfter('horizontalrule', 'snippets', 'Snippets', false, dropdown);
		
    },
	
    setButtonPreview: function () {
		var tmp = $('input:radio[name=rdoButtonType]:checked').val();
		var tmp2 = $('input:radio[name=rdoButtonSize]:checked').val();
		$('#divSnippet a').attr('class', tmp + ' ' + tmp2);
		$('#divSnippet a').html($('#inpText').val());
		$('#divSnippet a').attr('href', $('#inpUrl').val());
    },
	
    insertButton: function () {
        $('#redactorSaveBtn').on('click', $.proxy(function () {
			$html = $('#divSnippet').html();
            this.insertHtml($html);
			this.modalClose();
        }, this));
    },
	 
};