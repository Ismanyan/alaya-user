<link rel="stylesheet" href="<?= asset_url() . 'css/pages/treatment.css' ?>">
<script src="<?= asset_url() . 'js/ellipsis/jquery.ellipsis.min.js' ?>"></script>
</head>

<body>
    <?php $this->load->view('layouts/url'); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a href="<?= base_url('statistic') ?>">
            <img src="<?= asset_url() . 'img/icons/btnback.png' ?>" alt="back" width="12">
        </a>
        <a class="navbar-brand mx-auto" href="#" disabled>My Absent</a>
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
                Tidak ada absent
            </div>
        </div>

        <a href="#" class="float" data-sort="DESC">
            <img class="my-float" src="<?= asset_url() . 'img/icons/sort.png' ?>" alt="Sort">
        </a>

    </div>



    <script>
        var base_url = $('.base_url').val();
        var id_user = $('.id_user').val();
        var assets_url = $('.assets_url').val();

        $('.datas').hide();
        $('.float').hide();

        function first(x) {
            var status = x;
            $.ajax({
                url: base_url + 'absent/get/history/' + id_user,
                type: 'get',
                success: function(response) {
                    $('.loader').hide();
                    $('.datas').show();
                    var x = JSON.parse(response);

                    // DESC
                    if (status == true) {
                        x.sort(function(a, b) {
                            return a - b
                        });
                    }

                    if (x.length == 0) {
                        $('.alert').show();
                    } else {
                        $('.float').show();
                        $('.alert').hide();
                        $.each(x, function(key, value) {
                            $('.datas').append(`
                                <div class="data-` + key + `"></div>
                            `);

                            $('.data-' + key).append(`
                                <a class="text-decoration-none" href="` + base_url + 'absent/history/detail/' + value.id + `">
                                    <div class="row my-4 border-bottom animated fadeIn slow">
                                        <div class="col-5">
                                            <img class="treatment-img w-100 mb-2" width="100" height="110" src="` + assets_url + 'img/default.jpg' + `" style="#">
                                        </div>
                                        <div class="col-7">
                                            <h5 class="head-title text-truncate">` + value.fullname + `</h5>
                                            <p class="desc mb-0">Time: ` + value.absent_time + `</p>
                                            <p class="desc">Date: ` + value.absent_date + `</p>
                                        </div>
                                    </div>
                                </a>
                            `);
                        });
                        $('.desc').ellipsis({
                            row: 4
                        });
                    }
                }
            });
        }

        first(null);

        $('.float').click(function() {
            var x = $(this).data('sort')
            // console.log(x);
            $('.loader').show();
            $('.datas').html('');

            if (x == 'DESC') {
                first(true);
                $('.float').data('sort', 'ASC');
            } else if (x == 'ASC') {
                first(null);
                $('.float').data('sort', 'DESC');
            }
        });
    </script>