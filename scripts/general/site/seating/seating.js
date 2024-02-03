//ADD.
jQuery('#add').click(function(){

	if(cApprove=='A') {

		jQuery('<div>')
		.html('<center>Create Draft Of Existing Plan or Create Fresh Draft ? </center>')
		.dialog({
			title:'Add Draft',
			modal:true,
			buttons:{
				'Draft Of Existing Plan':function() {

					var dataString=site.csrf_name+'='+site.csrf_value;
					jQuery.ajax({

						type:'POST',
						data:dataString,
						url:site.base_url()+'seating/draft_of_existing_plan',
						success:function(data){

							if(data=='success'){
								location.assign(site.base_url()+'seating/edit');
							}
							else{
								location.assign(site.base_url()+'seating/add');
							}

						}

					});

					jQuery(this).dialog('destroy');

				},
				'Fresh':function(){

					jQuery(this).dialog('destroy');
					location.assign(site.base_url()+'seating/add');

				}

			}

		});

	}
	else{

		location.assign(site.base_url()+'seating/add');

	}

})

//APPROVE.
jQuery('#approve').click(function(){
        var seatingPlanId = jQuery('#approve').data('id');
	jQuery('<div>')
	.html('<center>Approve This</center>')
	.dialog({
		title:'Approve Message',
		modal:true,
		buttons:{
			'Yes':function(){

				var dataString='seatingPlanMasterId='+seatingPlanId;
				jQuery.ajax({

					type:'POST',
                                        data: dataString,
					url:'/goalsoft_new/ctrl/seatingApprove.php',
					success:function(data){

						if(data>0){
							alertify.success('Approved.',1000);
							setInterval(function(){
								location.assign('seating_plan_list.php');
							},2000);
						}
						else{
							alertify.log('There Was No Update.',1000);
							setInterval(function(){
								location.assign('seating_plan_list.php');
							},2000);
						}

					}

				});

				jQuery(this).dialog('destroy');

			},
			'No':function(){

				jQuery(this).dialog('destroy');

			}

		}
	});

});

//DELETE.
jQuery('#delete').click(function(){
        var seatingPlanId = jQuery('#delete').data('id');
	jQuery('<div>')
	.html('<center>Delete This</center>')
	.dialog({
		title:'Delete Message',
		modal:true,
		buttons:{
			'Yes':function(){

				var dataString='seatingPlanMasterId='+seatingPlanId;
				jQuery.ajax({

					type:'POST',
                                        data: dataString,
					url:'/goalsoft_new/ctrl/seatingDelete.php',
					success:function(data){

						if(data>0){
							alertify.success('Deleted Successfully.',1000);
							setInterval(function(){
								location.assign('seating_plan_list.php');
							},2000);
						}
						else{
							alertify.log('There Was No Update.',1000);
							setInterval(function(){
								location.assign('seating_plan_list.php');
							},2000);
						}

					}

				});

				jQuery(this).dialog('destroy');

			},
			'No':function(){

				jQuery(this).dialog('destroy');

			}

		}
	});

});

//SHOW DETAILS.
jQuery('.seat').click(function(){

	var seatid=jQuery(this).attr('seatid');
	var seatno=jQuery(this).attr('seatno');
	var mlaid=jQuery(this).attr('mlaid');
	if(mlaid>0){

		var mlaName=jQuery(this).attr('mlaname');
		var partyid=jQuery(this).attr('partyid');
		var partyname=jQuery(this).attr('partyname');
		var partysname=jQuery(this).attr('partysname');
		var partycolor='#'+jQuery(this).attr('partycolor');

		jQuery('<div>')
		.html(

			'<div><label>MLA Name&nbsp;:&nbsp;</label>'+mlaName+'</div>'+
			'<div><label>Party Name&nbsp;:&nbsp;</label>'+partyname+'</div>'+
			'<div><label>Seat No&nbsp;:&nbsp;</label>'+seatno+'</div>'

		)
		.dialog({
			title:'MLA Details',
			modal:true,
			minWidth:400,
			buttons:{
				'Ok':function(){
					jQuery(this).dialog('destroy');
				}
			}
		})

	}
	else{
		alertify.log('No MlA Positioned For This Seat.');
	}

});

//SET WARNING FOR NEW LAYOUT.
jQuery('#newlayout').click(function() {

	jQuery('<div>')
	.html('<center>Changing Layout Will Delete Existing PLan<br> Do You Really want To Do This.</center>')
	.dialog({
		title:'Warning Message',
		modal:true,
		show: {
			effect: "highlight",
			duration: 800
		},
		buttons:{
			'Yes':function(){

				var dataString=site.csrf_name+'='+site.csrf_value;
				jQuery.ajax({

					type:'POST',
					data:dataString,
					url:site.base_url()+'seating/delete_all_plans',
					success:function(data){

						location.assign(site.base_url()+'seating/layout');

					}

				});

			},
			'No':function(){
				jQuery(this).dialog('destroy');
			}
		}
	});

});