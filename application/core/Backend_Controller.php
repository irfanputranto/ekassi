<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC
 *
 * @package    CodeIgniter-HMVC
 * @author     N3Cr0N (N3Cr0N@list.ru)
 * @copyright  2019 N3Cr0N
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 * @filesource
 *
 */

class BackendController extends MY_Controller
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout, ....
     */
    protected $data = array();

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();

        // CI profiler
        // $this->output->enable_profiler(true);

        // This function returns the main CodeIgniter object.
        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.
        $CI = &get_instance();

        //Example data
        // Site name
        // $this->data['sitename'] = 'CodeIgniter-HMVC';

        //Example data
        // Browser tab
        // $this->data['site_title'] = ucfirst('Admin Dashboard');
    }

    /**
     * [render_page description]
     *
     * @method render_page
     *
     * @param  [type]      $view [description]
     * @param  [type]      $data [description]
     *
     * @return [type]            [description]
     */
    protected function render_page($view, $data)
    {
        $this->load->view('Backend/templates/header', $this->data);
        $this->load->view('Backend/templates/main_sidebar', $this->data);
        $this->load->view('Backend/templates/main_header', $this->data);
        $this->load->view($view, $this->data);
        $this->load->view('Backend/templates/footer', $this->data);
        $this->load->view('Backend/templates/main_js', $this->data);
    }

    protected function auth_page($view, $data)
    {
        $this->load->view('Backend/templates/auth/header', $this->data);
        $this->load->view($view, $this->data);
        $this->load->view('Backend/templates/auth/footer', $this->data);
    }

    public function v_signin($username, $password, $putusername, $arrSession)
    {
        // $success, $wrong, $flashname = null, $flashcontent = null
        # code...
        $uname = $username;
        $pass = $password;

        $getpass = $putusername;

        if ($uname) {
            # code...
            if (password_verify($pass, $getpass)) {
                # code...
                $data = $arrSession;
                $this->session->set_userdata($data);
                $json = [
                    'code' => '200',
                    'data' => 'berhasil',
                    'username',
                    'password'
                ];
            } else {
                # code...
                $json = [
                    'code' => '500',
                    'data' => 'password salah',
                ];
            }
        } else {
            # code...
            $json = [
                'code' => '501',
                'data' => 'Username Belum Terdaftar',
            ];
        }

        try {
            $datajson = $json;
        } catch (Exception $error) {
            $datajson = $error->getMessage();
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($datajson));
    }

    public function admin()
    {
        # code...
        if ($this->session->userdata('id_level') != "1") {
            # code...
            redirect(base_url('home'));
        } elseif ($this->session->userdata('id_level') != "1") {
            # code...
        }
    }


    public function check_logged_in($redirect = null)
    {
        $logged_in = $this->session->userdata('username');
        $where = [
            'id_akun' => $this->session->userdata('id_akun')
        ];
        $user = $this->models->get_data(null, 'tb_akun', $where)->row_array();
        if ($logged_in === $user['username']) {
            # code...
            if ($logged_in != true) {
                # code...
                $this->session->set_flashdata('flash', '<div class="card bg-danger text-white shadow"><div class="card-body">Please Login!!</div></div>');
                redirect(base_url($redirect));
            }
        }
    }

    public function logout($redirect, $flashname = null, $flashcontent = null)
    {
        # code...
        $this->session->sess_destroy();
        $this->session->set_flashdata($flashname, $flashcontent);
        redirect(base_url($redirect));
    }
}
