<?= form_open("backoffice/ClassManagement/addEditClass", array('id' => 'class_frm', 'method' => 'post')) ?>
<?= form_input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => (isset($class_data)) ? 'editClass' : 'addClass')) ?>
<?= form_input(array('type' => 'hidden', 'name' => 'update_id', 'id' => 'update_id', 'value' => (isset($class_data)) ? $class_data['class_id'] : '')) ?>

<div class="row">

    <!-- Class Code  -->
    <div class="col-sm-6">
        <div class="input-group form-group">
            <?= form_input(array('name' => 'class_frm_class_id', 'id' => 'class_frm_class_id', 'class' => 'form-control', 'placeholder' => 'Class  Code', 'value' => (isset($class_data)) ? $class_data['class_id'] : '')) ?>
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        </div>
    </div>

    <!-- Class Name  -->
    <div class="col-sm-6">
        <div class="input-group form-group">
            <?= form_input(array('name' => 'class_frm_class_name', 'id' => 'class_frm_class_name', 'class' => 'form-control', 'placeholder' => 'Class  Name', 'value' => (isset($class_data)) ? $class_data['class_name'] : '')) ?>
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        </div>
    </div>


    <!-- Select Department -->
    <div class="col-sm-12">
            <select name="class_frm_dept_id" id="class_frm_dept_id" style="width: 30%" class="form-control">
                <?php foreach ($department_list as $row): ?>
                    <?php if (isset($class_data['dept_id'])): ?>
                        <?php if (($class_data['dept_id']) == $row['dept_id']): ?>
                            <option value="<?= $row['dept_id'] ?>" selected><?= $row['dept_name'] ?></option>
                        <?php else: ?>
                            <option value="<?= $row['dept_id'] ?>"><?= $row['dept_name'] ?></option>
                        <?php endif; ?>
                    <?php else: ?>
                        <option value="<?= $row['dept_id'] ?>"><?= $row['dept_name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
    </div>

    <!--  submit -->
    <div class="col-md-12">
        <button type="submit" id="btn-add-user" class="btn btn-success m-t-10 pull-right">
            <?= (isset($class_data)) ? '<i class="fa fa-save"></i> Save' : '<i class="fa fa-plus"></i> Add' ?>
        </button>
    </div>
    <?= form_close(); ?>

    <script>

        var update_id = $('#update_id').val();
        $(document).ready(function () {
            $('#class_frm_dept_id').select2();

            /*************************************
             Add Edit Class
             *************************************/
            $("#class_frm").validate({
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
                rules: {
                    'class_frm_class_id': {
                        required: true,
                        digits:true,
                        remote: {
                            url: base_url + "backoffice/ClassManagement/checkexists/" +"class_id"+"/"+ update_id,
                            type: "post",
                            data: {
                                'table': 'class_master',
                                'field': 'class_id',
                                class_id: function () {
                                    return $('#class_frm_class_id').val();
                                }
                            }
                        }
                    },
                    'class_frm_class_name': {
                        required: true
                    },
                    'class_frm_dept_id': {
                        required: true
                    }

                },

                messages: {
                    'class_frm_class_id': {
                        required: "This field is required.",
                        remote: "Class code already Exists",
                        digits: "Only Numeric Accepted"
                    },
                    'class_frm_class_name': {
                        required: "This field is required."
                    },
                    'class_frm_dept_id': {
                        required: "This field is required."
                    }
                }
            });
            /*************************************
             Add Edit Class End
             *************************************/

        });
    </script>