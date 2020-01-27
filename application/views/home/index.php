<link rel="stylesheet" href="<?= asset_url() . 'css/pages/home.css' ?>">
</head>

<body>
    <div id="carouselExampleIndicators" class="carousel slide shadow-sm animated fadeIn" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="<?= asset_url() . 'img/slide/slide1-min.jpg' ?>" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?= asset_url() . 'img/slide/slide2-min.jpg' ?>" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?= asset_url() . 'img/slide/slide3-min.jpg' ?>" alt="First slide">
            </div>
        </div>
    </div>

    <div class="container text-center mt-4">
        <div class="row">
            <div class="col-sm-6">
                <p class="my-0 animated fadeIn">Hello, <?= $this->session->fullname_user ?></p>
                <p class="animated fadeIn">Welcome to Alaya Spa</p>

                <div class="btn-groups animated fadeInUp">
                    <a href="<?= base_url('treatment') ?>" class="btn btn-primary bg-pink w-100 text-center mb-3 shadow-sm">
                        <img class="float-left" src="<?= asset_url() . 'img/icons/Treatment.png' ?>" alt="Treatment" width="18"> Treatment
                    </a>
                    <a href="<?= base_url('statistic') ?>" class="btn btn-primary bg-pink w-100 text-center mb-3 shadow-sm">
                        <img class="float-left" src="<?= asset_url() . 'img/icons/statistic.png' ?>" alt="Statistic" width="18"> Statistic
                    </a>
                    <a href="<?= base_url('profile') ?>" class="btn btn-primary bg-pink w-100 text-center mb-3 shadow-sm">
                        <img class="float-left" src="<?= asset_url() . 'img/icons/profile_white.png' ?>" alt="Profile" width="18"> Profile
                    </a>
                    <a href="<?= base_url('absent') ?>" class="btn btn-primary bg-pink w-100 text-center mb-3 shadow-sm">
                        <img class="float-left" src="<?= asset_url() . 'img/icons/absen.png' ?>" alt="Absen" width="18"> Absen
                    </a>
                </div>
            </div>
        </div>
    </div>