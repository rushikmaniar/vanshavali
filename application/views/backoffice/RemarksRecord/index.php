<div class="card">
    <div class="card-body">
        <h2 class="blink text-info">If You Want Delete Record .Go To Entry Record.</h2>
        <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="AnalysisTable">
            <thead>
            <tr>
                <th>Remark Record ID</th>
                <th>Entry ID</th>
                <th>Class Name</th>
                <th>Section Name</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($remarks_record as $row): ?>
                <tr>
                    <!-- remarks Id -->
                    <td><?= $row['remark_id'] ?></td>
                    <td><?= $row['entry_id'] ?></td>
                    <td><?= $row['class_name'] ?></td>
                    <td><?= $row['section_name']?></td>
                    <td><?= $row['remarks']?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<script>
    $(document).ready(function () {

        $('#AnalysisTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });

</script>