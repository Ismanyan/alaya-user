<link rel="stylesheet" href="<?= asset_url() . 'css/pages/detail-treatment.css' ?>">
<script src="<?= asset_url() . 'js/ellipsis/jquery.ellipsis.min.js' ?>"></script>
</head>

<body>
    <?php $this->load->view('layouts/url'); ?>
    <input type="hidden" class="detailId" value="<?= $detailId ?>">

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a href="<?= base_url('absent/history') ?>">
            <img src="<?= asset_url() . 'img/icons/btnback.png' ?>" alt="back" width="12">
        </a>
        <a class="navbar-brand mx-auto" href="#" disabled>My Absent Detail</a>
    </nav>

    <div class="container text-center mt-3">
        <h4 class="absent-detail mb-3"></h4>
        <img class="w-100 treatment-image shadow" src="" alt="" srcset="">

        <div class="loader mt-3">
            <div class="d-flex align-items-center mb-3" style="color:#ff6fa4 !important;">
                <h4 class="spinner-text">Loading...</h4>
                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
            </div>
        </div>

        <div class="data mt-3">
            <div class="info text-left card shadow border-0 p-3">
                <table>
                    <tr>
                        <td><b>ID</b></td>
                        <td class="ml-1 user_id"> : </td>
                    </tr>
                    <tr>
                        <td><b>Cordinate</b></td>
                        <td class="ml-1 cordinate"> : </td>
                    </tr>
                    <tr>
                        <td><b>Waktu Masuk</b></td>
                        <td class="ml-1 entry_time"> : </td>
                    </tr>
                    <tr>
                        <td><b>Tanggal Masuk</b></td>
                        <td class="ml-1 absent_date"> : </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    <script>
        var base_url = $('.base_url').val();
        var detailId = $('.detailId').val();
        var assets_url = $('.assets_url').val();

        $('.data').hide();
        $.ajax({
            url: base_url + "absent/get/history/detail/" + detailId,
            type: 'get',
            success: function(response) {
                var x = JSON.parse(response);
                console.log(x);
                $('.loader').hide();
                $('.treatment-image').attr('src', assets_url + 'img/slide/slide3.jpg');
                $('.absent-detail').append(x[0].fullname);
                $('.user_id').append(x[0].user_id);
                $('.cordinate').append(x[0].address);
                $('.entry_time').append(x[0].absent_time);
                $('.absent_date').append(x[0].absent_date);
                $('.data').show();
                $('.cordinate').ellipsis({
                    row: 1
                });
            }
        });
    </script>