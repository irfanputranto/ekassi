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

class Jabatan extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */

    protected $data = array(
        'title' => 'E-kas | Jabatan',
        'subtitel' => 'Jabatan'
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
        $table = 'tb_jabatan';
        $column_order = [null, 'nama_jabatan'];
        $column_search = ['nama_jabatan'];
        $order = ['tb_jabatan.id_jabatan' => 'desc'];
        // $join = [
        //     'tb_jabatan' => 'tb_jabatan.id_jabatan = tb_anggota.id_jabatan'
        // ];
        /**
         * Data Site Datatables
         */
        $list = $this->models->get_datatables(null, $table, null, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field['nama_jabatan'];
            $row[] = '<a class="ubah" data-link="' . base_url('jabatan/ubah/') . $field['id_jabatan'] . '"><i class="fa fa-edit blue"></i></a> | <a class="delete" data-link="' . base_url('jabatan/hapus/') . $field['id_jabatan'] . '"><i class="fa fa-trash-o red"></i></a>';
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
        $nama_jabatan   = htmlspecialchars($this->input->post('nama_jabatan'));
        $this->form_validation->set_rules('nama_jabatan', 'Nama Anggota', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'nama_jabatan' => form_error('nama_jabatan')
            ];
        } else {
            # code..
            $data = [
                'nama_jabatan'    => $nama_jabatan
            ];
            $this->models->save('tb_jabatan', $data);
            $json = [
                'status' => '1',
                'nama_jabatan'
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
            'id_jabatan' => $id
        ];
        $value = $this->models->get_data(null, 'tb_jabatan', $where)->row_array();

        $json = [
            'status'        => '1',
            'id_jabatan'    => $value['id_jabatan'],
            'nama_jabatan'  => $value['nama_jabatan']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json = [];
        $id_jabatan = htmlspecialchars($this->input->post('id_jabatan'));
        $nama_jabatan = htmlspecialchars($this->input->post('nama_jabatan'));

        $this->form_validation->set_rules('id_jabatan', 'Id anggota', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'id_jabatan'  => form_error('id_jabatan'),
                'nama_jabatan'   => form_error('nama_jabatan')
            ];
        } else {
            # code..
            $data = [
                'nama_jabatan'     => $nama_jabatan
            ];
            $where = [
                'id_jabatan' => $id_jabatan
            ];
            $this->models->edit('tb_jabatan', $data, $where);
            $json = [
                'status' => '1',
                'id_jabatan',
                'nama_jabatan'
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
                'id_jabatan' => $id
            ];
            $this->models->delete('tb_jabatan', $where);
            $json  = [
                'status' => '1'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
