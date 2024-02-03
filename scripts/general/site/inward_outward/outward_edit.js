//ADD.
jQuery("#iSerNo").myValidation({
	type:'text',
	submitBtnId:'#editDetails',
});
jQuery("#vAddressed").myValidation({
	type:'text',
	submitBtnId:'#editDetails',
});
jQuery("#fStampAmt").myValidation({
	type:'text',
	submitBtnId:'#editDetails',
});

//ADDRESSEE.
jQuery('#vAddressed_ref').change(function(){

	var thisVal=jQuery(this).val();
	var vAddressedVal=jQuery.trim(jQuery('#vAddressed').val());
	
	var sep='';
	if(vAddressedVal.length>0){
		sep=', ';
	}
	
	jQuery('#vAddressed').val(vAddressedVal+sep+thisVal);

});

jQuery('#editDetails').click(function() {
	
	var iSerNo=jQuery("#iSerNo").attr('valid');
	var vAddressed=jQuery("#vAddressed").attr('valid');
	var fStampAmt=jQuery("#fStampAmt").attr('valid');
	
	if( iSerNo=='valid' && vAddressed=='valid' && fStampAmt=='valid' ) {
	
		jQuery('#editDetails').hide();
		jQuery('#loading').show();

		jQuery("#editDetailsForm").ajaxForm({
			target: '',
			success: function(str) {

				jQuery('#editDetails').show();
				jQuery('#loading').hide();
				
				//alert(str);

				if(str=='error'){
					alertify.error('There Was An Error.');
					return;
				}

				var lastPipePos=str.lastIndexOf('|');
				var cleanData=str.substring(0,lastPipePos);
				var data_arr=cleanData.split('|');

				var strlen=str.length;
				var laststr=str.substr((strlen-1),1);
				if(laststr=='|'){
					var purestr=str.substr(0,(strlen-1));
				}
				else{
					var purestr=str;
				}
				
				var arr=purestr.split('|');
				for( var i=0; i<arr.length; i++ ) {

					var subarr=arr[i].split('^');

					if(subarr[0]=='db') {

						//DB RECORD ID.
						var recId=subarr[1];
						if(recId<1) {
							return;
						}

						if(subarr[2]>0) {
							alertify.success('Details Updated Successfully');
						}
						else {
							alertify.log('No Details Updated');
						}

					}
					else if(subarr[0]=='image') {

						if(subarr[1]=='success') {
							alertify.success("IMAGE Uploaded Successfully.");
						}
						else if(subarr[1]=='failed') {
							alertify.error("Oops! There was an error while uploading IMAGE .");
						}
						else if(subarr[1]=='sizelimit') {
							alertify.error("Oops! Max IMAGE Size Allowed 10MB .");
						}
						else if(subarr[1]=='invalidformat') {
							alertify.error("Oops! Invalid IMAGE Selected .");
						}
						else if(subarr[1]=='noimage') {
							alertify.error("Oops! No IMAGE Selected .");
						}
						else {
							alertify.error("Oops! There was an error while uploading IMAGE .");
						}

					}
					else if(subarr[0]=='file') {

						if(subarr[1]=='success') {
							alertify.success("File Uploaded Successfully.");
						}
						else if(subarr[1]=='failed') {
							alertify.error("Oops! There was an error while uploading FILE .");
						}
						else if(subarr[1]=='sizelimit') {
							alertify.error("Oops! Max FILE Size Allowed 10MB .");
						}
						else if(subarr[1]=='invalidformat') {
							alertify.error("Oops! Invalid FILE Selected .");
						}
						else if(subarr[1]=='noimage') {
							alertify.error("Oops! No FILE Selected .");
						}
						else {
							alertify.error("Oops! There was an error while uploading FILE .");
						}

					}

				}

			}
		}).submit();

	}

});	
