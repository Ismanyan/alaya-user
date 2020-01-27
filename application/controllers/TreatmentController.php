<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TreatmentController extends CI_Controller
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
        $data['title'] = 'Treatment | Kubi Code';

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/treatment/treatment');
        $this->load->view('layouts/footer');
    }

    // GET ALL TREATMENT
    public function getTreatmentAll()
    {
        $response = request_get($this->API . '/get/all/treatment/list');
        // var_dump($response);
        if ($response->status == true) {
            echo json_encode($response->result);
        } else {
            echo json_encode($response->status);
        }
    }

    // Detail Page
    public function detail($id)
    {
        // Data for send to view
        $data['title'] = 'Treatment | Kubi Code';
        $data['detailId'] = $id;
        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/treatment/detail');
        $this->load->view('layouts/footer');
    }

    // Count Page
    public function count($id)
    {
        // Data for send to view
        $data['title'] = 'Treatment | Kubi Code';
        $data['detailId'] = $id;

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/treatment/count');
        $this->load->view('layouts/footer');
    }

    // Get Detail 
    public function getDetail($id) {
        $response = request_get($this->API . '/get/selected/treatment/'.$id);
        echo json_encode($response->result);
    }

    // Post Counting treatment
    public function postCounting()
    {
        $query = $this->input->post();
        $response = request_post($this->API. '/add/treatment/history',$query);
        echo json_encode($response['body']);
    }

    // Treatment history page
    public function history()
    {
        // Data for send to view
        $data['title'] = 'Treatment | Kubi Code';

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/profile/treatment');
        $this->load->view('layouts/footer');
    }

    // Get my treatment history
    public function getTreatmentHistory($id)
    {
        $response = request_get($this->API . '/get/all/treatment/history/' . $id);
        echo json_encode($response->result);
    }

    // Detail Treatment page
    public function treatmentHistoryDetail($id)
    {
        // Data for send to view
        $data['title'] = 'Treatment | Kubi Code';
        $data['detailId'] = $id;

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/profile/treatment_detail');
        $this->load->view('layouts/footer');
    }

    // Get my treatment history detail
    public function getTreatmentHistoryDetail($id)
    {
        $response = request_get($this->API . '/get/treatment/history/detail/' . $id);
        echo json_encode($response->result);
    }

}
