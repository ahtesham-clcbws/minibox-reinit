<div class="modal fade zoom" id="modalTicket">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="addTicket" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Ticket</h5>
            </div>
            <div class="modal-body">
                <input hidden type="hidden" class="form-control" id="ticket_id" name="id" value="0">
                <div class="row gs-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="ticket_inr">Price (INR)</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="ticket_inr" name="inr" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="ticket_eur">Price (EUR)</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="ticket_eur" name="eur" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label class="form-label" for="ticket_details">Ticket Details</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="ticket_details" name="details" required></textarea>
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
    var ticket_id = $('#ticket_id');
    var ticket_details = $('#ticket_details');
    var ticket_inr = $('#ticket_inr');
    var ticket_eur = $('#ticket_eur');

    var modalTicket = document.getElementById('modalTicket');
    modalTicket.addEventListener('hidden.bs.modal', function(event) {
        ticket_id.val(0);
        ticket_details.val('');
        ticket_inr.val('');
        ticket_eur.val('');
    });

    function editTicket(id, details, inr, eur) {
        ticket_id.val(id);
        ticket_details.val(details);
        ticket_inr.val(inr);
        ticket_eur.val(eur);

        modalShow('modalTicket');
    }
    $('#addTicket').submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('addTicket', 'true');
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
    async function deleteTicket(id) {
        alert('This action will not revert back, as it will delete all festival files and content also.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: id,
                    deleteTicket: true
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