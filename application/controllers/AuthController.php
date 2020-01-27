<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
    var $API = "";

    public function __construct()
    {
        parent::__construct();

        $this->API = getenv('APP_REST_URL');

        if ($this->session->logged_in_user) {
            redirect(base_url());
        }
    }

    //  Index Page
    public function login()
    {
        if ($this->session->password) {
            redirect(base_url('pin'));
        }

        // Data for send to view
        $data['title'] = 'Login | Alaya Spa';

        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/auth/login');
        $this->load->view('layouts/footer');
    }

    // Check Login
    public function check_login()
    {
        $query = $this->input->post();

        $response = request_auth($this->API.'/login',$query);
        
        if ($response['code'] == 200 && $response['body']->result->position_id == 1) {
            $sessionData = array(
                'id_user'       => $response['body']->result->id_user,
                'password_user' => true,
                'role_user'     => 1,
                'branch_id_user'=> $response['body']->result->branch_id,
                'branch_latitude_user'  => $response['body']->result->latitude,
                'branch_longitude_user' => $response['body']->result->longitude,
                'fullname_user' => $response['body']->result->fullname,
                'pin_user' => $response['body']->result->pin,
                'token_user'    => $response['body']->result->api_token
            );

            $this->session->set_userdata($sessionData);
        } 
        echo json_encode($response);

    }

    //  Index Page
    public function pin()
    {
        if (!$this->session->pin_user) {
            redirect(base_url('login'));
        }

        // Data for send to view
        $data['title'] = 'Pin | Alaya Spa';
        
        // Load view
        $this->load->view('layouts/header', $data);
        $this->load->view('pages/auth/pin');
        $this->load->view('layouts/footer');
    }

    public function pin_check(bool $status=false)
    {
        if ($status == true) {
            $sessionData = array(
                'logged_in_user' => true
            );

            $this->session->set_userdata($sessionData);   
            redirect(base_url());
        } else {
            redirect(base_url());
        }

    }
}
