<div class="card">
    <div class="card-body">
        <div class="col-sm-12 col-md-12">
                        <h1 class="blink text-danger" align="center">Don't Edit This Section Unless You Know  What You Are Doing .</h1>
                        <h1 class="blink text-danger" align="center">Criteria Management,Analysis tables , Front site Feedback form Relies On Sections</h1>
                        <?php if($section_analysis_entry != 0):?>
                            <h1 class="blink text-danger" align="center">There are Some Entries in Analysis tables . First Go And Delete It</h1>
                        <?php endif;?>
                        <button type="button"
                                class="btn btn-success btn-top"
                                <?= ($section_analysis_entry != 0)?'disabled="disabled"':''?>
                                title="Add Section"
                                onclick="ajaxModel('backoffice/SectionManagement/viewAddSectionModal','Add New Section','modal-md')"
                                >
                            <i class="fa fa-plus"></i> Add New Section
                        </button>
        </div>
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="SectionTable">
                        <thead>
                        <tr>
                            <th>Section ID</th>
                            <th>Section Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($section_master_data as $row): ?>
                            <tr id="row_<?= $row['section_id']?>">
                                <!-- Section id -->

                                <td><?=$row['section_id']?></td>
                                <td><?=$row['section_name']?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button"
                                                <?= ($section_analysis_entry != 0)?'disabled="disabled"':''?>
                                                class="btn btn-success btn-sm"
                                                data-tooltip="Edit Section"
                                                data-container="body"
                                                title="Edit Section"
                                                onclick="ajaxModel('backoffice/SectionManagement/viewEditSectionModal/<?=$row['section_id']?>','Edit Section',800)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button"
                                                <?= ($section_analysis_entry != 0)?'disabled="disabled"':''?>
                                                class="btn btn-danger btn-sm"
                                                data-tooltip="Delete Section"
                                                data-container="body"
                                                title="Delete Section"
                                                onclick="deletesection(<?=$row['section_id']?>)">
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

        $('#SectionTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
	/*************************************
				Delete Section Criteria
	*************************************/
    function deletesection(section_master_id)
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
            url: base_url + "backoffice/SectionManagement/deleteSection",
            type: "POST",
            dataType: "json",
            data: {"section_master_id": section_master_id},
            success: function (result) {
                if (result.code == 1 && result.code != '') {
                    toastr["success"](result.message, "Success");
                    setTimeout(function () {
                        $('#row_'+section_master_id).remove();
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
				Delete Section End
	*************************************/
</script>