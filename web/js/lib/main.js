//(un)select all function
function CheckAllBox(ref, name) {
	var form = ref;

	while (form.parentNode && form.nodeName.toLowerCase() != 'form') { form = form.parentNode; }
    var elements = form.getElementsByTagName('input');
    
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].type == 'checkbox' && elements[i].name == name) {
            elements[i].checked = ref.checked;
        }
    }
}

//Form exit (via Modal Bootstrap Twitter)
function FormExit(form, title, message, btn) {
	var isEdit = false;
	$("input,select,textarea").parents(form).change(function() {isEdit = true;});
	$("a[href][target!='_blank'][data-toggle!='tab'][data-toggle!='dropdown']").not("[data-dismiss]").click(function (event) {
		if(isEdit) {
			event.preventDefault();
			
			$("body").append("<div id='FormExitModal' class='modal fade'><div class='modal-dialog'><div class='modal-content'><div class='modal-header'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button><h3>" + title + "</h3></div><div class='modal-body'>" + message + "</div><div class='modal-footer'><a class='btn btn-primary' data-dismiss='modal'>" + btn.cancel + "</a><a href='" + event.target.href + "' class='btn btn-danger'>" + btn.exit + "</a></div></div></div></div>");

			$("#FormExitModal").modal();
		}
	});
}

//Affix (with Bootstrap Twitter)
function Affix(div, offset) {
	offset = ((typeof offset !== 'undefined') ? offset : {});
	$(div).affix({
		offset: offset
	}); 
	$(div).width($(div).parent().width());
}

//Select (with bootstrap-select)
$(".selectpicker").selectpicker({});

//Datetimepicker (with bootstrap-datetimepicker)
$(".datepicker").datetimepicker({
	format: "dd/mm/yyyy",
	maxView: 3,
	minView: 2,
	weekStart: 1,
    autoclose: true,
    todayHighlight: true,
    todayBtn: "linked",
});
$(".datetimepicker").datetimepicker({
	format: "dd/mm/yyyy hh:ii",
	maxView: 3,
	minView: 0,
	weekStart: 1,
	minuteStep: 15,
    autoclose: true,
    todayHighlight: true,
    todayBtn: "linked",
});