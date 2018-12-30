<div class="card">
    <div class="card-body">
        <div align="center">
        <img src="<?= base_url('images/danger.jpg')?>" alt="danger" height="100px" width="100px"  class="blink text-danger">
        </div>
        <div class="row">
            <!-- Export Database -->
            <div class="col-sm-6 col-md-6">
                <div><label>Export Database</label></div>
                <a href="<?= base_url().'backoffice/Databasemanagement/exportdatabase'?>">
                <button type="button" class="btn btn-success btn-top" id="btn_export"
                    <i class="fa fa-file-export"></i> Export Database
                </button>
                </a>
            </div>

            <!-- Truncate Database -->
            <div class="col-sm-6 col-md-6">
                <div><label>Truncate Database</label></div>

                <button type="button" class="btn btn-danger btn-top" id="btn_truncate"
                        onclick="sure()"
                    <i class="fa fa-skull"></i> Truncate Database
                </button>

            </div>

        </div>

    </div>

</div>
<script type="text/javascript">
    function sure() {
        swal({
            title: 'Are you sure?',
            text: "All Tables Will Truncate .You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Truncate it!'
        }).then(function (result) {
            window.location = base_url + '/backoffice/DatabaseManagement/truncatedatabase';
        }).catch(swal.noop);
    }
</script>
