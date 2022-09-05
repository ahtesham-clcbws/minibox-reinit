<div class="modal fade zoom" id="modalContact">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addContact" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Contact</h5>
            </div>
            <div class="modal-body">
                <input hidden type="hidden" class="form-control" id="contact_id" name="id" value="0">
                <div class="row gs-4">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label" for="contact_name">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" maxlength="150" class="form-control" id="contact_name" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label" for="contact_email">Email</label>
                            <div class="form-control-wrap">
                                <input type="text" maxlength="150" class="form-control" id="contact_email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label" for="contact_phone">Mobile</label>
                            <div class="form-control-wrap">
                                <input type="tel" maxlength="150" class="form-control" id="contact_phone" name="phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="contact_whatsapp">WhatsApp</label>
                            <div class="form-control-wrap">
                                <input type="tel" maxlength="150" class="form-control" id="contact_whatsapp" name="whatsapp" required>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>


<script>
    var contact_id = $('#contact_id');
    var contact_name = $('#contact_name');
    var contact_email = $('#contact_email');
    var contact_phone = $('#contact_phone');
    var contact_whatsapp = $('#contact_whatsapp');

    var modalContact = document.getElementById('modalContact');
    modalContact.addEventListener('hidden.bs.modal', function(event) {
        contact_id.val(0);
        contact_name.val('');
        contact_email.val('');
        contact_phone.val('');
        contact_whatsapp.val('');
    });

    function editContact(id, name, email, phone, whatsapp) {
        contact_id.val(id);
        contact_name.val(name);
        contact_email.val(email);
        contact_phone.val(phone);
        contact_whatsapp.val(whatsapp);

        modalShow('modalContact');
    }

    $('#addContact').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addContact', 'true');
        console.log(Array.from(formData));
        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                var data = {};
                try {
                    data = JSON.parse(response);
                    console.log(data);
                    if (data.success == true) {
                        alert('Successfully Add').then(() => {
                            location.reload();
                        })
                    } else {
                        alert(data.message, 'Error', 'error');
                    }
                } catch (e) {
                    console.log(e);
                    alert('Undefined error, please try after some time.', 'Error', 'error');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // console.log(errorThrown);
                // console.log(textStatus);
                // console.log(jqXHR);
                alert('Server error', 'Error', 'error');
            },
        })
    });

    async function deleteContact(id) {
        alert('', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    deleteContact: id
                };
                $.ajax({
                    url: '',
                    type: 'post',
                    data: formData,
                    success: function(response, textStatus, jqXHR) {
                        console.log(response);
                        var data = {};
                        try {
                            data = JSON.parse(response);
                            if (data.success == true) {
                                alert('', 'Deleted!', 'info').then(() => {
                                    location.reload()
                                })
                            } else {
                                alert(data.message, 'Error', 'error');
                            }
                        } catch (e) {
                            console.log(e);
                            alert('Undefined error, please try after some time.', 'Error', 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Server error', 'Error', 'error');
                    },
                })
            } else {
                alert('You saved a day.', 'Good choice!', 'success')
            }
        })
    }
</script>