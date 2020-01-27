<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GeoController extends CI_Controller
{
    /**
     * Default controller
     *
     */

    var $API = "";

    public function __construct()
    {
        parent::__construct();
    }

    //  Index Page
    public function index($lat,$long)
    {
        // Data for send to view
        $data['title'] = 'Geo | Kubi Code';
        $sessionData = array(
            'lat_user'  => $lat,
            'long_user' => $long
        );

        $this->session->set_userdata($sessionData);
        redirect(base_url());
    }
}
