<style>
    #addUserImageDiv {
        position: relative;
    }

    #addUserImageDiv input {
        display: none;
    }

    #addUserImageDiv>em {
        position: absolute;
        font-size: x-large;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        background: greenyellow;
    }

    #addUserImageDiv>.addUserImageIcon {
        color: #fff;
        top: 5px;
        left: 5px;
    }

    #addUserImageDiv>.removeUserImageIcon {
        background: #ff0000;
        color: #fff;
        top: 5px;
        right: 5px;
        display: none;
    }
</style>
<div class="modal fade zoom" tabindex="-1" id="addUser">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addUpdateUser" action="<?= route_to('admin_add_user_ajax') ?>" method="post" enctype="multipart/form-data">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="full_name">User Full Name *</label>
                            <div class="row" id="full_name">
                                <div class="col-md-6">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" placeholder="First Name" id="addUserFirstName" name="first_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" placeholder="Last Name" id="addUserLastName" name="last_name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="user_sontacts">Contacts *</label>
                            <div class="row" id="user_sontacts">
                                <div class="col-md-6">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" placeholder="Email" id="addUserEmail" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" placeholder="Mobile" id="addUserMobile" name="mobile" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="other_details">Other Details</label>
                            <div class="row" id="other_details">
                                <div class="col-md-5 col-12">
                                    <div class="rounded" id="addUserImageDiv">
                                        <img src="/public/images/avatar.jpg" class="rounded w-100" id="addUserImage">
                                        <em class="ni ni-camera-fill addUserImageIcon"></em>
                                        <em class="ni ni-cross removeUserImageIcon"></em>
                                        <input type="file" name="profile_pic" id="addUserProfilePic" onchange="previewUserImage(event, 'addUserImage')">
                                    </div>
                                </div>
                                <div class="col-md-7 col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="addUserProfession">User Profession</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="profession" id="addUserProfession" placeholder="eg: Director / Producer">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="addUserAbout">User About / BIO</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control" rows="3" name="about" id="addUserAbout"></textarea>
                                        </div>
                                    </div>
                                    <?php if (getUrlSegment(2) == 'film-festivals' || getUrlSegment(3) == 'team') : ?>
                                        <div class="form-group">
                                            <label class="form-label" for="addUserTeamType">Member Type</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select js-select2" id="addUserTeamType" name="team_type">
                                                    <option value="team">Team Member</option>
                                                    <option value="jury">JURY</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input style="display:none;" id="user_festival_id" name="festival_id" value="<?= $festival_id ?>">
                                        <input style="display:none;" id="user_festival_year" name="festival_year" value="0">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
        </form>
    </div>
</div>
<script>
    var addUser = document.getElementById('addUser')
    addUser.addEventListener('hidden.bs.modal', function(event) {
        if ($('#user_festival_year')) {
            $('#user_festival_year').val(0);
        }
    })
    // image preview tag
    var addUserImage = $('#addUserImage');
    // image icons
    var addUserImageIcon = $('.addUserImageIcon');
    var removeUserImageIcon = $('.removeUserImageIcon');
    // inputs
    var addUserProfilePic = $('#addUserProfilePic');
    var addUserFirstName = $('#addUserFirstName');
    var addUserLastName = $('#addUserLastName');
    var addUserEmail = $('#addUserEmail');
    var addUserMobile = $('#addUserMobile');
    var addUserProfession = $('#addUserProfession');
    var addUserAbout = $('#addUserAbout');

    addUserImageIcon.on('click', function(e) {
        e.preventDefault();
        addUserProfilePic.click();
    })
    removeUserImageIcon.on('click', function(e) {
        e.preventDefault();
        addUserProfilePic.val('');
        addUserImage.attr('src', defaultProfilePic);
        removeUserImageIcon.hide();
    })
    var previewUserImage = function(event, tagId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(tagId);
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        removeUserImageIcon.show();
    };

    var userForm = $('#addUpdateUser');
    userForm.submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(Array.from(formData));
        // return;
        $.ajax({
            url: "<?= route_to('admin_add_user_ajax') ?>",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response, textStatus, jqXHR) {
                var data = {};
                try {
                    data = JSON.parse(response);
                    if (data.success == true) {
                        alert('', data.message, 'info').then(() => {
                            location.reload()
                            // if (data_status == 0) {
                            //     $(this).attr('checked', 'checked');
                            // } else {
                            //     $(this).removeAttr('checked');
                            // }
                        })
                    } else {
                        alert(data.message, 'Error', 'error');
                    }
                } catch (e) {
                    console.log(e);
                    alert('Undefined error, please try after some time.', 'Error', 'error');
                }
            },
            error: function(response, textStatus, jqXHR) {
                console.log(response);
            }
        })
    });
</script>