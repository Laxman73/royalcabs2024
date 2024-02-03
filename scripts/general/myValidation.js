(function($){

$.fn.myValidation=function(options){

	var settings=$.extend({

		type:'text',
		submitBtnId:false,
		insertAfter:false,

		minLength:1,
		maxLength:254,

		//For confirm password purpose
		confirmWithId:false,
		
		//FILE PROPERIES
		iValidFormats:['jpg', 'png', 'gif', 'bmp','jpeg','pjpeg'],
		iValidTypes:['image/pjpeg','image/jpeg','image/jpg','image/png','image/gif','image/bmp'],
		iMaxSize:5,
		fValidFormats:['pdf', 'doc', 'docx', 'xls','xlsx','ppt','pptx'],
		fValidTypes:['application/pdf',
		'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
		'application/vnd.ms-excel','application/vnd.ms-excel.addin.macroenabled.12',
		'application/vnd.ms-excel.sheet.binary.macroenabled.12',
		'application/vnd.ms-excel.template.macroenabled.12',
		'application/vnd.ms-excel.sheet.macroenabled.12',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation',
		'application/vnd.ms-powerpoint']

	},options)


	return this.each(function(){

		var id=$(this).attr('id');
		var thisSel=$(this);
		var thisName=$(this).attr('name');

		// EMAIL VALIDATION CODE
		if(settings.type=='email'){

			// ON FORM SUBMIT VALIDATION.
			$(settings.submitBtnId).click(function(ev){
				ev.preventDefault();
				emailValidate();
			});

			// KEYUP VALIDATION.
			thisSel.on('keyup change',function(ev) {
				emailValidate();
			});

			function emailValidate(){

				var keyEmailIdValue=thisSel.val();
				var keyEmailIdLength=keyEmailIdValue.length;

				var keyatpos=keyEmailIdValue.indexOf('@');
				var keydotpos=keyEmailIdValue.lastIndexOf('.');


				if(keyEmailIdLength>=5 && keyatpos>1 && keydotpos>keyatpos+2 && keydotpos+3<=keyEmailIdLength && keyEmailIdValue!="" && keyEmailIdValue!=null){

					removeCustomAlert()
					return true;

				}
				else if(keyEmailIdLength<=0 || keyEmailIdValue==''){

					customAlert('Emailid is required.');
					return false;

				}
				else if(keyEmailIdLength>=1 && keyEmailIdLength<=5 && keyEmailIdValue!=''){

					customAlert('Email address must be between 6 and 254 characters.');
					return false;

				}
				else if(keyEmailIdLength>=6 && keyEmailIdValue.length<=254 && keyEmailIdValue!=""){

					customAlert("Enter a valid email address.");
					return false;

				}

			}

		}
		// TEXT INPUT VALIDATION
		else if(settings.type=='text' || settings.type=='password'){

			// ON FORM SUBMIT VALIDATION.
			$(settings.submitBtnId).click(function(ev){
				ev.preventDefault();
				textValidate();
			});

			// KEYUP VALIDATION.
			thisSel.on('keyup change',function() {
				textValidate();
			});

			function textValidate(){

				var keyTextIdValue=thisSel.val();
				var keyTextIdLength=keyTextIdValue.length;
				//alert(keyTextIdLength);
				if(keyTextIdLength<=0){
					customAlert('Cannot be empty.')
					return false;
				}
				else if(keyTextIdLength>=1 && keyTextIdLength<settings.minLength){
					customAlert('Should be between  '+settings.minLength+' to '+settings.maxLength+' char long');
					return false;
				}
				else if(keyTextIdLength>=settings.minLength){
					removeCustomAlert();
					return true;
				}

			}

		}
		// CONFIRM PASSWORD
		else if(settings.type=='confirmPassword'){

			// ON FORM SUBMIT VALIDATION.
			$(settings.submitBtnId).click(function(ev){
				ev.preventDefault();
				confirmPwdValidate();
			});

			// KEYUP VALIDATION.
			thisSel.on('keyup change',function() {
				confirmPwdValidate();
			});

			function confirmPwdValidate(){

				var confirmPwdValue=thisSel.val();
				var pwdValue=$(settings.confirmWithId).val();

				if(confirmPwdValue==''){
					customAlert('Confirm your new password.')
					return false;
				}
				else if(confirmPwdValue!=pwdValue){

					customAlert('Password does not match.')
					return false;

				}
				else if(confirmPwdValue!=='' && confirmPwdValue==pwdValue){
					removeCustomAlert();
					return true;
				}

			}

		}
		// TEXT INPUT VALIDATION
		else if(settings.type=='iFile') {
		
			// ON FORM SUBMIT VALIDATION.
			$(settings.submitBtnId).click(function(ev){
				ev.preventDefault();
				fileValidate();
			});

			// KEYUP VALIDATION.
			thisSel.on('change',function() {
				fileValidate();
			});

			function fileValidate() {
			
				var fileInput = document.getElementById(thisName);
				var files = fileInput.files;
				var allowedImgTypes = settings.iValidTypes;
				var allowedImgFormats = settings.iValidFormats;

				//CHECKING FILE TYPE.
				var typeFlag=false;
				for (var i = 0; i < files.length; i++) {
					if (allowedImgTypes.indexOf(files[i].type) > -1) {
						//alert(files[i].type);
						typeFlag=true;
					}
					else {
						typeFlag=false;
					}
				}
				
				//CHECKING FILE FORMAT.
				var formatFlag=false;
				for (var i = 0; i < files.length; i++) {
					var imgName=files[i].name;
					var imgLsInx=files[i].name.lastIndexOf('.')
					var imgExt=files[i].name.substring(imgLsInx+1);
					//alert(imgExt);
					if (allowedImgFormats.indexOf(imgExt) > -1) {
						//alert(files[i].name);
						formatFlag=true;
					}
					else {
						formatFlag=false;
					}
				}
				
				//CHECKING FILE SIZE.
				var sizeFlag=false;
				for (var i = 0; i < files.length; i++) {
					if (files[i].size>settings.iMaxSize) {
						var imgMB=Math.ceil((files[i].size)/1024)
						//alert(imgMB);
						sizeFlag=true;
					}
					else {
						sizeFlag=false;
					}
				}
				
				//CHECKING FILE LENGTH.
				var lenFlag=false;
				if(files.length>0){
					lenFlag=true;
				}
				else{
					lenFlag=false;
				}
				
				//THROW MESSAGES.
				if(lenFlag===false){
					customAlert('Cannot be empty.')
					return false;
				}
				else if(sizeFlag===false){
					customAlert('Max File Size Allowed Is '+settings.iMaxSize+'MB.');
					return false;
				}
				else if(formatFlag===false){
					customAlert('Invalid File Format.');
					return false;
				}
				else if(typeFlag===false){
					customAlert('Invalid File Type.');
					return false;
				}
				else if( lenFlag===true && sizeFlag===true && formatFlag===true && typeFlag===true ){
					removeCustomAlert();
					return true;
				}

			}

		}

		//********************************************//
		// CUSTOM ALERT
		function customAlert(msg) {
			
			thisSel.focus();

			thisSel.attr('title',msg)
			.tooltip({
				tooltipClass:'ui-state-error',
				content:msg,
				position: {
					my: "left top",
					at: "right-40 top-35",
					using: function( position, feedback ) {
						$( this ).css(position);
						$( "<div>" )
						.addClass( "arrow" )
						.addClass( feedback.vertical )
						.addClass( feedback.horizontal )
						.appendTo( this );
					}
				}
			})
			.tooltip("enable")
			.tooltip("open")
			.attr('valid','invalid');

			$('.ui-tooltip').mouseleave(function(){
				$(this).remove();
			});

		}

		function removeCustomAlert(){

			thisSel.tooltip()
			.tooltip("disable")
			.attr('title','')
			.attr('valid','valid');

		}

	});


}


}(jQuery));