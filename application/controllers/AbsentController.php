<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsentController extends CI_Controller
{
    /**
     * Default controller
     *
     */

    var $API = "";

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->logged_in_user) {
            redirect(base_url('login'));
        }

        $this->API = getenv('APP_REST_URL');
    }

    //  Index Page
    public function index()
    {
        // Data for send to view
        $data['title'] = 'Absent | Kubi Code';

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/absent/absent');
        $this->load->view('layouts/footer');
    }

    // Add new absent
    public function absentAdd()
    {
        $query = $this->input->post();
        $response = request_post($this->API. '/add/absent',$query);
        echo json_encode($response);
    }

    // Get My History Absent
    public function history() 
    {
        // Data for send to view
        $data['title'] = 'Absent | Kubi Code';

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/profile/absent');
        $this->load->view('layouts/footer');
    }

    // Get my Absent history
    public function getAbsentHistory($id)
    {
        $response = request_get($this->API . '/get/all/absent/history/' . $id);
        echo json_encode($response->result);
    }

    // Detail absent
    public function absentHistoryDetail($id) {
        // Data for send to view
        $data['title'] = 'Treatment | Kubi Code';
        $data['detailId'] = $id;

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/profile/absent_detail');
        $this->load->view('layouts/footer');
    }

    // Get data detail absent
    public function getAbsentHistoryDetail($id)
    {
        $response = request_get($this->API . '/get/absent/history/detail/' . $id);
        echo json_encode($response->result);
    }
}
