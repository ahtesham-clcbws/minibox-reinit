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
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <!-- <th class="nk-tb-col">Status</th> -->
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col"></th>
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
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <!-- <th class="nk-tb-col">Status</th> -->
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col"></th>
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
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <!-- <th class="nk-tb-col">Status</th> -->
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col"></th>
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
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <!-- <th class="nk-tb-col">Status</th> -->
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col"></th>
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
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col">Festival</th>
                            <th class="nk-tb-col">Title</th>
                            <th class="nk-tb-col">Trailer</th>
                            <th class="nk-tb-col">Year</th>
                            <th class="nk-tb-col">Country</th>
                            <th class="nk-tb-col">Genres</th>
                            <!-- <th class="nk-tb-col">Status</th> -->
                            <th class="nk-tb-col">Dated</th>
                            <th class="nk-tb-col">Updated</th>
                            <th class="nk-tb-col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>

    <?= $this->section('js') ?>
    <script>
        function initiateTable(dataType = 'new') {
            if (!$.fn.DataTable.isDataTable('#' + dataType + '_datatable')) {
                var thisTable = NioApp.DataTable('#' + dataType + '_datatable', {
                    fixedHeader: true,
                    lengthMenu: [
                        [10, 15, 30, 50, 100, -1],
                        [10, 15, 30, 50, 100, 'All']
                    ],
                    searchDelay: 1000,
                    createdRow: function(row, data, dataIndex) {
                        console.log(dataType)
                        console.log(data)
                    },
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

                        },
                        // {
                        //     data: "status",
                        //     className: "nk-tb-col",

                        // },
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
                            className: "nk-tb-col py-0 text-right",
                            // render: function(data, type, row) {
                            //     return type === 'export' ? formatLink(data) : data;
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
        // {
        //     "title": "#",
        //     className: "nk-tb-col",
        //     render: function(data, type, row, meta) {
        //         return meta.row + meta.settings._iDisplayStart + 1;
        //     }
        // },
    </script>
    <?= $this->endSection() ?>