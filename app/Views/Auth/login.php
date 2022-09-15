<?= $this->extend('Layouts/Web/home') ?>

<?= $this->section('content') ?>

<div class="uk-section-small uk-section-default">
    <div class="uk-container">
        <h4 class="uk-heading-line uk-text-bold uk-text-center uk-animation-slide-bottom-medium">
            <span>
                Login
            </span>
        </h4>
        <div class="gridlove-box box-inner-p-bigger entry-content">
            <form class="uk-form-horizontal SignupForm" id="SignupForm" action="" method="post">
                <input name="login" value="true" class="uk-invisible">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Email Id</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="email" placeholder="Email Id" name="email">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Password</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="password" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="uk-margin uk-text-center">
                    <button type="submit" class="uk-button uk-button-primary btn-all-page">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
    $('.SignupForm').submit(function(e) {
        e.preventDefault();
        // $.ajaxSetup({});
        var formData = new FormData($(this)[0]);
        console.log(Array.from(formData));
        $.ajax({
            url: '<?= route_to('login') ?>',
            type: 'post',
            contentType: false,
            processData: false,
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    var role = data.user_data.role;
                    console.log(data);
                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in successfully'
                    }).then((result) => {
                        if (role == 'admin' || role == 'staff') {
                            return window.location = '<?= route_to('admin_dashboard') ?>';
                        }
                        return window.location = '<?= route_to('homepage') ?>';
                    })
                    // alert('Success', 'Successfully logged in').then((result) => {
                    //     if (role == 'admin' || role == 'staff') {
                    //         return window.location = '<?= route_to('admin_dashboard') ?>';
                    //     }
                    //     return window.location = '<?= route_to('homepage') ?>';
                    // })
                } else {
                    var errorMessage = data.message ? data.message : 'Error logging in';
                    alert('Error', errorMessage, 'error').then((result) => {
                        // return locatop
                    })
                }
            },
            error: function(error) {
                console.log(error);
                alert('Error', 'There is some error into the server. Please try again later.', 'error');
            },
        });
    })
</script>
<?= $this->endSection() ?>