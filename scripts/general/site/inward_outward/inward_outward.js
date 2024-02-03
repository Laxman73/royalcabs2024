//DROPDOWN.
function getNameDD(iDEPID, iMarkedStaffId) {
    var dataString='iDEPID='+iDEPID+'&iMarkedStaffId='+iMarkedStaffId;
	jQuery.ajax({
		type:'POST',
                data: dataString,
		url:'/goalsoft_new/ctrl/inward_outward_dept_wise_staff_dd',
		success:function(html){
			jQuery('#name_container').html(html);
//			jQuery("#iStaffID").myValidation({
//				type:'text',
//				submitBtnId:'#login_submit',
//			});

		}
	});

}

jQuery(document).ready(function() {

//ONLOAD.
var iDepID=jQuery('#iDepID').val();
var iMarkedStaffId=jQuery('#iMarkedStaffId').val();
getNameDD(iDepID, iMarkedStaffId);

//ONCHANGE.
jQuery('#iDepID').change(function(){
	var iDepID=jQuery(this).val();
        var iMarkedStaffId=0;
	getNameDD(iDepID, iMarkedStaffId);
});


//CHANGE STATUS.
jQuery('.status').click(function() {

	var s_recordid=jQuery(this).attr('s_recordid');
	var s_recordname='iFMID';
	var table='filemovement';
	var field='cStatus';
	var field_A='A';
	var field_I='I';
	var dataString='s_recordid='+s_recordid+'&s_recordname='+s_recordname+'&table='+table+'&field='+field+'&field_A='+field_A+'&field_I='+field_I;
	jQuery.ajax({

		type:'POST',
		url:'/goalsoft_new/ctrl/inward_outward_change_status.php',
		data:dataString,
		success:function(data) {

			//alert(data);

			if(data==field_A){

				jQuery('[s_recordid="'+s_recordid+'"] a')
				.html('<img src="../images/general/active.png'+'">');

				alertify.success('Status Set To Active.');

			}
			else if(data==field_I){

				jQuery('[s_recordid="'+s_recordid+'"] a')
				.html('<img src="../images/general/inactive.png'+'">');

				alertify.log('Status Set To Inactive.');

			}
			else{

				alertify.error('Opps! There Was An Error.');

			}

		}

	});

});

//DELETION.
jQuery('.del').click(function() {

	var d_recordid=jQuery(this).attr('d_recordid');
	var dataString='action=2&d_recordid='+d_recordid;

	jQuery('<div>')
	.html('<center>Do You Really Want To Delete This ?</center>')
	.dialog({

		title:'Delete Message',
		modal:true,
		minHeight:150,
		minWidth:400,
		draggable:true,
		buttons:{
			'Yes': function() {

				jQuery.ajax({
					type:'POST',
					url:'/goalsoft_new/ctrl/inward_outward_ajax.php',
					data:dataString,
					success:function(data){

						if(data==1){
							jQuery('[recordid="'+d_recordid+'"]').remove();
							alertify.success('Deleted Successfully.');
						}
						else{
							alertify.error('Oops! There Was An Error.');
						}
					}
				});

				jQuery(this).dialog( "destroy" );

			},
			'No': function() {
				jQuery( this ).dialog( "destroy" );
			}
		}

	});

});

jQuery('#search-io').click(function(){
        var cFlag=jQuery('#cFlag').val();
        var fromdate=jQuery.trim(jQuery('#fromdate').val());
        var todate=jQuery.trim(jQuery('#todate').val());

        location.assign('inward_outward.php?cFlag='+cFlag+'&fromdate='+fromdate+'&todate='+todate);
});





















































});