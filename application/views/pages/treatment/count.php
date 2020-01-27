<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link rel="stylesheet" href="<?= asset_url() . 'css/pages/detail-treatment.css' ?>">
<link rel="stylesheet" href="<?= asset_url() . 'css/splashscreen.css' ?>">
</head>

<body>
    <?php $this->load->view('layouts/url'); ?>
    <input type="hidden" class="detailId" value="<?= $detailId ?>">
    <input type="hidden" class="priceId1">
    <input type="hidden" class="priceId2">

    <!-- COUNTDOWN -->
    <div id="splashscreen" class="splashscreen container">
        <img class="w-75 mx-auto d-block " src="<?= asset_url() . 'img/logo/alayaspa.png' ?>" style="background-image:url('<?= asset_url() . 'img/default-img.png' ?>'); ">
        <center>

            <div class="text-center text-pink loaders">
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="row timer">
                <div class="col-12 mx-auto">
                    <div class="stopwatch" data-autostart="false">
                        <div class="time text-center">
                            <span class="hours"></span> :
                            <span class="minutes"></span> :
                            <span class="seconds"></span>
                        </div>
                        <div class="controls">
                            <!-- Some configurability -->
                            <button class="toggle btn btn-secondary w-100 p-2 mt-5 start" data-pausetext="Pause" data-resumetext="Resume"> Start</button>
                            <button type="button" class="finish btn btn-secondary w-100 mt-2 p-2 text-center">Finish</button>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
    <!-- END COUNTDOWN -->

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a href="<?= base_url('treatment') ?>">
            <img src="<?= asset_url() . 'img/icons/btnback.png' ?>" alt="back" width="12">
        </a>
        <a class="navbar-brand mx-auto" href="#" disabled>Counting Detail</a>
    </nav>

    <div class="container text-center mt-3 count-data">
        <img class="w-100 treatment-image shadow" src="" alt="" srcset="">

        <div class="loader mt-3">
            <div class="d-flex align-items-center mb-3" style="color:#ff6fa4 !important;">
                <h4 class="spinner-text">Loading...</h4>
                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>


        <div class="alert alert-warning" role="alert">
            Treatment tidak tersedia.
        </div>

        <div class="data mt-3">
            <h4 class="treatment-detail"></h4>
            <p class="treatment-desc"></p>
            <p class="duration"></p>

            <div class="row data mt-5">
                <div class="col-6">
                    <a href="#" class="btn btn-secondary w-100 py-3 start-btn">Start</a>
                </div>
                <div class="col-6">
                    <p class="m-0">Time: <span class="startTime"><?= date('h:i A') ?></span></p>
                    <p class="m-0">Date: <span class="date"><?= date('d/m/Y') ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= asset_url() . 'js/stopwatch.js'; ?>"></script>
    <script>
        var base_url = $('.base_url').val();
        var branch_id = $('.branch_id').val();
        var detailId = $('.detailId').val();
        var assets_url = $('.assets_url').val();

        $('.loaders').hide();
        $('.data').hide();
        $('.splashscreen').hide();
        $('.alert').hide();
        $.ajax({
            url: base_url + "treatment/get/detail/" + detailId,
            type: 'get',
            success: function(response) {
                $('.loader').hide();

                let x = JSON.parse(response);
                
                if (x.length == 0) {
                    $('.alert').show();
                } else {
                    $('.treatment-image').attr('src', assets_url + 'img/slide/slide3.jpg');
                    $('.data').show();
                    $('.treatment-detail').append(x[0].treatment_name);
                    $('.treatment-desc').append(x[0].treatment_desc);
                    $('.priceId1').val(x[0].treatment_price_id);
                    if (x.length == 1) {
                        $('.duration').append("Duration: " + x[0].treatment_duration + " Minute");
                    } else {
                        $('.priceId2').val(x[1].treatment_price_id);
                        $('.duration').append("Duration: ");
                        $.each(x, function(key, value) {
                            var last = x.length - 1;
                            if (key < last) {
                                $('.duration').append(value.treatment_duration + " - ");
                            } else {
                                $('.duration').append(value.treatment_duration);
                            }
                        });
                        $('.duration').append(" Minute");
                    }
                }
            }
        });

        $('.start-btn').click(function() {
            $('.count-data').hide();
            $('.splashscreen').show();
        });

        $('.finish').click(function() {
            let hours = $('.hours').text();
            let minutes = $('.minutes').text();
            let seconds = $('.seconds').text();
            let user_id = $('.id_user').val();
            let treatment_price_id = 0;
            let history_duration = hours + ":" + minutes;
            let treatment_time = $('.startTime').text();
            let treatment_date = $('.date').text();

            let minutesInt = parseInt($('.minutes').text());

            if (minutesInt <= 60) {
                treatment_price_id = $('.priceId1').val();
            } else {
                treatment_price_id = $('.priceId2').val();
            }

            $('.timer').hide();
            $('.loaders').show();

            $.ajax({
                url: base_url + "treatment/post/count",
                type: 'post',
                data: {
                    user_id: user_id,
                    treatment_id: detailId,
                    treatment_price_id: treatment_price_id,
                    history_duration: history_duration,
                    treatment_time: treatment_time,
                    treatment_date: treatment_date,
                    branch_id: branch_id
                },
                success: function(response) {
                    let x = JSON.parse(response);
                    console.log(x.status);
                    if (x.status == true) {
                        Swal.fire({
                            title: "Treatment Berhasil",
                            icon: 'success',
                            text: "Terima kasih sudah melakukan treatment",
                            timer: 2000,
                            onClose: () => {
                                window.location.replace(base_url + 'treatment/history');
                            }
                        });
                    } else {
                        console.log(x);
                        Swal.fire({
                            title: "Treatment Gagal",
                            icon: 'error',
                            text: "Terjadi error saat menambahkan. Hubungi admin segera",
                            // timer: 2000,
                            // onClose: () => {
                            //     window.location.replace(base_url);
                            // }
                        });
                    }
                }
            });
        });
    </script>