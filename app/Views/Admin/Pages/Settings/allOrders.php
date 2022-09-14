<?= $this->extend('Admin/Layout') ?>

<?= $this->section('css') ?>
<style>
    /* #movieRatingBlock, */
    /* #topic_name, */
    /* #type_name, */
    /* #imageInputBlock, */
    /* #imagePlaceholder, */
    /* #video_type_block, */
    #module_id_block {
        display: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title"><?= isset($pagename) && $pagename ? $pagename : 'Settings' ?></h3>
        </div>
    </div>
</div>
<div class="card card-bordered card-preview">
    <div class="card-inner">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#incomplete_orders"><em class="icon ni ni-caution"></em><span>In-Complete</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#completed_orders"><em class="icon ni ni-check-circle-cut"></em><span>Completed</span></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="incomplete_orders">
                <table class="datatable-init table nk-tb-list nk-tb-ulist">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col tb-col-md">User</th>
                            <th class="nk-tb-col tb-col-md">Receipt</th>
                            <th class="nk-tb-col tb-col-md">Status</th>
                            <th class="nk-tb-col tb-col-md">Entity</th>
                            <th class="nk-tb-col tb-col-md">Currency</th>
                            <th class="nk-tb-col tb-col-md">Amount</th>
                            <th class="nk-tb-col tb-col-md">Gateway</th>
                            <th class="nk-tb-col tb-col-md">Order ID</th>
                            <th class="nk-tb-col tb-col-md">Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($incompleteOrders as $key => $order) : ?>
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>

                                <td class="nk-tb-col tb-col-md">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead"><?= $order['user_name'] ?></span>
                                            <span><?= $order['user_email'] ?> <?= $order['user_phone'] ? '<br/>' . $order['user_phone'] : '' ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    #<?= $order['receipt'] ?>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    <?php

                                    if ($order['payment_status'] == 'pending' && !empty(trim($order['order_id'])) || !empty($order['payment_status']) && $order['payment_status'] != 'pending' && !empty(trim($order['order_id'])) || empty(trim($order['payment_status'])) && !empty(trim($order['order_id']))) {
                                        echo '<span class="badge bg-danger">Payment Error</span>';
                                    } else {
                                        echo '<span class="badge bg-gray">Not Initiated</span>';
                                    }

                                    // if ($order['payment_status'] == 'pending') {
                                    //     echo '<span class="badge bg-danger">Payment Error</span>';
                                    // } else if (!empty($order['payment_status']) && $order['payment_status'] != 'pending') {
                                    //     echo '<span class="badge bg-danger">Payment Error</span>';
                                    // } else if (empty(trim($order['payment_status'])) && !empty(trim($order['order_id']))) {
                                    //     echo '<span class="badge bg-danger">Payment Error</span>';
                                    // } else if (empty(trim($order['payment_status']))) {
                                    //     echo '<span class="badge bg-gray">Not Initiated</span>';
                                    // } else {
                                    //     echo $order['payment_status'];
                                    // }
                                    ?>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    <?= getNameofString($order['type_of_action']) ?>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= $order['currency'] ?>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    <?= number_to_currency($order['amount'], $order['currency'], 'en_US', 2) ?>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    <?= ucfirst($order['gateway']) ?>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= $order['order_id'] ?>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= date('d M Y', strtotime($order['created_at'])) . '<br/>' . date('g:s A', strtotime($order['created_at'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="completed_orders">
                <table class="datatable-init table nk-tb-list nk-tb-ulist">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"></th>
                            <th class="nk-tb-col tb-col-md">User</th>
                            <th class="nk-tb-col tb-col-md">Receipt</th>
                            <th class="nk-tb-col tb-col-md">Entity</th>
                            <th class="nk-tb-col tb-col-md">Currency</th>
                            <th class="nk-tb-col tb-col-md">Amount</th>
                            <th class="nk-tb-col tb-col-md">Gateway</th>
                            <th class="nk-tb-col tb-col-md">Order ID</th>
                            <th class="nk-tb-col tb-col-md">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($completedOrders as $key => $order) : ?>
                            <tr class="nk-tb-item">
                                <td class="nk-tb-col tb-col-md"><?= $key + 1 ?></td>

                                <td class="nk-tb-col tb-col-md">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead"><?= $order['user_name'] ?></span>
                                            <span><?= $order['user_email'] ?> <?= $order['user_phone'] ? '<br/>' . $order['user_phone'] : '' ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    #<?= $order['receipt'] ?>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= getNameofString($order['type_of_action']) ?>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= $order['currency'] ?>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    <?= number_to_currency($order['amount'], $order['currency'], 'en_US', 2) ?>
                                </td>

                                <td class="nk-tb-col tb-col-md">
                                    <?= ucfirst($order['gateway']) ?>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= $order['order_id'] ?>
                                </td>
                                <td class="nk-tb-col tb-col-md">
                                    <?= date('d M Y', strtotime($order['created_at'])) . '<br/>' . date('g:s A', strtotime($order['created_at'])) ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>

    <?= $this->section('js') ?>
    <script>
    </script>
    <?= $this->endSection() ?>