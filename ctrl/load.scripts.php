<!--SCRIPTS INCLUDES-->

<!--CORE-->
<script src="dist/assets/js/scripts-init/jquery-3.4.1.js"></script>
<script src="dist/assets/js/scripts-init/bootstrap.bundle.min.js"></script>
<script src="dist/assets/js/scripts-init/metismenu.js"></script>
<script src="dist/assets/js/scripts-init/app.js"></script>
<script src="dist/assets/js/scripts-init/demo.js"></script>

<!--DataTables-->
<script src="dist/assets/js/vendors/jquery.dataTables.min.js"></script>
<script src="dist/assets/js/vendors/dataTables.bootstrap4.min.js"></script>
<script src="dist/assets/js/vendors/dataTables.responsive.min.js"></script>
<script src="dist/assets/js/vendors/responsive.bootstrap.min.js"></script>

<!--Perfect Scrollbar -->
<script src="dist/assets/js/vendors/scrollbar.js"></script>
<script src="dist/assets/js/scripts-init/scrollbar.js"></script>

<!--Bootstrap Tables-->
<script src="dist/assets/js/vendors/tables.js"></script>

<!-- sweet alerts -->
<script src="dist/assets/js/vendors/sweetalert2.js"></script>
<script src="dist/assets/js/scripts-init/sweet-alerts.js"></script>
<!-- <script src="/dist/assets/js/scripts-init/sweetalert2.js" type="text/javascript"></script> -->

<script src="dist/assets/js/vendors/form-components/bootstrap-multiselect.js"></script>
<script src="dist/assets/js/scripts-init/form-components/select2.min.js"></script>
<script src="dist/assets/js/scripts-init/form-components/input-select.js"></script>

<script type="text/javascript" src="bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>


<!--Datepickers-->
<script src="dist/assets/js/vendors/form-components/moment.js"></script>
<script src="dist/assets/js/vendors/form-components/datepicker.js"></script>
<script src="dist/assets/js/vendors/form-components/daterangepicker.js"></script>
<script src="dist/assets/js/scripts-init/form-components/datepicker.js"></script>

<script src="dist/assets/js/vendors/form-components/ckeditor.js"></script>

<!-- Form Validations Js -->
<script src="dist/assets/js/vendors/form-components/form-validation.js"></script>


<script type="text/javascript" src="../scripts/jquery-sortable.js"></script>
<script src="../scripts/common.js"></script>
<script src="../scripts/ajax.js"></script>

<script type="text/javascript">
function InitDatePicker() {
	$(".datepicker").datepicker({
		format: 'dd-mm-yyyy',
		autoHide: true,
		startDate: '-0m',
	});
}

// generic on ready load scripts
$(document).ready(function(){
	InitDatePicker();		
	
	// var elmnt = document.getElementById("scrollSideMenu");
	// elmnt.scrollIntoView();
});
</script>