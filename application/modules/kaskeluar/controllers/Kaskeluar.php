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

class Kaskeluar extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */

    protected $data = array(
        'title' => 'E-kas | Kas Keluar',
        'subtitel' => 'Kas Keluar'
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
        $table = 'tb_kas_keluar';
        $column_order = [null, 'tb_kas_keluar.tanggal_kk', 'tb_kas_keluar.ket_kk', 'tb_kas_keluar.id_kode_akun', 'tb_kas_keluar.jumlahkk', 'tb_kas_keluar.kdbuktikk'];
        $column_search = ['tb_kas_keluar.tanggal_kk', 'tb_kas_keluar.ket_kk', 'tb_kas_keluar.id_kode_akun', 'tb_kas_keluar.jumlahkk', 'tb_kas_keluar.kdbuktikk'];
        $order = ['tb_kas_keluar.id_kk' => 'desc'];
        $join = [
            'tb_data_akun' => 'tb_data_akun.id_kode_akun = tb_kas_keluar.id_kode_akun'
        ];
        /*
         * Data Site Datatables
         */
        $list = $this->models->get_datatables(null, $table, $join, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = date("d-m-Y", strtotime($field['tanggal_kk']));
            $row[] = $field['kdbuktikk'];
            $row[] = $field['kode_akun'];
            $row[] = $field['nama_akun'];
            $row[] = $field['ket_kk'];
            $row[] = 'Rp. ' . number_format($field['jumlahkk'], 0, ',', '.');
            $row[] = '<a class="ubah" data-link="' . base_url('kodeakun/ubah/') . $field['id_kk'] . '"><i class="fa fa-edit blue"></i></a>';
            $data[] = $row;
        }

        $json = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($table),
            "recordsFiltered" => $this->models->count_filtered(null, $table, $join, $column_order, $column_search, $order),
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

    public function kdakun()
    {
        $jabatan = $this->models->get_data(null, 'tb_data_akun')->result_array();
        foreach ($jabatan as $data) {
            $row = [];
            $row[] = '<option value="' . $data['id_kode_akun'] . '">' . $data['kode_akun'] . ' - ' . $data['nama_akun'] . '</option>';
            $select[] = $row;
        }
        for ($i = 0; $i < count($select); $i++) {
            # code...
            $select1 = [];
            $select1 = $select[$i][0];
            $outselect[] = $select1;
        }
        $json = [
            '0' => '<option value="">--Pilih--</option>' . implode($outselect),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
