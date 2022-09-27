<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    #module_id_block {
        display: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Official Submissions</h3>
        </div>
        <div class="nk-block-head-content">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRequestModal"><em class="ni ni-plus"></em> New Request</button>
        </div>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="submissionTab nav-link active" data-bs-toggle="tab" data-tabid="new" href="#new"><em class="icon ni ni-caution"></em><span>New</span></a>
            </li>
            <li class="nav-item">
                <a class="submissionTab nav-link" data-bs-toggle="tab" data-tabid="approval" href="#approval"><em class="icon ni ni-alert-c"></em><span>Awaiting Approval</span></a>
            </li>
            <li class="nav-item">
                <a class="submissionTab nav-link" data-bs-toggle="tab" data-tabid="review_admin" href="#review_admin"><em class="icon ni ni-alert"></em><span>Awaiting Review (Admin)</span></a>
            </li>
            <li class="nav-item">
                <a class="submissionTab nav-link" data-bs-toggle="tab" data-tabid="review_user" href="#review_user"><em class="icon ni ni-report"></em><span>Awaiting Review (User)</span></a>
            </li>
            <li class="nav-item">
                <a class="submissionTab nav-link" data-bs-toggle="tab" data-tabid="live" href="#live"><em class="icon ni ni-thumbs-up"></em><span>Live</span></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="new">
                <table class="table nk-tb-list nk-tb-ulist" id="new_datatable">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col text-start"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <th class="nk-tb-col">Source</th>
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="approval">
                <table class="table nk-tb-list nk-tb-ulist" id="approval_datatable">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col text-start"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <th class="nk-tb-col">Source</th>
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="review_admin">
                <table class="table nk-tb-list nk-tb-ulist" id="review_admin_datatable">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col text-start"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <th class="nk-tb-col">Source</th>
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="review_user">
                <table class="table nk-tb-list nk-tb-ulist" id="review_user_datatable">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col text-start"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <th class="nk-tb-col">Source</th>
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="live">
                <table class="table nk-tb-list nk-tb-ulist" id="live_datatable">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col text-start"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <th class="nk-tb-col">Source</th>
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="newRequestModal">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" id="newEntryRequestForm">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">New Entry Request</h5>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="form-label" for="source">From eg: Film Freeway etc..</label>
                    <div class="form-control-wrap">
                        <input type="text" maxlength="50" class="form-control" id="source" name="source" placeholder="Request source" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="user_name">Full Name</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Fullname" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="user_email">User email</label>
                    <div class="form-control-wrap">
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="User Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="festival_id">Festival</label>
                    <div class="form-control-wrap">
                        <select class="form-select js-select2" id="festival_id" name="festival_id" data-placeholder="Select Festival" data-search="on" required>
                            <option selected></option>
                            <?php foreach (getActiveFestivalsList() as $key => $festival) { ?>
                                <option value="<?= $festival['id'] ?>" data-edition="<?= $festival['edition'] ?>" data-year="<?= $festival['current_year'] ?>"><?= $festival['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="festival_year">Festival Year</label>
                    <div class="form-control-wrap">
                        <input type="number" maxlength="4" minlength="4" class="form-control" id="festival_year" name="festival_year" placeholder="Year" required>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-sm btn-primary" type="submit">Send Request</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    function initiateTable(dataType = 'new') {
        if (!$.fn.DataTable.isDataTable('#' + dataType + '_datatable')) {
            var thisTable = NioApp.DataTable('#' + dataType + '_datatable', {
                // bfilter
                ordering: false,
                bFilter: false,
                fixedHeader: true,
                lengthMenu: [
                    [10, 15, 30, 50, 100, -1],
                    [10, 15, 30, 50, 100, 'All']
                ],
                // searchDelay: 1000,
                // createdRow: function(row, data, dataIndex) {
                //     console.log(row)
                //     console.log(data)
                //     console.log(dataIndex)
                // },
                bProcessing: true,
                serverSide: true,
                ajax: {
                    url: "", // json datasource
                    type: "post",
                    data: {
                        order: [{
                            dir: 'desc'
                        }],
                        dataType: dataType
                    },
                    deferRender: true,
                    // success: function(response) {
                    //     console.log(response)
                    // }
                },
                columns: [{
                        data: "key",
                        className: "nk-tb-col",
                    },
                    {
                        data: "festival_name",
                        className: "nk-tb-col",
                    },
                    {
                        data: "title",
                        className: "nk-tb-col",

                    },
                    {
                        data: "trailer",
                        className: "nk-tb-col",

                    },
                    {
                        data: "year",
                        className: "nk-tb-col",

                    },
                    {
                        data: "country_name",
                        className: "nk-tb-col",

                    },
                    {
                        data: "genres",
                        className: "nk-tb-col",
                        // render: function(data, type, row) {
                        //     return data ? data : 'N/A';
                        // }

                    },
                    {
                        data: "source",
                        className: "nk-tb-col",
                    },
                    {
                        data: "created_at",
                        className: "nk-tb-col text-nowrap",

                    },
                    {
                        data: "updated_at",
                        className: "nk-tb-col text-nowrap",

                    },
                    {
                        data: "actions",
                        className: "nk-tb-col py-0 text-end",
                        // render: function(data, type, row) {
                        //     return data ? data : 'N/A';
                        // }
                    }
                ],
                fnInitComplete: function(oSettings, json) {
                    var input = $('#' + dataType + '_datatable_filter input').unbind(),
                        self = this.api(),
                        $searchButton = $('<button class="ms-1 btn btn-dim btn-icon btn-primary" title="Search">')
                        .html('<em class="icon ni ni-search"></em>')
                        .click(function() {
                            self.search(input.val()).draw();
                        }),
                        $clearButton = $('<button class="ms-1 btn btn-dim btn-icon btn-danger" title="Reset">')
                        .html('<em class="icon ni ni-cross-circle"></em>')
                        .click(function() {
                            input.val('');
                            $searchButton.click();
                        })
                    $('#' + dataType + '_datatable_filter').append($searchButton, $clearButton);

                    var $reloadButton = $('<button class="me-1 btn btn-dim btn-icon btn-primary" title="Reload Table">')
                        .html('<em class="icon ni ni-reload"></em>')
                        .click(function() {
                            $('#' + dataType + '_datatable').DataTable().ajax.reload();
                        })
                    $('#' + dataType + '_datatable_length').prepend($reloadButton);
                    // datatableCustomButtons();
                }
            });
            // $.fn.DataTable.ext.pager.numbers_length = 7;
        }
    }
    initiateTable('new');
    var tabElements = document.querySelectorAll('.submissionTab')
    tabElements.forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', function(event) {
            // console.log($(event.target).data('tabid'));
            initiateTable($(event.target).data('tabid'));
            // event.target // newly activated tab
            // event.relatedTarget // previous active tab
        })
    });

    var newRequestModal = document.getElementById('newRequestModal');
    newRequestModal.addEventListener('hidden.bs.modal', function(event) {
        $('#festival_year').removeAttr('min');
        $('#festival_year').removeAttr('max');
        $('#festival_year').val('');
        $('#festival_id').val('').trigger('change');
        $('#user_email').val('');
        // $('#reject_reason').val('');
    })
    $("#festival_id").change(function() {
        if ($(this).val()) {
            var element = $(this).find('option:selected');
            var edition = element.data("edition");
            var year = element.data("year");

            var editions = [];

            for ($i = 0; $i < edition; $i++) {
                editions.push(year - $i);
            }

            if (editions.length > 0) {
                if (editions.length > 1) {
                    minYear = editions[editions.length - 1];
                    maxYear = editions[0];
                } else {
                    minYear = editions[0];
                    maxYear = editions[0];
                }
                $('#festival_year').attr('min', minYear);
                $('#festival_year').attr('max', maxYear);
            } else {
                $('#festival_year').removeAttr('min');
                $('#festival_year').removeAttr('max');
            }

            $('#festival_year').val(editions[0] ? editions[0] : '');
        }
    });

    $('#newEntryRequestForm').submit(function(ev) {
        ev.preventDefault();
        var formData = new FormData($(this)[0]);
        formData.append('sendEntryRequest', 'true')
        console.log(Array.from(formData))
        $.ajax({
            url: '',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                try {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Send Successfully'
                        })
                        modalClose('newRequestModal');
                    } else {
                        var errorMessage = data.message ? data.message : 'Error happening, please try again later. CODE(PXI)';
                        alert('Error', errorMessage, 'error').then((result) => {})
                    }
                } catch (error) {
                    console.log(error);
                    var errorMessage = 'Error happening, please try again later. CODE(TCI)';
                    alert('Error', errorMessage, 'error').then((result) => {})
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error', 'There is some error into the server. Please try again later.', 'error');
            }
        })
    })
</script>
<?= $this->endSection() ?>