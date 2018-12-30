<div class="card">
    <div class="card-body">
        <form id="frm_sitesettings" method="post" action="<?= base_url('backoffice/SiteManagement/editSettings') ?>"
              enctype="multipart/form-data">
            <div class="row col-sm-12">

                <!-- Front HomePage Heading -->
                <div class="col-sm-12 form-group">
                    <div class="input-group">
                        <label class="col-sm-12"><h2 class="text-primary">Front Home Page Heading (html)</h2></label>
                        <textarea class="form-control frm_sitesettings summernote"
                                  name="frm_sitesettings[<?= $site_settings[0]['settings_id'] ?>]"
                                  placeholder="Enter Html For Front Home Page Heading">
                            <?= $site_settings[0]['settings_value'] ?>
                        </textarea>


                    </div>
                </div>
                <!-- Front HomePage Footer -->
                <div class="col-sm-12 form-group">
                    <div class="input-group">
                        <label class="col-sm-12"><h2 class="text-primary">Front Home Page Footer (html)</h2></label>
                        <textarea class="form-control frm_sitesettings summernote"
                                  name="frm_sitesettings[<?= $site_settings[1]['settings_id'] ?>]"
                                  placeholder="Enter Html For Front Home Page Footer">
                            <?= $site_settings[1]['settings_value'] ?>
                        </textarea>
                    </div>
                </div>

                <style type="text/css">
                    input.largerCheckbox {
                        width: 30px;
                        height: 30px;
                    }
                </style>

                <!-- Image slider Manager -->
                <div class="col-sm-12 form-group">
                    <div class="input-group">
                        <label class="col-sm-12"><h2 class="text-primary">Front Slider Image</h2></label>
                        <!-- Add Slides btn  -->
                        <div class="col-sm-6">
                            <div class="input-group form-group">
                                <input type="file" id="frm_sitesettings_addslides" multiple name="sliderimg[]"
                                       name="frm_sitesettings_addslides" style="display: none;" onchange="readURL(this)">
                                <button type="button" class="btn-md btn-primary"
                                        onclick="$('#frm_sitesettings_addslides').click()"><i class="fa fa-plus"></i>Add
                                </button>
                            </div>
                        </div>

                        <!-- Remove btn  -->
                        <div class="col-sm-6">
                            <div class="input-group form-group">
                                <button type="button" class="btn-md btn-danger" onclick="deleteSlides()"><i
                                            class="fa fa-remove"></i>Remove Multiple
                                </button>
                            </div>
                        </div>
                        <div id="temp-slides" class="col-sm-12">

                        </div>
                        <?php foreach ($imagelist as $row): ?>
                            <div style="margin-left: 10px;margin-top: 10px;margin-top: 10px"
                                 id="img_<?= $row['slideid'] ?>">
                                <input type="checkbox" name="slider[]" data-slideid="<?= $row['slideid'] ?>"
                                       value="<?= $row['slidename'] ?>" class="slides largerCheckbox">
                                <img src="<?= base_url('images/slider-image/') . $row['slidename'] ?>"
                                     style="width: 150px;height: 150px" alt="<?= $row['slidename'] ?>">
                                <div><span><?= $row['slidename']; ?></span></div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>


                <!-- submit  -->
                <div class="col-sm-12">
                    <div class="input-group form-group">
                        <button type="submit" class="btn-md btn-primary"><i class="fa fa-save"></i>Submit</button>
                    </div>
                </div>


            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {

        jQuery.validator.addClassRules({
            frm_sitesettings: {
                required: true
            }
        });


        $("#frm_sitesettings").validate({
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

                'frm_sitesettings_addslides': {
                    checkFileType: ["jpg","jpeg","png"]
                }
            },
            messages: {
                'frm_sitesettings_addslides': {
                    checkFileType: "Invalid File Type . JPEG / PNG Accepted"
                }
            }
        });
    });

    function deleteSlides() {
        var slideids = [];
        var slides = $('.slides:checked').map(function () {
            slideids.push($(this).data('slideid'));
            return $(this).val();
        }).get();

        slideids.forEach(function (item) {
            $('#img_' + item).remove();
        });

        $.ajax({
            url: base_url + "backoffice/SiteManagement/deleleteSlides",
            type: "POST",
            dataType: "json",
            data: {"slides": slides},
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
        console.log(slides);
    }

    function readURL(input) {

        $('#temp-slides').html('');
        if (input.files && input.files[0]) {

            for (i = 0; i < input.files.length; i++) {

                var reader = new FileReader();
                $('#temp-slides').append('<div style="margin-left: 10px;margin-top: 10px;margin-top: 10px;">');
                reader.onload = function (e) {
                    var html =
                        '<img src="' + e.target.result + '"  style="width: 150px;height: 150px" alt="error">';
                    $('#temp-slides').append(html);
                };
                $('#temp-slides').append('<div><span>' + input.files[i].name + '</span></div></div>');
                reader.readAsDataURL(input.files[i]);
            }
        }
    }
</script>