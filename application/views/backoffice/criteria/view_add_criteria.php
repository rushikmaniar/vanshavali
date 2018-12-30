<?= form_open("backoffice/CriteriaManagement/addEditCriteria", array('id' => 'criteria_frm', 'method' => 'post')) ?>
<?= form_input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => (isset($criteria_data)) ? 'editCriteria' : 'addCriteria')) ?>
<?= form_input(array('type' => 'hidden', 'name' => 'update_id', 'id' => 'update_id', 'value' => (isset($criteria_data)) ? $criteria_data['criteria_id'] : '')) ?>

<div class="row">

    <!-- Select Section -->
    <div class="col-sm-12 form-group">
        <label>Select section</label>
        <select name="criteria_frm_section_id" id="criteria_frm_section_id" style="width: 30%" class="form-control">
            <?php foreach ($section_list as $row): ?>
                <?php if (isset($criteria_data['section_id'])): ?>
                    <?php if (($criteria_data['section_id']) == $row['section_id']): ?>
                        <option value="<?= $row['section_id'] ?>" selected><?= $row['section_name'] ?></option>
                    <?php else: ?>
                        <option value="<?= $row['section_id'] ?>"><?= $row['section_name'] ?></option>
                    <?php endif; ?>
                <?php else: ?>
                    <option value="<?= $row['section_id'] ?>"><?= $row['section_name'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>

    <!--want options data ? -->
    <div class="col-sm-12 form-group">
        <label>Type Of Data</label>
        <div>

            <?php if(isset($criteria_data)):?>
                Simple Data (0-5)
            <input type="radio" name="radios" value="simple" <?= ($criteria_data['type_data'] == 0)?'checked="checked"':''?>>
            With Options
            <input type="radio" name="radios" value="options" <?= ($criteria_data['type_data'] == 1)?'checked="checked"':''?>>
            <?php else:?>
                Simple Data (0-5)
                <input type="radio" name="radios" value="simple" checked="checked">
                With Options
                <input type="radio" name="radios" value="options">
            <?php endif;?>
        </div>

        <div id="options" style="<?= isset($option_data)?'display:block':'display:none'?>">
            <div class="row">

                <div class="col-sm-12 form-group">
                    <button class="btn-primary btn-sm pull-right" onclick="addoptions()"><i class="fa fa-plus"></i> Add
                        Option
                    </button>
                </div>

                <div class="col-sm-12" id="options_div">
                    <div class="row">
                    <!-- option for design -->
                    <?php if(isset($option_data)):?>
                        <?php foreach ($option_data as $row):?>
                            <div class="col-sm-6">
                                <div class="input-group form-group">
                                    <input type="text" class="form-control options_require" name="options[<?= $row['option_id'];?>][option_text]" value="<?= $row['option_text']?>" placeholder="Enter Option Text" required="true">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group form-group">
                                    <input type="text" class="form-control options_require" name="options[<?= $row['option_id'];?>][option_value]" value="<?= $row['option_value']?>" placeholder="Enter Option Value" required="true">
                                    <button class="btn-danger btn-sm" onclick="deleteoption(this)"><i class="fa fa-minus"></i> Delete</button>
                                </div>
                            </div>
                            <?php endforeach;?>
                    <?php else:?>
                            <div class="col-sm-6">
                                <div class="input-group form-group">
                                    <input type="text" class="form-control options_require" name="options[1][option_text]" placeholder="Enter Option Text" required="required">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group form-group">
                                    <input type="text" class="form-control options_require" name="options[1][option_value]" placeholder="Enter Option Value" required="required">
                                    <button class="btn-danger btn-sm" onclick="deleteoption(this)"><i class="fa fa-minus"></i> Delete</button>
                                </div>
                            </div>
                    <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Criteria Name  -->
    <div class="col-sm-12">
        <div class="input-group form-group">
            <?= form_input(array('name' => 'criteria_frm_criteria_name', 'id' => 'criteria_frm_criteria_name', 'class' => 'form-control', 'placeholder' => 'Criteria  Name', 'value' => (isset($criteria_data)) ? $criteria_data['criteria_name'] : '')) ?>
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        </div>
    </div>

    <!--  submit -->
    <div class="col-md-12">
        <button type="submit" id="btn-add-user" class="btn btn-success m-t-10 pull-right">
            <?= (isset($criteria_data)) ? '<i class="fa fa-save"></i> Save' : '<i class="fa fa-plus"></i> Add' ?>
        </button>
    </div>
    <?= form_close(); ?>

    <script>
        var i = 1111;
        function addoptions() {

            var random_no = ++i;
            var options_div = $('#options_div');
            html = '<div class="row">';
            html += '<div class="col-sm-6">';
                html += '<div class="input-group form-group">';
                html += '<input type="text" class="form-control options_require" name="options['+random_no+'][option_text]" placeholder="Enter Option Text" required="required">';
                html += '</div>';
            html += '</div>';

            html += '<div class="col-sm-6">';
                html += '<div class="input-group form-group">';
                html += '<input type="text" class="form-control options_require"  name="options['+random_no+'][option_value]" placeholder="Enter Option Value" required="required">';
                html += '<button class="btn-danger btn-sm" onclick="deleteoption(this)"><i class="fa fa-minus"></i> Delete</button>';
                html +=  '</div>';
            html +=  '</div>';
            html +=  '</div>';

            options_div.append(html);

        }
        function  deleteoption(element) {
            $(element).parent().parent().parent().html('');
        }

        var update_id = $('#update_id').val();
        $(document).ajaxComplete(function () {
            /*On radio change */
            $('input[name=radios]').on('change',function () {
               if($(this).val() == "options"){
                   $('#options').css('display','block');
               }else{
                   $('#options').css('display','none');
               }
            });

            $('#criteria_frm_section_id').select2({
                placeholder: "Select Section",
                dropdownAutoWidth : true
            });
            /*************************************
             Add Edit Criteria
             *************************************/
            $("#criteria_frm").validate({
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
                    criteria_frm_section_id: {
                        required: true,
                        digits:true
                    },
                    'criteria_frm_criteria_name': {
                        required: true,
                        remote: {
                            url: base_url + "backoffice/CriteriaManagement/checkexists/"+"criteria_id"+"/" + update_id,
                            type: "post",
                            data: {
                                'table': 'criteria_master',
                                'field': 'criteria_name',
                                criteria_name: function () {
                                    return $('#criteria_frm_criteria_name').val();
                                }
                            }
                        }
                    },
                    "options[option_text][]":{
                        required:true
                        },
                    "options[option_value][]":{
                        required:true
                    }


                },
                messages: {
                    'criteria_frm_criteria_name': {
                        required: "This field is required.",
                        remote: "Criteria already Exists"
                    },
                    criteria_frm_section_id: {
                        required: "This field is required.",
                        digits: "Only Numeric Accepted"
                    },
                    "options[option_text][]":{
                        required: "This field is required."
                    },
                    "options[option_value][]":{
                        required: "This field is required."
                    }
                },
                submitHandler: function (form,event) {
                    var type_of_data = $('input[name=radios]:checked').val();
                    if(type_of_data === "options"){
                        var no_options = $('.options_require').length;
                        if(no_options/2 < 2){
                            alert('minimum 2 options required');
                            event.preventDefault();
                        }
                        else{
                            //options greater than 2
                            return true;
                        }
                    }else{
                        //simple data
                        return true;
                    }

                }
            });
            /*************************************
             Add Edit Criteria End
             *************************************/


            jQuery.validator.addClassRules({
                options_require:{
                    required:true
                }
            });

        });

    </script>