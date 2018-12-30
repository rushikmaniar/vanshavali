<?php
/**
 * Created by PhpStorm.
 * User: jatin
 * Date: 010 10-06-2018
 * Time: 01:36 PM
 */?>
<div align="center">
    <h1>CHRIST COLLEGE RAJKOT</h1>
    <h2> Student Feedback Form </h2>
</div>
<h3 class="text-danger">Please give Rating On scale 1-5</h3>
<h3 class="text-warning blink">1-Unstatisfactory ,2-Statisfactory,3-Good,4-Very Good,5-Excellent</h3>
<div class="container-fluid">
    <form id="frm_feedback" name="frm_feedback" method="post" action="<?= base_url().'StartFeedback/InsertFeedbackData'?>">
        <div>

            <h3>Select Class</h3>
            <section>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="frm_feedback_class" class="col-form-label-lg"><h4>Select Class</h4></label>
                        <select name="frm_feedback_class" id="frm_feedback_class" class="select2 form-control" style="width: auto">
                            <option value="">Select Class</option>
                            <?php foreach ($class_list as $row):?>
                                <option value="<?= $row['class_id']; ?>"><?= $row['class_name']; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </section>
            <?php foreach ($section_list as $row_section):?>
                <h3><?= $row_section['section_name']?></h3>

                <!-- Employee section -->
                <?php if($row_section['section_id'] == 1):?>
                <section>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="frm_feedback_class" class="col-form-label-lg"><h4><?= $row_section['section_name']?></h4></label>
                            <div class="row">
                                <div class="form-group col-md-12 card">
                                    <table id="frm_feedback_emp_table" class="table table-bordered table-hover table-responsive">
                                        <thead>

                                        <input type="hidden" id="emp_section_id" name="section[<?= $row_section['section_id']?>][section_id]" value="<?= $row_section['section_id'];?>">
                                        <input type="hidden" name="section[<?= $row_section['section_id']?>][section_name]" value="<?= $row_section['section_name'];?>">

                                        <td>Teachers Image</td>
                                        <td>Teachers Name</td>
                                        <td>Is Subject Optional</td>
                                        <?php foreach ($row_section['criteria_list'] as $index=>$value):?>
                                            <td data-criteriaid="<?= $value['criteria_id']; ?>" class="employee_criteria" data-type_data="<?= $value['type_data']?>"><?= $value['criteria_name']; ?></td>

                                        <?php endforeach;?>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <!-- Remarks -->
                                    <div><label>Remarks</label></div>
                                    <div class="form-group col-md-12">
                                        <textarea name="section[<?= $row_section['section_id']?>][remarks]" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php else:?>
                    <section>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="frm_feedback_class" class="col-form-label-lg"><h4><?= $row_section['section_name']?></h4></label>
                                <div class="row">
                                    <div class="form-group col-md-12 card">
                                        <table id="frm_feedback_<?= $row_section['section_name']?>" class="table table-bordered table-hover">
                                            <thead>

                                            <input type="hidden" name="section[<?= $row_section['section_id']?>][section_id]" value="<?= $row_section['section_id'];?>">
                                            <input type="hidden" name="section[<?= $row_section['section_id']?>][section_name]" value="<?= $row_section['section_name'];?>">

                                            <?php foreach ($row_section['criteria_list'] as $index=>$value):?>
                                                <td data-criteriaid="<?= $value['criteria_id']; ?>" class="<?= $row_section['section_name']?>_criteria"><?= $value['criteria_name']; ?></td>
                                            <?php endforeach;?>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($row_section['criteria_list'] as $index=>$value):?>
                                                <td>
                                                    <?php if($value['type_data'] == 1):?>
                                                        <select name="section[<?= $row_section['section_id']?>][points][<?= $value['criteria_id']?>]" class="select2 form-control">
                                                        <?php foreach ($value['option_list'] as $row_option): ?>
                                                            <option value="<?= $row_option['option_id']?>"><?= $row_option['option_text'];?></option>
                                                        <?php endforeach;?>
                                                        </select>
                                                    <?php else:?>
                                                        <input type="text" name="section[<?= $row_section['section_id']?>][points][<?= $value['criteria_id']?>]" class="points form-control" pattern="^[0-5]$" title="Enter 1-5">
                                                    <?php endif;?>
                                                </td>
                                            <?php endforeach;?>
                                            </tbody>
                                        </table>
                                        <!-- Remarks -->
                                        <div><label>Remarks</label></div>
                                        <div class="form-group col-md-12">
                                            <textarea name="section[<?= $row_section['section_id']?>][remarks]" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
            <?php endif; ?>
            <?php endforeach;?>
        </div>

    </form>
