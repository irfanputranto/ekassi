<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

class Auth extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */
    protected $data = array(
        'title' => 'E-kas | Login'
    );

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();
    }

    /**
     * [index description]
     *
     * @method index
     *
     * @return [type] [description]
     */
    public function index()
    {
        $this->auth_page('auth/Index', $this->data);
    }

    public function validate()
    {
        $this->form_validation->set_rules(
            'username',
            'Username',
            'trim|required',
            [
                'required' => '%s Tidak boleh kosong'
            ]
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required',
            ['required' => '%s Tidak boleh Kosong']
        );
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'code'  => '505',
                'username' => form_error('username'),
                'password' => form_error('password')
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($json));
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $where = [
                'username' => $username
            ];
            $user = $this->models->get_data(null, 'tb_akun', $where)->row_array();
            $passwordget = $user['password'];
            $uname = $user['username'];
            $arraysession = [
                'id_akun'       => $user['id_akun'],
                'username'      => $user['username'],
                'nama_akun'     => $user['nama_akun'],
                'image_akun'    => $user['image_akun'],
                'id_level'      => $user['id_level']
            ];
            $this->v_signin($uname, $password, $passwordget, $arraysession);
        }
    }

    public function keluar()
    {
        BackendController::logout('login');
    }
}
