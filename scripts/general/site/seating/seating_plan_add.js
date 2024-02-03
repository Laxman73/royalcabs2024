//FROM AND TO DATE.
jQuery('.dateSel').datepicker({
	dateFormat:'yy-mm-dd',
});

jQuery('#seating_plan_add').click(function() {

	var vTitle=jQuery('#vTitle').val();
	if(jQuery.trim(vTitle).length>0) {

		var seatings=new Array();

		var seatid='';
		var mlaid='';
		jQuery('#seat-container>.seat').each(function() {

			mlaid=jQuery(this).attr('mlaid');
			if(mlaid>0) {

				seatid=jQuery(this).attr('seatid');
				mlaid=jQuery(this).attr('mlaid');

				seatings.push([
					seatid,
					mlaid,
				]);

			}

		});
		var dataString='vTitle='+vTitle+'&seatings='+JSON.stringify(seatings);
		jQuery.ajax({

			type:'POST',
			data:dataString,
			url:'addDetails.php',
			success:function(data){

				//alert(data);

				if(data=='noplan'){
					alertify.log('No Seating Mapped.');
					return;
				}
				if(data=='indraft'){
					alertify.log('Plan Is Already In Draft.');
					return;
				}
				if(data=='error'){
					alertify.error('Error! Kindly Contact Admin.');
					return;
				}

				var res=data.split('^');
				if(res[0]=='success'){
					capture_image(res[1]);
				}
				else{
					alertify.error('There was An Error, Kindly Contact Admin.');
				}

			}

		});

	}
	else{

		alertify.alert('Title Cannot Be Empty',function(){
			jQuery('#vTitle').focus();
		});

	}



});

//CAPTURE IMAGE.
function capture_image(vPic) {

	if(vPic.length>0){

		jQuery('#img_name').val(vPic);

		jQuery('#seat-container').html2canvas({

			onrendered: function (canvas){

				$('#img_val').val('').val(canvas.toDataURL("image/png"));
                                
				$("#capture_img_form").ajaxForm({
					target:'',
					success:function(data){

						jQuery('<div>')
						.html('<center><b>Seating Plan Added Successfully..</b></center>')
						.dialog({
							title:'Success Message',
							modal:true,
							buttons:{
								'Ok':function(){
									location.assign('seating_plan_list.php');
								},
								'Add New':function(){
									location.reload(true);
								}
							},
							close:function(){
								location.reload(true);
							}
						});

					}
				})
				.submit();

			}

		});

	}

}

//DRAGGABLE
my_draggable();
function my_draggable(){
	jQuery('.member-ul>li')
	.draggable()
	.draggable('destroy')
	.draggable({
		zIndex:1000,
		helper:function(){
			return jQuery('<span>')
			.css({
				'background-color':'#'+jQuery(this).attr('partycolor'),
				'width':'40px',
				'height':'40px',
				'line-height':'40px',
				'text-align':'center',
				'position':'absolute',
				'-webkit-box-shadow':'inset -5px -6px 45px -3px rgba(255,255,255,0.75)',
				'-moz-box-shadow':'inset -5px -6px 45px -3px rgba(255,255,255,0.75)',
				'box-shadow':'inset -5px -6px 45px -3px rgba(0,0,0,0.75)',
				'color':'#FFFFFF'
			})
			.text('MLA')
		}
	});
}

//DROPPABLE
jQuery('.seat').droppable({

	accept:'.member-ul>li',
	drop:function(event,ui) {

		var thismlaid=jQuery(this).attr('mlaid');
		if(!thismlaid){

			var mlaName=ui.draggable.text();
			var mlaid=ui.draggable.attr('mlaid');
			var partyid=ui.draggable.attr('partyid');
			var partyname=ui.draggable.attr('partyname');
			var partysname=ui.draggable.attr('partysname');
			var partycolor='#'+ui.draggable.attr('partycolor');

			jQuery(this)
			.css({
				'background-color':partycolor,
			})
			.attr({
				'mlaName':mlaName,
				'mlaid':mlaid,
				'partyid':partyid,
				'partyname':partyname,
				'partysname':partysname,
				'partycolor':partycolor,
				'title':mlaName+' ('+partysname+')',
			})
			.tooltip();

			ui.draggable.remove();

		}
		else{

			alertify.log('Seat Already Occupied.');

		}

	}

})
.click(function(){

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

				'Remove':function(){

					var mlaid=jQuery('[seatid="'+seatid+'"]').attr('mlaid');
					var mlaname=jQuery('[seatid="'+seatid+'"]').attr('mlaname');
					var partyid=jQuery('[seatid="'+seatid+'"]').attr('partyid');
					var partyname=jQuery('[seatid="'+seatid+'"]').attr('partyname');
					var partysname=jQuery('[seatid="'+seatid+'"]').attr('partysname');
					var partycolor='#'+jQuery('[seatid="'+seatid+'"]').attr('partycolor');

					//PLACE MLA BACK TO LIST.
					jQuery('<li>')
					.css({
						'background-color':partycolor,
						'-webkit-box-shadow':'inset -5px -6px 45px -3px rgba(255,255,255,0.75)',
						'-moz-box-shadow':'inset -5px -6px 45px -3px rgba(255,255,255,0.75)',
						'box-shadow':'inset -5px -6px 45px -3px rgba(0,0,0,0.75)',
						'color':'#FFFFFF'
					})
					.attr({
						'mlaid':mlaid,
						'mlaName':mlaName,
						'partyid':partyid,
						'partyname':partyname,
						'partysname':partysname,
						'partycolor':partycolor,
					})
					.text(mlaname)
					.prependTo('.member-ul');

					my_draggable();

					//REMOVE CSS OF SEAT.
					jQuery('[seatid="'+seatid+'"]').css({
						'background-color':'',
						'-webkit-box-shadow':'',
						'-moz-box-shadow':'',
						'box-shadow':'',
						'color':'#000000'
					});

					//REMOVE ATTRIBUTES OF SEAT.
					jQuery('[seatid="'+seatid+'"]')
					.removeAttr('title mlaid mlaname partyid partyname partycolor')
					.tooltip('destroy')

					jQuery(this).dialog('destroy');

				},
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

