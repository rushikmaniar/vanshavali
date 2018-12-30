<div class="card">
    <div class="card-body">
        <div class="col-sm-12 col-md-12">
                        <button type="button"
                                class="btn btn-success btn-top"
                                id="btn_add_user"
                                onclick="ajaxModel('backoffice/Department/viewAddDepartmentModal','Add New Department','modal-md')"
                            <?= ($analysis_entry != 0)?'disabled="disabled"':''?>
                        >
                            <i class="fa fa-plus"></i> Add Department
                        </button>
        </div>
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="DepartmentTable">
                        <thead>
                        <tr>
                            <th>Department ID</th>
                            <th>Department Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($department_data as $row): ?>
                            <?php if($row['dept_id'] == 0):continue;endif;?>
                            <tr id="row_<?=$row['dept_id']?>">
                                <!-- Department id -->

                                <td><?=$row['dept_id']?></td>
                                <td><?=$row['dept_name']?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button"
                                                <?= ($row['entries'] != 0)?'disabled="disabled"':''?>
                                                class="btn btn-success btn-sm"
                                                data-tooltip="<?=($row['entries'] == 0)?'Edit Department':'Delete Record From Entry Record'?>"
                                                data-container="body" title="Edit Department"

                                                onclick="ajaxModel('backoffice/Department/viewEditDepartmentModal/<?=$row['dept_id']?>','Edit Department',800)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button"
                                                <?= ($row['entries'] != 0 || $row['dept_id'] == 0)?'disabled="disabled"':''?>
                                                class="btn btn-danger btn-sm"
                                                data-tooltip="<?=($row['entries'] == 0)?'Delete Department':'Delete Record From Entry Record'?>"
                                                data-container="body"
                                                title="Delete Department"
                                                onclick="deletedepartment(<?=$row['dept_id']?>)">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
            </div>

    </div>
<script>
    $(document).ready(function () {

        $('#DepartmentTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
	/*************************************
				Delete Department
	*************************************/
    function deletedepartment(dept_id)
    {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result)  {

            $.ajax({
            url: base_url + "backoffice/Department/deleteDepartment",
            type: "POST",
            dataType: "json",
            data: {"dept_id": dept_id},
            success: function (result) {
                if (result.code == 1 && result.code != '') {
                    toastr["success"](result.message, "Success");
                    setTimeout(function () {
                        $('#row_'+dept_id).remove();
                    },1000);
                }
                else {
                    toastr["error"](result.message, "Error");
                }
            },
            error:function (result) {
                console.log(result);
            }
        });



    }).catch(swal.noop);
    }
	/*************************************
				Delete Department End
	*************************************/
</script>