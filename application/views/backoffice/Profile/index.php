<div class="card">
    <div class="card-body">
        <form id="frm_profile" method="post" action="<?= base_url('backoffice/Profile/editProfile')?>" enctype="multipart/form-data">
            <div class="row col-sm-12">
                <!-- User Image -->
                <div class="col-sm-3 form-group thumbnail">
                    <div class="input-group image">

                            <input type="file" name="frm_profile_user_image" id="frm_profile_user_image" style="display:none" accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this)">
                            <a href="javascript:void(0)" onclick="$('#frm_profile_user_image').click()">
                                <img src="<?= base_url('uploads/user/profile/').$user_details['user_image']?>" id="user_image"

                                     class="img-responsive img-circle img-fluid"
                                                            onerror="this.src='<?= base_url('images/person-noimage-found.png')?>'">
                            </a>

                    </div>
                </div>
                
                <!-- User Email -->
                <div class="col-sm-12 form-group">
                    <div class="input-group">
                        <label class="col-sm-12">User Email</label>
                            <input type="hidden" name="frm_profile_user_id" id="frm_profile_user_id" value="<?= $user_details['user_id'] ?>">
                            <input type="text" class="form-control" id="frm_profile_user_email"
                                   name="frm_profile_user_email" value="<?= $user_details['user_email'] ?>"
                                   placeholder="Enter User Email">

                    </div>
                </div>

                <!-- submit  -->
                <div class="col-sm-6">
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

        var update_id = $('#frm_profile_user_id').val();
        $("#frm_profile").validate({
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
                'frm_profile_user_email': {
                    required: true,
                    remote: {
                        url: base_url + "backoffice/Profile/checkexists/user_id/" + update_id,
                        type: "post",
                        data: {
                            'table': 'user',
                            'field': 'user_email',
                            user_email: function () {
                                return $('#frm_profile_user_email').val();
                            }
                        }
                    }
                },
                'frm_profile_user_image':{
                    checkFileType: "['jpg','jpeg','png']"
                }


            },
            messages: {
                'frm_profile_user_email': {
                    required: "This field is required.",
                    remote: "User Email already Exists"
                },
                'frm_profile_user_image':{
                    checkFileType: "Invalid File Type . JPEG / PNG Accepted"
                }
            }
        });

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#user_image')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>