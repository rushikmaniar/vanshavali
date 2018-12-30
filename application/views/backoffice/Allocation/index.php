<div class="card">
    <div class="card-body">
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="AllocationTable">
                        <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>IS Optional  / Emplyoees Allocated</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($class_list as $row): ?>
                            <tr>
                                <!-- Class id -->

                                <td><?=$row['class_name']?></td>
                                <td>
                                    <?php if(!empty($allocation_data[$row['class_id']])):?>
                                    <?php foreach ($allocation_data[$row['class_id']] as $emp):?>
                                            <input type='checkbox' data-empno="<?= $emp['emp_code']?>" data-classid="<?= $row['class_id']?>" <?php echo ($emp['is_optional'] == 1 ?  'checked':'')?> onchange="updateisOptional(this)" <?= ($row['entries'] != 0)?'disabled="disabled"':''?>> <?=$emp['emp_name']?><br>
                                        <?php endforeach;?>
                                        <?php else:?>
                                        No Employees Allocated to this class
                                    <?php endif;?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-success btn-sm"
                                                data-tooltip="<?= ($row['entries'] == 0)?'Edit Allocation':'Delete Entries in Entry Table To Edit Allocation'?>"
                                                data-container="body" title="Edit Allocation"
                                                <?= ($row['entries'] != 0)?'disabled="disabled"':''?>
                                                onclick="ajaxModel('backoffice/EmployeeAllocation/viewEditAllocationModal/<?=$row['class_id']?>','Edit Allocation')">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger btn-sm"
                                                data-tooltip="<?= ($row['entries'] == 0)?'Edit Allocation':'Delete Entries in Entry Table To Edit Allocation'?>"
                                                data-container="body"
                                                title="Delete Allocation"
                                                <?= ($row['entries'] != 0)?' disabled="disabled" ':''?>
                                                onclick="deleteallocation(<?=$row['class_id']?>)">
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

        $('#AllocationTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
	/*************************************
				Delete Allocation
	*************************************/
    function deleteallocation(class_id)
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
            url: base_url + "backoffice/EmployeeAllocation/deleteAllocation",
            type: "POST",
            dataType: "json",
            data: {"class_id": class_id},
            success: function (result) {
                if (result.code == 1 && result.code != '') {
                    toastr["success"](result.message, "Success");
                }
                else {
                    toastr["error"](result.message, "Error");
                }
            },
            error:function (result) {
                console.log(result);
            }
        });
        setTimeout(function () {
            location.reload();
        },500);


    }).catch(swal.noop);
    }
	/*************************************
				Delete Allocation End
	*************************************/

	function updateisOptional(el) {
        console.log(el);
        var val = $(el).is(":checked");
        var empno = $(el).data('empno');
        var class_id = $(el).data('classid');

        $.ajax({
            url: base_url + "backoffice/EmployeeAllocation/updateIsOptional",
            type: "POST",
            dataType: "json",
            data: {
                "class_id": class_id,
                "empno": empno,
                "val": val
            },
            success: function (result) {
                if (result.code == 1 && result.code != '') {
                    toastr["success"](result.message, "Success");
                }
                else {
                    toastr["error"](result.message, "Error");
                }
            },
            error: function (result) {
                console.log(result);
            }
        });

    }
</script>