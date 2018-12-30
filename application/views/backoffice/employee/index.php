<div class="card">
    <div class="card-body">
        <div class="col-sm-12 col-md-12">
                        <button type="button" class="btn btn-success btn-top" id="btn_add_user" onclick="ajaxModel('backoffice/Employee/viewAddEmployeeModal','Add New Employee','modal-lg')">
                            <i class="fa fa-plus"></i> Add Employee
                        </button>
        </div>
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="EmployeeTable">
                        <thead>
                        <tr>
                            <th>Employee Image</th>
                            <th>Employee Code</th>
                            <th>Employee Name</th>
                            <th>Employee Email</th>
                            <th>Employee Mobile</th>
                            <th>Department</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($employee_data as $row): ?>
                            <tr id="row_<?= $row['emp_code']?>">
                                <!-- Employee Code -->

                                <td><img src="<?= base_url().'uploads/employee/'.$row['emp_image']?>" onerror="this.src='<?= base_url('images/person-noimage-found.png')?>'" class="img-responsive img-circle" style="height: 100px;width: 100px"></td>
                                <td><?=$row['emp_code']?></td>
                                <td><?=$row['emp_name']?></td>
                                <td><?=$row['emp_email']?></td>
                                <td><?=$row['emp_phone']?></td>
                                <td><?=$row['dept_name']?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm"
                                                data-tooltip=" <?= ($row['analysis_emp_code_entries'] == 0)?'Edit Employee':'Delete Entries in Entry Table To Edit Employee'?>"
                                                data-container="body"
                                                title="Edit User"
                                                onclick="ajaxModel('backoffice/Employee/viewEditEmployeeModal/<?=$row['emp_code']?>','Edit Employee',800)"
                                                <?= ($row['analysis_emp_code_entries'] != 0)?'disabled="disabled"':''?>
                                        >
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger btn-sm"
                                                data-tooltip=" <?= ($row['analysis_emp_code_entries'] == 0)?'Delete Employee':'Delete Entries in Entry Table To Delete Employee'?>"
                                                data-container="body" title="Delete User"
                                                onclick="deleteEmployee(<?=$row['emp_code']?>,'<?= $row['emp_image'] ?>')"
                                                <?= ($row['analysis_emp_code_entries'] != 0)?'disabled="disabled"':''?>
                                        >
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

        $('#EmployeeTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
	/*************************************
				Delete Employee
	*************************************/
    function deleteEmployee(emp_code,emp_image)
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
            url: base_url + "backoffice/Employee/deleteEmployee",
            type: "POST",
            dataType: "json",
            data: {"emp_code": emp_code,"emp_image":emp_image},
            success: function (result) {
                if (result.code == 1 && result.code != '') {
                    toastr["success"](result.message, "Success");
                    setTimeout(function () {
                        $('#row_'+emp_code).remove();
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
				Delete Employee End
	*************************************/
</script>