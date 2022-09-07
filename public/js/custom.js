
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

var youtubeModal = $('#youtubeModal');
var vimeoModal = $('#vimeoModal');

var youtubeModalIframe = $('#youtubeModalIframe');
var vimeoModalIframe = $('#vimeoModalIframe');

UIkit.util.on('#youtubeModal', 'hide', function (ev, index) {
    youtubeModalIframe.attr('src', '');
});
UIkit.util.on('#vimeoModal', 'hide', function (ev, index) {
    vimeoModalIframe.attr('src', '');
});
var youtubeThumb = $('.youtubeThumb');
youtubeThumb.on('click', function (ev) {
    var videoId = $(this).data('video');
    console.log(videoId);
    var videoLink = 'https://www.youtube-nocookie.com/embed/' + videoId;
    youtubeModalIframe.attr('src', videoLink);
    UIkit.modal(youtubeModal).show();
})
var vimeoThumb = $('.vimeoThumb');
vimeoThumb.on('click', function (ev) {
    var videoId = $(this).data('video');
    console.log(videoId);
    var videoLink = 'https://player.vimeo.com/video/' + videoId + '?h=948f95b102&autoplay=1&title=0&byline=0&portrait=0';
    vimeoModalIframe.attr('src', videoLink);
    UIkit.modal(vimeoModal).show();
})

$(document).ready(function () {
    $(".copyData").click(function () {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr('copyData')).select();
        document.execCommand("copy");
        $temp.remove();
        alert('', 'Copied');
    });

});

function getStars(rating) {
    const starFill = '<span class="fa-solid fa-star"></span>';
    const starHalf = '<span class="fa-solid fa-star-half"></span>';
    const starBlank = '<span class="fa-regular fa-star"></span>';

    var stars = [
        starBlank,
        starBlank,
        starBlank,
        starBlank,
        starBlank
    ];
    if (rating == 0.5) {
        stars[0] = starHalf;
    }
    if (rating == 1 || rating == 1.0) {
        stars[0] = starFill;
    }
    if (rating == 1.5) {
        stars[0] = starFill;
        stars[1] = starHalf;
    }
    if (rating == 2 || rating == 2.0) {
        stars[0] = starFill;
        stars[1] = starFill;
    }
    if (rating == 2.5) {
        stars[0] = starFill;
        stars[1] = starFill;
        stars[2] = starHalf;
    }
    if (rating == 3 || rating == 3.0) {
        stars[0] = starFill;
        stars[1] = starFill;
        stars[2] = starFill;
    }
    if (rating == 3.5) {
        stars[0] = starFill;
        stars[1] = starFill;
        stars[2] = starFill;
        stars[3] = starHalf;
    }
    if (rating == 4 || rating == 4.0) {
        stars[0] = starFill;
        stars[1] = starFill;
        stars[2] = starFill;
        stars[3] = starFill;
    }
    if (rating == 4.5) {
        stars[0] = starFill;
        stars[1] = starFill;
        stars[2] = starFill;
        stars[3] = starFill;
        stars[4] = starHalf;
    }
    if (rating == 5 || rating == 5.0) {
        stars[0] = starFill;
        stars[1] = starFill;
        stars[2] = starFill;
        stars[3] = starFill;
        stars[4] = starFill;
    }
    return stars;
}