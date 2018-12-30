<div class="card">
    <div class="card-body">
        <div class="col-sm-12 col-md-12">
                <h1 class="blink text-danger" align="center">Don't Edit Criteria Unless You Know  What You Are Doing .</h1>
                <h1 class="blink text-danger" align="center">Analysis tables , Front site Feedback form Relies On Criterias</h1>
                <?php if($criteria_analysis_entry != 0):?>
                <h1 class="blink text-danger" align="center">There are Some Entries in Analysis tables . First Go And Delete It</h1>
                <?php endif;?>
                        <button type="button"
                                class="btn btn-success btn-top"
                                title="Add Criteria"
                                id="btn_add_user"
                                onclick="ajaxModel('backoffice/CriteriaManagement/viewAddCriteriaModal','Add New Criteria','modal-md')"
                                <?= ($criteria_analysis_entry != 0)?'disabled="disabled"':''?>d
                                >
                            <i class="fa fa-plus"></i> Add Criteria
                        </button>
        </div>
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="CriteriaTable">
                        <thead>
                        <tr>
                            <th>Criteria ID</th>
                            <th>Criteria Name</th>
                            <th>Section Name</th>
                            <th>Type Of Data</th>
                            <th>Options For Criteria</th>

                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($criteria_data as $row): ?>
                            <tr id="row_<?= $row['criteria_id']?>">
                                <!-- Criteria id -->

                                <td><?=$row['criteria_id']?></td>
                                <td><?=$row['criteria_name']?></td>
                                <td><?=$row['section_name']?></td>
                                <td><?=($row['type_data'] == 1)?'With Options':'simple'?></td>
                                <td>
                                    <?php if($row['type_data'] == 1):?>
                                        <?php foreach ($row['options'] as $option_row):?>
                                            <?= $option_row['option_text'];?><br>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        No options Data.
                                    <?php endif;?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button"
                                                <?= ($criteria_analysis_entry != 0)?'disabled="disabled"':''?>
                                                class="btn btn-success btn-sm"
                                                data-tooltip="Edit Criteria"
                                                data-container="body"
                                                title="Edit Criteria"
                                                onclick="ajaxModel('backoffice/CriteriaManagement/viewEditCriteriaModal/<?=$row['criteria_id']?>','Edit Criteria',800)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button"
                                                 <?= ($criteria_analysis_entry != 0)?'disabled="disabled"':''?>
                                                class="btn btn-danger btn-sm"
                                                data-tooltip="Delete Criteria"
                                                data-container="body"
                                                title="Delete Criteria"
                                                onclick="deletecriteria(<?=$row['criteria_id']?>)">
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

        $('#CriteriaTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
	/*************************************
				Delete Criteria
	*************************************/
    function deletecriteria(criteria_id)
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
            url: base_url + "backoffice/CriteriaManagement/deleteCriteria",
            type: "POST",
            dataType: "json",
            data: {"criteria_id": criteria_id},
            success: function (result) {
                if (result.code == 1 && result.code != '') {
                    toastr["success"](result.message, "Success");
                    setTimeout(function () {
                        $('#row_'+criteria_id).remove();
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
				Delete Criteria End
	*************************************/
</script>