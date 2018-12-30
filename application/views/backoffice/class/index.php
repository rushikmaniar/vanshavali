<div class="card">
    <div class="card-body">
        <div class="col-sm-12 col-md-12">
            <button type="button" class="btn btn-success btn-top" id="btn_add_user"
                    onclick="ajaxModel('backoffice/ClassManagement/viewAddClassModal','Add New Class','modal-lg')">
                <i class="fa fa-plus"></i> Add Class
            </button>
        </div>
        <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="ClassTable">
            <thead>
            <tr>
                <th>Class Code</th>
                <th>Class Name</th>
                <th>Department Code</th>
                <th>Department Name</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($class_data as $row): ?>
                <tr>
                    <!-- Class Code -->
                    <td><?= $row['class_id'] ?></td>
                    <td><?= $row['class_name'] ?></td>
                    <td><?= ($row['dept_id']) != '' ? $row['dept_id'] : 'No Department'; ?></td>
                    <td><?= ($row['dept_name']) != '' ? $row['dept_name'] : 'No Department'; ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm" data-tooltip="<?= ($row['entries'] == 0)?'Edit class':'Delete Entries in Entry Table To Edit Class'?>"
                                    data-container="body" title="Edit User"
                                    <?= ($row['entries'] != 0)?'disabled="disabled"':''?>
                                    onclick="ajaxModel('backoffice/ClassManagement/viewEditClassModal/<?= $row['class_id'] ?>','Edit Class',800)">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm"
                                    data-tooltip="<?= ($row['entries'] == 0)?'Edit class':'Delete Entries in Entry Table To Delete Class'?>"
                                    <?= ($row['entries'] != 0)?' disabled="disabled" ':''?>
                                    data-container="body" title="Delete Class" onclick="deleteClass(<?= $row['class_id'] ?>)">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<script>
    $(document).ready(function () {

        $('#ClassTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
    /*************************************
     Delete Class
     *************************************/
    function deleteClass(class_id) {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {

            $.ajax({
                url: base_url + "backoffice/ClassManagement/deleteClass",
                type: "POST",
                dataType: "json",
                data: {"class_id": class_id},
                success: function (result) {
                    if (result.code == 1 && result.code != '') {
                        //success notifiacation
                        toastr["success"](result.message, "Success");
                    }
                    else {
                        //error notification
                        toastr["error"](result.message, "Error");
                    }
                },
                error: function (result) {
                    console.log(result);
                }
            });
            setTimeout(function () {
                location.reload();
            }, 1000);


        }).catch(swal.noop);
    }
    /*************************************
     Delete Class End
     *************************************/
</script>