<?php
defined('BASEPATH') or exit('No direct script access allowed');
$form_id = 'idFormBatch';
?>

<form id="<?php echo $form_id; ?>" class="form-horizontal">
    <!-- Default box -->
    <div class="card">
        <div class="card-body">
            <div class="card-body table-responsive p-0">
                <table id="idTableBatch" class="table table-bordered table-striped table-hover" style="font-size: 80%;">
                    <thead>
                        <tr style="text-align: center;">
                            <th style="background-color: burlywood;">DatatexCode</th>
                            <th style="background-color: burlywood;">DatatexClassif</th>
                            <th>ItemID</th>
                            <th>Classif</th>
                            <th>SubClassif</th>
                            <th>ContentName</th>
                            <th>Material</th>
                            <th>ReferenceName</th>
                            <th>ColorName</th>
                            <th>ConstructionName</th>
                            <th>SpecType</th>
                            <th>SpecName</th>
                            <th>ItemType</th>
                            <th>Source</th>
                            <th>UmID</th>
                            <th style="background-color: burlywood;">DatatexUmID</th>
                            <th>CreatedBy</th>
                            <th>CreatedAt</th>
                            <th style="background-color: red;">#</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="text-align: center;">
                            <th>DatatexCode</th>
                            <th>DatatexClassif</th>
                            <th>ItemID</th>
                            <th>Classif</th>
                            <th>SubClassif</th>
                            <th>ContentName</th>
                            <th>Material</th>
                            <th>ReferenceName</th>
                            <th>ColorName</th>
                            <th>ConstructionName</th>
                            <th>SpecType</th>
                            <th>SpecName</th>
                            <th>ItemType</th>
                            <th>Source</th>
                            <th>UmID</th>
                            <th>DatatexUmID</th>
                            <th>CreatedBy</th>
                            <th>CreatedAt</th>
                            <th style="background-color: red;">#</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button class="btn btn-sm btn-danger" id="idbtnSubmit<?php echo $form_id; ?>" onclick="action_deletebatch('<?php echo $form_id; ?>')"> <i class="fas fa-trash"></i> Delete Batch </button>
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
</form>

<script>
    // Setup - add a text input to each footer cell
    $('#idTableBatch tfoot th').each(function() {
        var title = $(this).text();
        if ((title != 'CreatedBy') && (title != 'CreatedAt')) {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            if (title == '#') {
                $(this).html('<input type="checkbox" id="checkAll" />');
            }
        }

    });

    var tblBatch = $("#idTableBatch").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "search": {
            return: true,
        },
        "seacrhDelay": 500,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "serverSide": true,
        "scrollX": true,
        "scrollY": "250",
        "select": true,
        "pageLength": 50,
        "lengthMenu": [50, 100, 150, 200, 250],
        "fixedColumns": {
            left: 1,
            right: 1
        },
        "ajax": "<?php echo base_url() . $class_link; ?>/ajax",
        "order": [17, 'desc'],

        "initComplete": function() {
            // Apply the search
            this.api()
                .columns()
                .every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup', function(e) {
                        if (e.keyCode == 13) {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        }
                    });
                });
        },

        "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [16, 17]
            },
            {
                "searchable": false,
                "orderable": false,
                "targets": 18,
                "data": null,
                "render": function(data, type, row, meta) {

                    return '<input type="checkbox" class="clCheckboxItem" name="dtmitem_ids[]" value="' + data[18] + '" />';
                }
            },
            //     {
            //         "targets": [4, 5, 6],
            //         className: 'dt-body-right'
            //     }
        ],
    });

    $('#checkAll').click(function() {
        $('.clCheckboxItem').prop('checked', this.checked);
    });

    function reload_tablebatch() {
        tblBatch.ajax.reload();
    }

    function action_deletebatch(form_id) {
        event.preventDefault();
        var conf = confirm('Are you sure ?');
        if (conf) {
            var form = $('#' + form_id)[0];

            // Loading animate
            $('#idbtnSubmit' + form_id).html('<i class="fa fa-spinner fa-pulse"></i> Loading');
            $('#idbtnSubmit' + form_id).attr('disabled', true);

            $.ajax({
                url: '<?php echo base_url() . $class_link . '/action_deletebatch' ?>',
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.code == 200) {
                        toggle_modal('', '');
                        reload_table();
                        toastAlert('success', data.messages);
                    } else if (data.code == 400) {
                        toastAlert('error', data.messages);
                        generateToken(data._token);
                    } else {
                        toastAlert('error', 'Unknown Error');
                        generateToken(data._token);
                    }
                },
                complete: function(dt) {
                    // Loading animate
                    $('#idbtnSubmit' + form_id).html('<i class="fa fa-trash"></i> Delete Batch');
                    $('#idbtnSubmit' + form_id).attr('disabled', false);
                }
            });
        }
    }
</script>