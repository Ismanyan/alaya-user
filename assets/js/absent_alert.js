$(document).ready(function () {
    var base_url = $('.base_url').val();
    var time_now = $('.time_now').val();
    time_now = time_now.replace(':','');
    time_now = parseInt(time_now,10) + 10000;

    if (time_now >= 10800 && time_now <= 11000) {
        // console.log('ok');
    } else {
        $('.absent').hide();
        Swal.fire({
            title: "Absent di luar jam kerja",
            icon: 'warning',
            text: "Absent hanya bisa di jam 08:00 s/d 10:00",
            // timer: 4000,
            onClose: () => {
                window.location.replace(base_url);
            }
        });
    }

    // $('.help').click(function () {
    //     Swal.fire({
    //         title: "Abent Manual",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Absent Manual',
    //         text: "Jika kordinat anda bermasalah anda bisa melakukan absent manual",
    //         footer: '<a href>Hubungi Cabang</a>' 
    //     }).then((result) => {
    //         if (result.value) {
                
    //             Swal.fire(
    //                 'Deleted!',
    //                 'Your file has been deleted.',
    //                 'success'
    //             )
    //         }
    //     })
    // });
});