<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    #module_id_block {
        display: none;
    }

    .buttons-copy-new:before {
        content: "\e9fb";
    }

    .buttons-add-new:before {
        content: "\eb3d";
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Dashboard' ?></h3>
        </div>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner">

        <ul class="nav nav-tabs mt-n3">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tickets_contacts">
                    <em class="icon ni ni-user"></em><span>Tickets & Contacts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#update_event">
                    <em class="icon ni ni-bell"></em><span>Update Event</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tickets_contacts">
                <div class="card-header bg-primary text-white fw-bold text-center mb-3">
                    EVENT TICKETS
                </div>
                <table class="table nk-tb-list nk-tb-ulist" id="tickets_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>INR</th>
                            <th>EUR</th>
                            <th>Details</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $key => $ticket) : ?>
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">
                                    <span><?= $key + 1 ?></span>
                                </td>
                                <td class="nk-tb-col">
                                    <span><?= number_to_currency($ticket['inr'], 'INR', 'en_US', 2) ?></span>
                                </td>
                                <td class="nk-tb-col">
                                    <span><?= number_to_currency($ticket['eur'], 'EUR', 'en_US', 2) ?></span>
                                </td>
                                <td class="nk-tb-col">
                                    <span><?= $ticket['details'] ?></span>
                                </td>
                                <td class="nk-tb-col text-end" style="min-width:70px;padding:0;">
                                    <button type="button" onclick="editTicket(<?= $ticket['id'] ?>, '<?= $ticket['details'] ?>', '<?= $ticket['inr'] ?>', '<?= $ticket['eur'] ?>')" class="btn btn-round btn-icon btn-sm btn-info"><em class="icon ni ni-edit"></em></button>
                                    <button type="button" onclick="deleteTicket(<?= $ticket['id'] ?>)" class="btn btn-round btn-icon btn-sm btn-danger"><em class="icon ni ni-trash"></em></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <hr>
                <div class="card-header bg-primary text-white fw-bold text-center mb-3">
                    EVENT CONTACTS
                </div>
                <table class="table nk-tb-list nk-tb-ulist" id="contacts_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>WhatsApp</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $key => $contact) : ?>
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col">
                                    <span><?= $key + 1 ?></span>
                                </td>
                                <td class="nk-tb-col">
                                    <span><?= $contact['name'] ?></span>
                                </td>
                                <td class="nk-tb-col">
                                    <span><?= $contact['email'] ?></span>
                                </td>
                                <td class="nk-tb-col">
                                    <span><?= $contact['phone'] ?></span>
                                </td>
                                <td class="nk-tb-col">
                                    <span><?= $contact['whatsapp'] ?></span>
                                </td>
                                <td class="nk-tb-col text-end" style="min-width:70px;padding:0;">
                                    <button type="button" onclick="editContact(<?= $contact['id'] ?>, '<?= $contact['name'] ?>', '<?= $contact['email'] ?>', '<?= $contact['phone'] ?>', '<?= $contact['whatsapp'] ?>')" class="btn btn-round btn-icon btn-sm btn-info"><em class="icon ni ni-edit"></em></button>
                                    <button type="button" onclick="deleteContact(<?= $contact['id'] ?>)" class="btn btn-round btn-icon btn-sm btn-danger"><em class="icon ni ni-trash"></em></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="update_event">
                <form enctype="multipart/form-data" id="addUpdateForm">
                    <input type="hidden" hidden value="addEvent" name="addEvent">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="event_type">Type of Event</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" id="event_type" name="type" required>
                                        <option <?= $event['type'] == 'global' ? 'selected' : '' ?> value="global">Global</option>
                                        <option <?= $event['type'] == 'festival' ? 'selected' : '' ?> value="festival">Festival</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-4 pb-4">
                                <div class="col" id="module_id_block" style="<?= $event['type'] == 'festival' ? 'display:block;' : '' ?>">
                                    <div class="form-group">
                                        <label class="form-label" for="module_id">Select <span id="module_name">Module</span></label>
                                        <div class="form-control-wrap">
                                            <select class="form-select" id="module_id" name="module_id">
                                                <option value="0" selected disabled></option>
                                                <?php if ($event['type'] == 'festival') : ?>
                                                    <?php foreach ($festivalData as $key => $value) : ?>
                                                        <option <?= $event['module_id'] == $value['id'] ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label" for="category">Category</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select" id="category" name="category" required>
                                                <option value="" disabled></option>
                                                <?php foreach ($categories as $key => $value) : ?>
                                                    <option <?= $event['category'] == $value['id'] ? 'selected' : '' ?> value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dates</label>
                                <div class="form-control-wrap">
                                    <div class="input-daterange date-picker-range input-group" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= $event['from_date'] ?>" id="from_date" name="from_date" required />
                                        <div class="input-group-addon">TO</div>
                                        <input type="text" class="form-control" value="<?= $event['to_date'] ?>" id="to_date" name="to_date" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Timing</label>
                                <div class="form-control-wrap">
                                    <div class="input-group">
                                        <input type="text" class="form-control time-picker" value="<?= $event['from_time'] ?>" id="from_time" name="from_time" required />
                                        <div class="input-group-addon">TO</div>
                                        <input type="text" class="form-control time-picker" value="<?= $event['to_time'] ?>" id="to_time" name="to_time" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="<?= $event['address'] ?>" maxlength="200" id="address" name="address" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="google_map">Google Map URL</label>
                                <div class="form-control-wrap">
                                    <input type="url" class="form-control" value="<?= $event['google_map'] ?>" id="google_map" name="google_map" required>
                                    <input type="hidden" hidden id="latitude" value="<?= $event['latitude'] ?>" name="latitude">
                                    <input type="hidden" hidden id="longitude" value="<?= $event['longitude'] ?>" name="longitude">
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="selectCountry">Country</label>
                                        <div class="form-control-wrap">
                                            <select name="country" class="form-select" autocomplete="off" id="selectCountry" required>
                                                <option value="" disabled="">Select Country</option>
                                                <?php foreach (getAllCountries() as $kkey => $country) : ?>
                                                    <option <?= $event['country'] == $country['id'] ? 'selected' : '' ?> value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="selectState">State</label>
                                        <div class="form-control-wrap">
                                            <select name="state" class="form-select" autocomplete="off" id="selectState" required>
                                                <option value="" disabled="">Select State</option>
                                                <?php foreach ($statesData as $kkey => $state) : ?>
                                                    <option <?= $event['state'] == $state['id'] ? 'selected' : '' ?> value="<?= $state['id'] ?>"><?= $state['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="selectCity">City</label>
                                        <div class="form-control-wrap">
                                            <select name="city" class="form-select" autocomplete="off" id="selectCity" required>
                                                <option value="" disabled="">Select City</option>
                                                <?php foreach ($cityData as $kkey => $city) : ?>
                                                    <option <?= $event['city'] == $city['id'] ? 'selected' : '' ?> value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="pincode">Pin code</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" value="<?= $event['pincode'] ?>" minlength="5" maxlength="7" id="pincode" name="pincode" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="col-lg-6">
                            <img src="<?= $event['image'] ?>" id="imagePlaceholder">
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" for="image_file">Image File</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="image_input" name="image">
                                        <label class="form-file-label" for="image_input">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="video_type">Video Type</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" id="video_type" name="video_type">
                                        <option value="" selected>None</option>
                                        <option <?= $event['video_type'] == 'youtube' ? 'selected' : '' ?> value="youtube">Youtube</option>
                                        <option <?= $event['video_type'] == 'vimeo' ? 'selected' : '' ?> value="vimeo">Vimeo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="video_url">Video ID (you have to submit the URL)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="<?= $event['video'] ?>" onchange="parseVideoUrl()" maxlength="200" id="video_url" name="video">
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="title">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" maxlength="200" value="<?= $event['title'] ?>" id="title" name="title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="content">Content</label>
                                <div class="form-control-wrap">
                                    <textarea class="tinymce-basic form-control" id="content" name="content"><?= html_entity_decode($event['content']) ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<div class="modal fade zoom" id="copyTicketModal">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="copyTicket" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">TCopy icket</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="copyTicketInput">Select Ticket</label>
                    <div class="form-control-wrap">
                        <select class="form-select js-select2" id="copyTicketInput" name="copyTicket">
                            <option value="0" selected disabled></option>
                            <?php foreach ($globalTickets as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>" title="<?= $value['details'] ?>"><?= number_to_currency($ticket['inr'], 'INR', 'en_US', 2) ?>/<?= number_to_currency($ticket['eur'], 'EUR', 'en_US', 2) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade zoom" id="copyContactModal">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="copyContact" action="" method="post">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Copy Contact</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="copyContactInput">Select Contact</label>
                    <div class="form-control-wrap">
                        <select class="form-select js-select2" id="copyContactInput" name="copyContact">
                            <option value="0" selected disabled></option>
                            <?php foreach ($globalContacts as $key => $value) : ?>
                                <option value="<?= $value['id'] ?>" title="<?= $value['email'] . ' / ' . $value['phone'] . ' / ' . $value['whatsapp'] ?>"><?= $value['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="/public/admin/css/editors/tinymce.css?ver=3.0.0">
<script src="/public/admin/js/libs/editors/tinymce.js?ver=3.0.0"></script>
<script src="/public/admin/js/editors.js?ver=3.0.0"></script>
<script src="/public/admin/js/libs/datatable-btns.js" type="text/javascript"></script>

<script>
    NioApp.DataTable('#tickets_table', {
        buttons: [{
            titleAttr: 'Copy Ticket',
            attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#copyTicketModal'
            },
            className: "buttons-copy-new"
        }, {
            titleAttr: 'Add Ticket',
            attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#modalTicket'
            },
            // action: function(e, dt, node, config) {
            //     addTicket();
            // },
            className: "buttons-add-new"
        }],
    });
    NioApp.DataTable('#contacts_table', {
        buttons: [{
            titleAttr: 'Copy Contact',
            attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#copyContactModal'
            },
            className: "buttons-copy-new"
        }, {
            titleAttr: 'Add Contact',
            attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#modalContact'
            },
            className: "buttons-add-new"
        }]
    });
    // $('.dt-export-title').text('');
    $.fn.DataTable.ext.pager.numbers_length = 7;

    const event_id = <?= $event_id ?>;

    const event_type = $('#event_type');
    const module_name = $('#module_name');
    const module_id = $('#module_id');
    const module_id_block = $('#module_id_block');

    const video_url = $('#video_url');
    const video_type = $('#video_type');

    const image_input = $('#image_input');
    const imagePlaceholder = $('#imagePlaceholder');

    const google_map = $('#google_map');
    const latitude = $('#latitude');
    const longitude = $('#longitude');

    event_type.change(function(ev) {
        const value = $(this).val();
        const moduleName = value.charAt(0).toUpperCase() + value.slice(1);
        module_name.html(moduleName);
        var formData = {
            getmoduleData: 'festival'
        };
        if (value == 'festival') {
            $.ajax({
                url: '',
                type: 'post',
                data: formData,
                success: function(response, textStatus, jqXHR) {
                    console.log(response);
                    var data = {};
                    try {
                        data = JSON.parse(response);
                        console.log(data);
                        if (data.success == true) {
                            var moduleData = data.data;
                            // ajax request to get all festival names & ids
                            // <option value="0" selected disabled></option>
                            var options = '<option value="" selected disabled></option>';
                            if (moduleData.length > 0) {
                                moduleData.forEach(module => {
                                    options += '<option value="' + module.id + '">' + module.name + '</option>';
                                });
                                module_id.html(options);
                                module_id.attr('required', 'required');
                                module_id_block.show();
                            } else {
                                module_id.html('<option value="" selected disabled></option>');
                                module_id.removeAttr('required');
                                module_id_block.hide();
                                alert(data.message, 'Error', 'error');
                            }
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
        } else {
            module_id.html('<option value="" selected disabled></option>');
            module_id.removeAttr('required');
            module_id_block.hide();
        }
    });
    video_type.change(function(ev) {
        var value = $(this).val();
        console.log(value)
        if (value) {
            video_url.attr('urltype', value);
            video_url.attr('required', 'required');
        } else {
            video_url.removeAttr('urltype');
            video_url.removeAttr('required');
        }
    });
    image_input.change(function(ev) {
        var output = document.getElementById('imagePlaceholder');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    });
    google_map.change(function(ev) {
        const value = $(this).val();
        if (value) {
            var longlat = /\/\@(.*),(.*),/.exec(value);
            latitude.val(longlat[1]);
            longitude.val(longlat[2]);
        } else {
            latitude.val('');
            longitude.val('');
        }
    });

    function parseVideoUrl() {
        var urltype = video_url.attr('urltype');
        var videoId = videoUrlGetID(urltype);
        video_url.val(videoId);
    }

    function videoUrlGetID(type) {
        var getId = null;
        var url = video_url.val();
        if (type == 'youtube') {
            getId = youtube_parser(url);
        } else {
            getId = vimeo_parser(url);
        }
        console.log(getId);
        return getId;
    }
    $('#addUpdateForm').submit(function(ev) {
        ev.preventDefault();
        const formData = new FormData($(this)[0]);
        formData.append('addEvent', 'true');
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
                        alert('', data.message).then(() => {
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
                alert('Server error', 'Error', 'error');
            },
        })
    })

    function addTicket() {
        modalShow('modalTicket');
    }

    function addContact() {
        modalShow('modalTicket');
    }

    $('#copyTicket').submit(function(ev) {
        ev.preventDefault();
        const formData = new FormData($(this)[0]);
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
                        alert('', data.message).then(() => {
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
                alert('Server error', 'Error', 'error');
            },
        })
    })
    $('#copyContact').submit(function(ev) {
        ev.preventDefault();
        const formData = new FormData($(this)[0]);
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
                        alert('', data.message).then(() => {
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
                alert('Server error', 'Error', 'error');
            },
        })
    })
</script>

<?= view('Admin/Pages/events/tickets_component'); ?>
<?= view('Admin/Pages/events/contacts_component'); ?>

<?= $this->endSection() ?>