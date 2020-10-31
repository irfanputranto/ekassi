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

class Akunkas extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */

    protected $data = array(
        'title' => 'E-kas | Akun Akutansi',
        'subtitel' => 'Akun Akutansi'
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
        $this->render_page('Index', $this->data);
    }

    public function get_data()
    {
        $table = 'tb_data_akun';
        $column_order = [null, 'kode_akun', 'nama_akun'];
        $column_search = ['kode_akun', 'nama_akun'];
        $order = ['tb_data_akun.id_kode_akun' => 'desc'];
        /*
         * Data Site Datatables
         */
        $list = $this->models->get_datatables(null, $table, null, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field['kode_akun'];
            $row[] = $field['nama_akun'];
            $row[] = '<a class="ubah" data-link="' . base_url('kodeakun/ubah/') . $field['id_kode_akun'] . '"><i class="fa fa-edit blue"></i></a> | <a class="delete" data-link="' . base_url('kodeakun/hapus/') . $field['id_kode_akun'] . '"><i class="fa fa-trash-o red"></i></a>';
            $data[] = $row;
        }

        $json = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($table),
            "recordsFiltered" => $this->models->count_filtered(null, $table, null, $column_order, $column_search, $order),
            "data" => $data
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function insert()
    {
        $json = [];
        $kode_akun   = htmlspecialchars($this->input->post('kode_akun'));
        $nama_akun  = htmlspecialchars($this->input->post('nama_akun'));

        $this->form_validation->set_rules('kode_akun', 'Kode Akun', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('nama_akun', 'Nama Akun', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'kode_akun' => form_error('kode_akun'),
                'nama_akun' => form_error('nama_akun')
            ];
        } else {
            # code..
            $data = [
                'kode_akun'     => $kode_akun,
                'nama_akun'     => $nama_akun
            ];
            $this->models->save('tb_data_akun', $data);
            $json = [
                'status' => '1',
                'kode_akun',
                'nama_akun'
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
            'id_kode_akun' => $id
        ];
        $value = $this->models->get_data(null, 'tb_data_akun', $where)->row_array();

        $json = [
            'status'            => '1',
            'id_data_akun'      => $value['id_kode_akun'],
            'kode_akun'         => $value['kode_akun'],
            'nama_akun'         => $value['nama_akun']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json = [];
        $id_data_akun = htmlspecialchars($this->input->post('id_data_akun'));
        $kode_akun = htmlspecialchars($this->input->post('kode_akun'));
        $nama_akun = htmlspecialchars($this->input->post('nama_akun'));

        $this->form_validation->set_rules('id_data_akun', 'id data akun', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('kode_akun', 'Kode Akun', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);

        $this->form_validation->set_rules('nama_akun', 'nama_akun', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'id_data_akun'  => form_error('id_data_akun'),
                'kode_akun'   => form_error('kode_akun'),
                'nama_akun'   => form_error('nama_akun')
            ];
        } else {
            # code..
            $data = [
                'kode_akun'     => $kode_akun,
                'nama_akun'    => $nama_akun,
            ];
            $where = [
                'id_kode_akun' => $id_data_akun
            ];
            $this->models->edit('tb_data_akun', $data, $where);
            $json = [
                'status' => '1',
                'id_data_akun',
                'kode_akun',
                'nama_akun'
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
                'id_kode_akun' => $id
            ];
            $this->models->delete('tb_data_akun', $where);
            $json  = [
                'status' => '1'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
