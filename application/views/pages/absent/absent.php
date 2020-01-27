<link rel="stylesheet" href="<?= asset_url() . 'css/pages/absent.css' ?>">
<link rel="stylesheet" href="<?= asset_url() . 'css/splashscreen.css' ?>">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="<?= asset_url() . 'js/absent_alert.js' ?>"></script>
</head>

<body>
    <?php $this->load->view('layouts/url'); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a href="<?= base_url() ?>">
            <img src="<?= asset_url() . 'img/icons/back.png' ?>" alt="back" width="12">
        </a>
        <a class="navbar-brand mx-auto text-white" href="#" disabled>Absent</a>
    </nav>

    <div id="splashscreen" class="splashscreen">
        <img class="w-75 mx-auto d-block " src="<?= asset_url() . 'img/logo/alayaspa.png' ?>" style="background-image:url('<?= asset_url() . 'img/default-img.png' ?>'); ">
        <div class="text-center text-pink">
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
    </div>

    <div id="map">
        <div class="map-overlay"></div>
        <div class="map-container"></div>

        <button type="button" class="btn btn-primary area py-3 animated fadeInUp slow btn-absent absent">Cek Absen</button>
    </div>

    <script>
        $('.splashscreen').hide();
        var lat_user = $('.lat_user').val();
        var long_user = $('.long_user').val();

        L.Marker.prototype.animateDragging = function() {

            var iconMargin, shadowMargin;

            this.on('dragstart', function() {
                if (!iconMargin) {
                    iconMargin = parseInt(L.DomUtil.getStyle(this._icon, 'marginTop'));
                    shadowMargin = parseInt(L.DomUtil.getStyle(this._shadow, 'marginLeft'));
                }

                this._icon.style.marginTop = (iconMargin - 15) + 'px';
                this._shadow.style.marginLeft = (shadowMargin + 8) + 'px';
            });

            return this.on('dragend', function() {
                this._icon.style.marginTop = iconMargin + 'px';
                this._shadow.style.marginLeft = shadowMargin + 'px';
            });
        };

        var Map = function(elem, lat, lng) {
            this.$el = $(elem);
            this.$overlay = this.$el.find('.map-overlay');
            this.$map = this.$el.find('.map-container');
            this.init(lat, lng);
        };

        Map.prototype.init = function(lat, lng) {

            this.lat = lat;
            this.lng = lng;

            this.map = L.map(this.$map[0]).setView([lat, lng], 15);

            var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            var mapTiles = new L.TileLayer(osmUrl, {
                attribution: 'Map data &copy; ' +
                    '<a href="https://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                maxZoom: 18
            });

            this.map.addLayer(mapTiles);
        };

        Map.prototype.setCircle = function(latLng, meters) {
            if (!this.circle) {
                this.circle = L.circle(latLng, meters, {
                    color: '#097cf3',
                    fillColor: '#82c4ff',
                    fillOpacity: 0.5,
                }).addTo(this.map);

                var d = this.map.distance(['<?= $this->session->lat_user ?>', '<?= $this->session->long_user ?>'], this.circle.getLatLng());
                var isInside = d < this.circle.getRadius();
                if (isInside == true) {
                    $('.btn-absent').click(function() {
                        addAbsent();
                    });
                } else {
                    $('.btn-absent').click(function() {
                        Swal.fire({
                            title: "Absent Gagal",
                            icon: 'error',
                            text: "Anda absent di luar area lokasi. ",
                            timer: 2000,
                            // onClose: () => {
                            //     window.location.replace(base_url + 'treatment/history');
                            // }
                        });
                    });
                }
            } else {
                this.circle.setLatLng(latLng);
                this.circle.setRadius(meters);
                this.circle.redraw();
            }
            this.map.fitBounds(this.circle.getBounds());
        };

        Map.prototype.setLatLng = function(latLng) {
            this.lat = latLng.lat;
            this.lng = latLng.lng;

            if (this.circle) {
                this.circle.setLatLng(latLng);
            }
        };

        Map.prototype.centerOnLocation = function(lat, lng) {

            var self = this;

            this.lat = lat;
            this.lng = lng;

            if (!this.marker) {
                this.marker = L.marker([this.lat, this.lng], {
                    draggable: false
                });

                this.marker.on('drag', function(event) {
                    self.setLatLng(event.target.getLatLng());
                });

                this.marker
                    .animateDragging()
                    .addTo(this.map);
            }

            this.map.setView([this.lat, this.lng], 20);

            // TODO :: GANTI DENGAN LOKASI BRANCH USER
            this.setCircle(["<?= $this->session->branch_latitude_user  ?>", "<?= $this->session->branch_longitude_user  ?>"], this.milesToMeters(3));
        };

        // Conversion Helpers
        Map.prototype.milesToMeters = function(miles) {
            return miles * 10;
        };

        jQuery(function($) {
            console.log(<?= $this->session->branch_latitude_user  ?>);

            console.log(<?= $this->session->branch_longitude_user  ?>);
            var map = new Map('#map', "<?= $this->session->lat_user  ?>", "<?= $this->session->long_user  ?>", 10);
            map.centerOnLocation("<?= $this->session->lat_user  ?>", "<?= $this->session->long_user  ?>");
        });

        function addAbsent() {
            $('#map').hide();
            $('.splashscreen').show();

            var base_url = $('.base_url').val();
            var id_user = $('.id_user').val();
            var branch_id = $('.branch_id').val();
            var time_now = $('.time_now').val();

            $.ajax({
                url: base_url + 'absent/add',
                type: 'post',
                data: {
                    user_id: id_user,
                    position_id: 1,
                    branch_id: branch_id,
                    absent_time: time_now
                },
                success: function(response) {
                    let x = JSON.parse(response);
                    $('.splashscreen').hide();
                    if (x.code == 200) {
                        if (x.body.status == true) {
                            Swal.fire({
                                title: "Absent Sukses",
                                icon: 'success',
                                text: "Terimakasih telah absent hari ini",
                                timer: 2000,
                                onClose: () => {
                                    window.location.replace(base_url);
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Absent Gagal",
                                icon: 'error',
                                text: "Sudah absent hari ini",
                                timer: 2000,
                                onClose: () => {
                                    window.location.replace(base_url);
                                }
                            });
                        }
                    } else {
                        Swal.fire({
                            title: "Absent Gagal",
                            icon: 'warning',
                            text: "Terjadi error harap lapor admin",
                            timer: 4000,
                            onClose: () => {
                                window.location.replace(base_url);
                            }
                        });
                    }
                }
            });
        }
    </script>