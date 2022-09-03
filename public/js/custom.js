
// var loadScripts = document.getElementById('loadScripts');
// if (!document.getElementById('sweetalertCss')) {
//     var link = document.createElement('link');
//     link.id = 'sweetalertCss';
//     link.rel = 'stylesheet';
//     link.type = 'text/css';
//     link.href = '/public/libs/sweetalert/sweetalert2.min.css';
//     link.media = 'all';
//     loadScripts.appendChild(link);
// }
// if (!document.getElementById('sweetalertJs')) {
//     var scriptTag = document.createElement('script');
//     scriptTag.id = 'sweetalertJs';
//     scriptTag.src = '/public/libs/sweetalert/sweetalert2.min.js';
//     scriptTag.type = 'text/javascript'
//     loadScripts.appendChild(scriptTag);
// }

function alert(title = 'Success', text = 'Your query is successfully sent.', icon = 'success', type = 'text', showCloseButton = null, showCancelButton = null, focusConfirm = null, confirmButtonText = null, cancelButtonText = null) {
    var options = {};
    if (title) {
        options.title = title;
    }
    if (icon) {
        options.icon = icon;
    }
    if (type == 'text') {
        options.text = text;
    } else {
        options.html = html;
    }
    if (showCloseButton) {
        options.showCloseButton = showCloseButton;
    }
    if (showCancelButton) {
        options.showCancelButton = showCancelButton;
    }
    if (focusConfirm) {
        options.focusConfirm = focusConfirm;
    }
    if (confirmButtonText) {
        options.confirmButtonText = confirmButtonText;
    }
    if (cancelButtonText) {
        options.title = cancelButtonText;
    }
    return Swal.fire(options);
}


// alert('title here').then((result) => {
//     /* Read more about isConfirmed, isDenied below */
//     if (result.isConfirmed) {
//         Swal.fire('Saved!', '', 'success')
//     } else if (result.isDenied) {
//         Swal.fire('Changes are not saved', '', 'info')
//     }
// })

$('#selectCountry').on('change', function (e) {
    var id = $(this).val();
    var formData = {};
    var formData = {
        id: id,
        getStatesByCountryId: 'true'
    };
    console.log(formData);
    $.ajax({
        url: commonFunctions,
        type: 'post',
        data: formData,
        success: function (response, textStatus, jqXHR) {
            console.log(response);
            var data = {};
            try {
                data = JSON.parse(response);
                if (data.success == true) {
                    var thisData = data.data;
                    var options = '<option value="" selected="" disabled="">Select State</option>';
                    thisData.forEach(state => {
                        options += '<option value="' + state.id + '">' + state.name + '</option>';
                    });
                    $('#selectState').html(options);
                } else {
                    alert(data.message, 'Error', 'error');
                }
            } catch (e) {
                console.log(e);
                alert('Undefined error, please try after some time.', 'Error', 'error');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Server error', 'Error', 'error');
        },
    })
})
$('#selectState').on('change', function (e) {
    var id = $(this).val();
    var formData = {};
    var formData = {
        id: id,
        getCitiesByStateId: 'true'
    };
    $.ajax({
        url: commonFunctions,
        type: 'post',
        data: formData,
        success: function (response, textStatus, jqXHR) {
            console.log(response);
            var data = {};
            try {
                data = JSON.parse(response);
                if (data.success == true) {
                    var thisData = data.data;
                    var options = '<option value="" selected="" disabled="">Select City</option>';
                    thisData.forEach(city => {
                        options += '<option value="' + city.id + '">' + city.name + '</option>';
                    });
                    $('#selectCity').html(options);
                } else {
                    alert(data.message, 'Error', 'error');
                }
            } catch (e) {
                console.log(e);
                alert('Undefined error, please try after some time.', 'Error', 'error');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Server error', 'Error', 'error');
        },
    })
})