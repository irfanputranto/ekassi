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

class Regis extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */
    protected $data = array(
        'title' => 'E-kas | Akun',
        'subtitel' => 'Akun'
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
        // Example
        $this->render_page('auth/Regis', $this->data);
    }

    public function get_data()
    {
        $table = 'tb_akun';
        $column_order = [null, 'nama_akun', 'username', 'image_akun', 'id_level'];
        $column_search = ['nama_akun', 'username', 'image_akun', 'id_level'];
        $order = ['tb_akun.id_akun' => 'asc'];
        $join = [
            'tb_level' => 'tb_level.id_level = tb_akun.id_level'
        ];
        /**
         * Data Site Datatables
         */
        $list = $this->models->get_datatables(null, $table, $join, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field['nama_akun'];
            $row[] = $field['username'];
            $row[] = $field['image_akun'];
            $row[] = $field['level'];
            $row[] = '<a><i class="fa fa-edit blue"></i></a> | <a><i class="fa fa-trash-o red"></i></a>';
            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($table),
            "recordsFiltered" => $this->models->count_filtered(null, $table, $join, $column_order, $column_search, $order),
            "data" => $data
        ];

        echo json_encode($output);
    }

    public function insert()
    {
        $data = array('success' => false, 'messages' => array());

        $namapengguna = htmlspecialchars($this->input->post('namalengkap'));
        $username = htmlspecialchars($this->input->post('username'));
        $password = htmlspecialchars($this->input->post('password'));
        $password2 = htmlspecialchars($this->input->post('password2'));
        $idlevel = htmlspecialchars($this->input->post('idlevel'));

        $this->form_validation->set_rules('namalengkap', 'Nama Lengkap', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'required' => '%s Tidak Boleh Kosong',
            'matches'  => '%s Tidak Sama',
            'min_length' => '%s Minimal panjang karakter 3'
        ]);

        $this->form_validation->set_rules('password2', 'Ulang Password', 'required|trim|min_length[3]|matches[password]', [
            'required' => '%s Tidak Boleh Kosong',
            'matches'  => '%s Tidak Sama',
            'min_length' => '%s Minimal panjang karakter 3'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {
            # code...
            $data['success'] = true;
        } else {
            # code..
            foreach ($_POST as $key => $value) {
                # code...
                $data['messages'][$key] = form_error($value);
            }
        }
        // echo json_encode($data);
    }
}
