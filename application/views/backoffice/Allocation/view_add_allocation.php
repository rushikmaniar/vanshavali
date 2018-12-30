<?= form_open("backoffice/EmployeeAllocation/EditAllocation", array('id' => 'allocation_frm', 'method' => 'post')) ?>
<?= form_input(array('type' => 'hidden', 'name' => 'update_id', 'id' => 'update_id', 'value' => (isset($class_id)) ? $class_id : '')) ?>

<div class="row">



    <!-- class Name  -->
    <div class="col-sm-12">
        <div class="input-group form-group">
            <?= form_input(array('name' => 'allocation_frm_point_name', 'id' => 'allocation_frm_class_name', 'class' => 'form-control', 'placeholder' => 'Class  Name', 'value' => (isset($class_name)) ? $class_name : '','disabled'=>'disabled')) ?>
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        </div>
    </div>

    <!-- Select employees -->
    <div class="col-sm-12">
        <div class="col-sm-12">
            <label>Allocated Employees :</label>
        </div>
        <div class="col-sm-12">
        <select name="allocation_frm_emp_codes[]" id="allocation_frm_emp_codes" style="width: 50%" class="form-control" multiple="multiple">
            <?php foreach ($employee_list as $row): ?>
                <?php if (in_array($row['emp_code'],$allocation_data)): ?>
                    <option value="<?= $row['emp_code'] ?>" selected><?= $row['emp_name'] ?> </option>
                    <?php else: ?>
                    <option value="<?= $row['emp_code'] ?>"><?= $row['emp_name'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        </div>
    </div>


    <!--  submit -->
    <div class="col-md-12">
        <button type="submit" id="btn-add-user" class="btn btn-success m-t-10 pull-right">
            <i class="fa fa-save"></i> Save
        </button>
    </div>
    <?= form_close(); ?>

    <script>

        var update_id = $('#update_id').val();
        $('#allocation_frm_emp_codes').select2({
            placeholder:'Select Employees'
        });
        $(document).ready(function () {

            /*************************************
              Edit Allocation
             *************************************/
            $("#allocation_frm").validate({
                errorClass: 'invalid-feedback animated fadeInDown',
                /*errorPlacement: function(error, element) {
                    error.appendTo(element.parent().parent());
                },*/
                errorPlacement: function (e, a) {
                    jQuery(a).parents(".input-group").append(e)
                },
                highlight: function (e) {
                    jQuery(e).closest(".input-group").removeClass("is-invalid").addClass("is-invalid")
                },
                success: function (e) {
                    jQuery(e).closest(".input-group").removeClass("is-invalid"), jQuery(e).remove()
                },
                rules:
                    {
                        'allocation_frm_emp_codes': {
                            required: true
                        }
                    },
                messages:
                    {
                        'allocation_frm_emp_codes': {
                            required: "This field is required."
                        }
                    }
            });
            /*************************************
              Edit Allocation  End
             *************************************/

        });
    </script>