</div>
<script type="text/javascript">
$(document).ready(function () {


    //multi step form
    $('#frm_feedback').children('div').steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {

            $('#frm_feedback').validate().settings.ignore = ":disabled,:hidden";
            return $('#frm_feedback').valid();
            return true;
        },
        onFinishing: function (event, currentIndex)
        {
            $('#frm_feedback').validate().settings.ignore = ":disabled";
            return $('#frm_feedback').valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");
            $('#frm_feedback').submit();
        }
    });

    $('.content clearfix').css({'overflow-x':'scroll','overflow-y':'scroll','white-space': 'nowrap'});
    $('#frm_feedback_class').on('change',function () {
        var class_id = $(this).val();
        var emp_section_id = $('#emp_section_id').val();


        var employee_criteria_list = [];
            $.each($('.employee_criteria'),function (index,value) {
                var criteria_id = $(value).data("criteriaid");
                employee_criteria_list.push(criteria_id);
                /*if($(value).data("data-type_data") == 1){
                    var option_list = JSON.parse($(value).data("options"));
                    employee_criteria_list[criteria_id]['option_list'].push(option_list);
                }*/
            });
            //console.log(employee_criteria_list);

        if(class_id){
            $.ajax({
                type:'post',
                async:false,
                url:base_url+'/StartFeedback/getRelatedEmployees',
                data:{'class_id':class_id},
                success:function (response) {
                    var response = JSON.parse(response);
                    if(response.code == 1){
                        var html = '';
                        html +'<input type="hidden" name="class_id" value="'+class_id+'">';
                        $.each(response.data,function (key,value) {
                           html+= '<tr id="emp_row_'+value.emp_code+'">';
                                if(value.emp_image != null)
                                html += '<td><img src="' + base_url + '/uploads/employee/' + value.emp_image + '" onerror="this.src= base_url + \'/images/person-noimage-found.png\'" style="height:80px;width:80px" class="img-circle"></td>';
                                else
                                    html += '<td><img src="' + base_url + '/images/person-noimage-found.png"' + 'style="height:80px;width:80px" class="img-circle"></td>';
                               html += '<td data-emp_code="'+value.emp_code+'">'+value.emp_name+'</td>';

                               if(value.is_optional == 1)
                                html += '<td><input type="checkbox" onchange="disablerow(this)" data-empno="'+value.emp_code+'"> </td>';
                               else
                                   html += '<td></td>';
                                $.each(employee_criteria_list,function (index,criteria_value) {

                                    html += '<td>';
                                    html+= '<input type="hidden" name="section['+emp_section_id+'][points]['+value.emp_code+']['+criteria_value+'][emp_code]" value="'+value.emp_code+'">';
                                    html+= '<input type="hidden" name="section['+emp_section_id+'][points]['+value.emp_code+']['+criteria_value+'][criteria_code]" value="'+criteria_value+'">';
                                    html+= '<input type="text" pattern="^[1-5]$" title="Enter 1-5" required="required" class="points form-control" name="section['+emp_section_id+'][points]['+value.emp_code+']['+criteria_value+'][emp_criteria_points]">';
                                    html += '</td>';
                                });
                                html += '</tr>';
                            //console.log(value);
                        });
                        $('#frm_feedback_emp_table tbody').html(html);
                    }else{
                        toastr["error"](response.message, "Error");
                    }
                },
                error:function (response) {
                    //console.log(response);
                }
            })
        }
    });

    // jquery validation
    $('#frm_feedback').validate({
        errorClass: 'invalid-feedback animated fadeInDown',
        highlight: function (e) {
            jQuery(e).addClass("is-invalid");
        },
        success: function (label,element) {
            jQuery(element).removeClass("is-invalid").removeClass("invalid-feedback").addClass("is-valid");
        },
        rules: {
            frm_feedback_class:{
                required:true
            }
        },
        messages:{
            frm_feedback_class:{
                required:"This field is required"
            }
        }

    });


    jQuery.validator.addClassRules({
        points:{
            required:true,
            regex:"^[1-5]$"
        }
    });

    //select2
    $('#frm_feedback_class').select2({
        placeholder: "Select a class",
        allowClear: true
    });

    //select2
    $('.select2').select2({
        allowClear: true,
        dropdownAutoWidth : true
    });
});
function disablerow(el) {
    var empno = $(el).data('empno');

    if($(el).is(':checked')){
        $('#emp_row_'+empno + ' td :input[type=text]').attr('disabled',true);
    }else{
        $('#emp_row_'+empno + ' td :input[type=text]').attr('disabled',false);
    }

}

</script>
