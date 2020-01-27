<link rel="stylesheet" href="<?= asset_url() . 'css/pages/treatment.css' ?>">
<script src="<?= asset_url() . 'js/ellipsis/jquery.ellipsis.min.js' ?>"></script>
</head>

<body>
    <?php $this->load->view('layouts/url'); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a href="<?= base_url() ?>">
            <img src="<?= asset_url() . 'img/icons/btnback.png' ?>" alt="back" width="12">
        </a>
        <a class="navbar-brand mx-auto" href="#" disabled>Treatment</a>
    </nav>


    <div class="container mt-4">
        <div class="loader">
            <div class="d-flex align-items-center mb-3" style="color:#ff6fa4 !important;">
                <h4 class="spinner-text">Loading...</h4>
                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>

        <div class="datas">
            <div class="alert alert-warning" role="alert">
                Tidak ada treatment
            </div>
        </div>
    </div>

    <script>
        var base_url = $('.base_url').val();
        var assets_url = $('.assets_url').val();
        $('.alert').hide();
        
        $.ajax({
            url: base_url + 'treatment/get/all',
            type: 'get',
            success: function(response) {
                $('.loader').hide();
                var x = JSON.parse(response);
                if (x.length == 0) {
                    $('.alert').show();
                } else {
                    $.each(x, function(key, value) {
                        $('.datas').append(`
                            <div class="data-` + key + `"></div>
                        `);

                        $('.data-' + key).append(`
                            <div class="row my-4 border-bottom animated fadeIn slow data">
                                <div class="col-5">
                                    <img class="w-100 treatment-img" src="` + assets_url + 'img/slide/slide3.jpg' + `">
                                    <div class="btn-group my-2" role="group" aria-label="Basic example">
                                        <a class="detail" href="` + base_url + 'treatment/detail/' + value.id + `">
                                            <button type="button" class="btn btn-secondary btn-sm shadow-sm">Detail</button>
                                        </a>
                                        <div class="divinder mx-1"></div>
                                        <a class="count" href="` + base_url + 'treatment/count/' + value.id + `">
                                            <button type="button" class="btn btn-secondary btn-sm shadow-sm">Count</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <p class="head-title text-truncate">` + value.treatment_name + `</p>
                                    <p class="desc">` + value.treatment_desc + `</p>
                                </div>
                            </div>
                        `);
                    });
                    $('.desc').ellipsis({
                        row: 4
                    });
                }
            }
        });
    </script>