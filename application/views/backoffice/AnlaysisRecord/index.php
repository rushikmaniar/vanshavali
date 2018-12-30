<div class="card">
    <div class="card-body">
        <h2 class="blink text-info">If You Want Delete Record .Go To Entry Record.</h2>
        <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="AnalysisTable">
            <thead>
            <tr>
                <th>Analysis Record ID</th>
                <th>Entry ID</th>
                <th>Class Name</th>
                <th>Section Name</th>
                <th>Criteria Name</th>
                <th>Criteria Points</th>
                <th>Employee Name</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($analysis_record as $row): ?>
                <tr>
                    <!-- analysis_master Id -->
                    <td><?= $row['analysis_master_id'] ?></td>
                    <td><?= $row['entry_id'] ?></td>
                    <td><?= $row['class_name'] ?></td>
                    <td><?= $row['section_name']?></td>
                    <td><?= $row['criteria_name']?></td>
                    <td><?= $row['criteria_points']?></td>
                    <td><?= $row['emp_name']?></td>
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