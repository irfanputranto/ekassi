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
            $row[] = '<img src="' . base_url() . $field['image_akun'] . '" height="50px">';
            $row[] = $field['level'];
            $row[] = '<a class="ubah" data-link="' . base_url('Akun/ubah/') . $field['id_akun'] . '"><i class="fa fa-edit blue"></i></a> | <a class="delete" data-link="' . base_url('Akun/hapus/') . $field['id_akun'] . '"><i class="fa fa-trash-o red"></i></a>';
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

    public function level()
    {
        $level = $this->models->get_data(null, 'tb_level')->result_array();
        foreach ($level as $data) {
            $row = [];
            $row[] = '<option value="' . $data['id_level'] . '">' . $data['level'] . '</option>';
            $select[] = $row;
        }
        for ($i = 0; $i < count($select); $i++) {
            # code...
            $select1 = [];
            $select1 = $select[$i][0];
            $outselect[] = $select1;
        }
        $json = [
            'dataselcet' => '<option value="">--Pilih--</option>' . implode($outselect)
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function insert()
    {
        $json = [];
        $nama_akun = htmlspecialchars($this->input->post('nama_akun'));
        $username = htmlspecialchars($this->input->post('username'));
        $password = htmlspecialchars($this->input->post('password'));
        $password2 = htmlspecialchars($this->input->post('password2'));
        $idlevel = htmlspecialchars($this->input->post('idlevel'));
        $foto = $this->models->file('foto');

        $this->form_validation->set_rules('nama_akun', 'Nama Lengkap', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_akun.username]', [
            'required' => '%s Tidak Boleh Kosong',
            'is_unique' => '%s Tidak Boleh Sama'
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
        $this->form_validation->set_rules('idlevel', 'Level', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'nama_akun' => form_error('nama_akun'),
                'username' => form_error('username'),
                'password' => form_error('password'),
                'password2' => form_error('password2'),
                'idlevel' => form_error('idlevel')
            ];
        } else {
            # code..
            $data = [
                'nama_akun'     => $nama_akun,
                'username'      => $username,
                'password'      => password_hash($password2, true),
                'id_level'      => $idlevel,
                'image_akun'    => $foto
            ];
            $this->models->save('tb_akun', $data);
            $json = [
                'status' => '1',
                'nama_akun',
                'username',
                'password',
                'password2',
                'idlevel',
                'foto'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function put($id = null)
    {
        $json = [];
        $where = [
            'id_akun' => $id
        ];
        $value = $this->models->get_data(null, 'tb_akun', $where)->row_array();

        $json = [
            'status'        => '1',
            'id_akun'       => $value['id_akun'],
            'nama_akun'     => $value['nama_akun'],
            'username'      => $value['username'],
            'passwordold'   => $value['password'],
            'idlevel'       => $value['id_level'],
            'fileedt'       => $value['image_akun']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json = [];
        $id_akun = htmlspecialchars($this->input->post('id_akun'));
        $nama_akun = htmlspecialchars($this->input->post('nama_akun'));
        $username = htmlspecialchars($this->input->post('username'));
        $password = htmlspecialchars($this->input->post('password'));
        $password2 = htmlspecialchars($this->input->post('password2'));
        $idlevel = htmlspecialchars($this->input->post('idlevel'));
        $edtfile = htmlspecialchars($this->input->post('fileedt'));
        $foto = $this->models->fileedt('foto', $edtfile);
        $passwordold = htmlspecialchars($this->input->post('old_password'));

        $where = [
            'id_akun' => $id_akun
        ];
        $cekusername = $this->models->get_data(null, 'tb_akun', $where)->row_array();

        $this->form_validation->set_rules('id_akun', 'Id Akun', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('nama_akun', 'Nama Lengkap', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);

        if ($cekusername != $username) {
        } else {
            # code...
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_akun.username]', [
                'required' => '%s Tidak Boleh Kosong',
                'is_unique' => '%s Tidak Boleh Sama'
            ]);
        }

        if (!$passwordold) {
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
        }

        $this->form_validation->set_rules('idlevel', 'Level', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'nama_akun'  => form_error('nama_akun'),
                'username'   => form_error('username'),
                'password'   => form_error('password'),
                'password2'  => form_error('password2'),
                'idlevel'    => form_error('idlevel')
            ];
        } else {
            # code..
            $data = [
                'nama_akun'     => $nama_akun,
                'username'      => $username,
                'password'      => password_hash($password2, true),
                'id_level'      => $idlevel,
                'image_akun'    => $foto
            ];
            $where = [
                'id_akun' => $id_akun
            ];
            $this->models->edit('tb_akun', $data, $where);
            $json = [
                'status' => '1',
                'id_akun',
                'nama_akun',
                'username',
                'password',
                'password2',
                'idlevel',
                'foto'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function destroy($id = null)
    {
        $json = [];

        if (empty($id)) {
            # code...
            $json  = [
                'status' => '0'
            ];
        } else {
            # code...
            $where = [
                'id_akun' => $id
            ];
            $this->models->delete('tb_akun', $where);
            $json  = [
                'status' => '1'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
