$(document).ready(function () {
    var base_url = $('.base_url').val();
    var time_now = $('.time_now').val();
    time_now = time_now.replace(':','');
    time_now = parseInt(time_now,10) + 10000;
    console.log(time_now);
    if (time_now >= 11000 && time_now <= 12400) {
        console.log('ok');
    } else {
        $('.absent').hide();
        Swal.fire({
            title: "Absent di luar jam kerja",
            icon: 'warning',
            text: "Absent hanya bisa di jam 10:00 s/d 23:00",
            timer: 4000,
            onClose: () => {
                window.location.replace(base_url);
            }
        });
    }
});