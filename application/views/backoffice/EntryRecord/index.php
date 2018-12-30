<div class="card">
    <div class="card-body">
        <div class="col-sm-12">
            <label>Delete Record By Class</label>
            <select id="Selectclass" class="select2 col-sm-6">
                <option value="ALL">All Class</option>
                <?php foreach ($class_list as $row_class):?>
                    <option value="<?= $row_class['class_id']?>"><?= $row_class['class_name']?></option>
                <?php endforeach;?>
            </select>
            <button class=" btn-danger col-sm-2 btn-sm " onclick="deleteEntry()"><i class="fa fa-remove"></i>  Delete</button>
        </div>
        <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="EntryTable">
            <thead>
            <tr>
                <th>Entry ID</th>
                <th>Class ID</th>
                <th>Class Name</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($entry_record as $row): ?>
                <tr>
                    <!-- Entry Id -->
                    <td><?= $row['entry_id'] ?></td>
                    <td><?= $row['class_id'] ?></td>
                    <td><?= $row['class_name']?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $('#EntryTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
    /*************************************
     Delete Entry
     *************************************/
    function deleteEntry() {
        var class_id = $('#Selectclass').val();
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
                url: base_url + "backoffice/EntryRecord/deleteEntryRecord",
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
     Delete Entry Record End
     *************************************/
</script>