jQuery('.copy_seating_plan').click(function() {
    var seatingPlanId = jQuery(this).next('.seating_plan_id').val();
    var dataString = 'seatingPlanId='+seatingPlanId;
    jQuery.ajax({
        type:'POST',
        data:dataString,
        url:'copy_seating_plan.php',
        success:function(data){
            if(data=='error'){
                alertify.error('Error! Kindly Contact Admin.');
                return;
            }
            var res=data.split('^');
            if(res[0]=='success'){
                location.reload(true);
            }
            else{
                alertify.error('There was An Error, Kindly Contact Admin.');
            }
        }
    });
});