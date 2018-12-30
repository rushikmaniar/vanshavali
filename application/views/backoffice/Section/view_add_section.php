<?= form_open("backoffice/SectionManagement/addEditSection", array('id' => 'section_frm', 'method' => 'post')) ?>
<?= form_input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => (isset($section_master_data)) ? 'editSection' : 'addSection')) ?>
<?= form_input(array('type' => 'hidden', 'name' => 'update_id', 'id' => 'update_id', 'value' => (isset($section_master_data)) ? $section_master_data['section_id'] : '')) ?>

<div class="row">



    <!-- Section Name  -->
    <div class="col-sm-12">
        <div class="input-group form-group">
            <?= form_input(array('name' => 'section_master_frm_section_name', 'id' => 'section_master_frm_section_name', 'class' => 'form-control', 'placeholder' => 'Section  Name', 'value' => (isset($section_master_data)) ? $section_master_data['section_name'] : '')) ?>
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        </div>
    </div>

    <!--  submit -->
    <div class="col-md-12">
        <button type="submit" id="btn-add-user" class="btn btn-success m-t-10 pull-right">
            <?= (isset($section_master_data)) ? '<i class="fa fa-save"></i> Save' : '<i class="fa fa-plus"></i> Add' ?>
        </button>
    </div>
    <?= form_close(); ?>

    <script>

        var update_id = $('#update_id').val();
        $(document).ready(function () {

            /*************************************
             Add Section
             *************************************/
            $("#section_frm").validate({
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
                        'section_master_frm_section_name': {
                            required: true,
                            remote: {
                                url: base_url+"backoffice/SectionManagement/checkexists/"+"section_id"+"/"+update_id,
                                type: "post",
                                data: {
                                    'table': 'section_master',
                                    'field': 'section_name',
                                    section_name: function () {
                                        return $('#section_frm_section_name').val();
                                    }
                                }
                            }
                        }
                    },
                messages:
                    {
                        'section_master_frm_section_name': {
                            required: "This field is required.",
                            remote:"Section already Exists"
                        }
                    }
            });
            /*************************************
             Add Edit Section End
             *************************************/

        });
    </script>