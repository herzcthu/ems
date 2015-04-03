$(document).ready(function ($) {
    $( 'form' ).garlic();
    $('#popupModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var info = button.data('mainquestion') // Extract info from data-* attributes
        var question = button.data('subquestion')
        var answers = button.data('answers')
        var answersonly = button.data('answersonly')
        var notes = button.data('notes')
        var notequestion = button.data('notequestion')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)

        if (typeof question !== 'undefined') {
            modal.find('.modal-title').text(info)
            modal.find('.modal-body span').html(question)
            modal.find('.modal-body span').append("&nbsp;" + answers)
        } else if (typeof notes !== 'undefined') {
            modal.find('.modal-title').text(notequestion)
            modal.find('.modal-body span').html("&nbsp;" + notes)
        } else {
            modal.find('.modal-title').text(info)
            modal.find('.modal-body span').html("&nbsp;" + answersonly)
        }
    });
    $('#datatable-allfeatures').dataTable({
        "scrollX": true,
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [0]}
        ]
    });
    $('#datatable-results').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        "sScrollX": "90%",
        "bScrollCollapse": true
       });
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-3d'
    });
    $('.dobdatepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('.year-picker').datepicker({
        format: 'yyyy',
        startView: 2,
        minViewMode: 2
        //defaultViewDate: year
    });
    $('.month-picker').datepicker({
        format: 'mm',
        startView: 1,
        minViewMode: 1
        //defaultViewDate: year
    });
    $('.date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });
    $('.time-picker').timepicker({
        showMeridian: false,
        showInputs: false,
        disableFocus: true
    });
    // http://www.sanwebe.com/2014/01/how-to-select-all-deselect-checkboxes-jquery
    $('#cb').click(function (event) {  //on click
        if (this.checked) { // check select status
            $('.cb').each(function () { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        } else {
            $('.cb').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });

    $(".mainhide").click(function(){
        $("#main-question-list").hide();
    });

    $(".mainshow").click(function(){
        $("#main-question-list").show();
    });

});