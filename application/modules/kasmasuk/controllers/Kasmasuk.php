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

class Kasmasuk extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */

    protected $data = array(
        'title' => 'E-kas | Kas Masuk',
        'subtitel' => 'Kas Masuk'
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
        $table = 'tb_kas_masuk';
        $column_order = [null, 'tb_kas_masuk.tanggal_km', 'tb_kas_masuk.ket_km', 'tb_kas_masuk.id_kode_akun', 'tb_kas_masuk.jumlahkm', 'tb_kas_masuk.kdbuktikm'];
        $column_search = ['tb_kas_masuk.tanggal_km', 'tb_kas_masuk.ket_km', 'tb_kas_masuk.id_kode_akun', 'tb_kas_masuk.jumlahkm', 'tb_kas_masuk.kdbuktikm'];
        $order = ['tb_kas_masuk.id_km' => 'desc'];
        $join = [
            'tb_data_akun' => 'tb_data_akun.id_kode_akun = tb_kas_masuk.id_kode_akun'
        ];


        /*
         * Data Site Datatables
         */
        // $this->db->where('tb_kas_masuk.tanggal_km >', date('Y-m-d'));
        // $this->db->where('tb_kas_masuk.tanggal_km <', date('Y-m-d'));
        $list = $this->models->get_datatables(null, $table, $join, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = date("d-m-Y H:i:s", strtotime($field['tanggal_km']));
            $row[] = $field['kdbuktikm'];
            $row[] = $field['kode_akun'];
            $row[] = $field['nama_akun'];
            $row[] = $field['ket_km'];
            $row[] = 'Rp. ' . number_format($field['jumlahkm'], 0, ',', '.');
            $row[] = '<a class="ubah" data-link="' . base_url('km/ubah/') . $field['id_km'] . '"><i class="fa fa-edit blue"></i></a>';
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

    public function test()
    {
        $date = date('Y-m-d');
        $select = 'MAX(RIGHT(kdbuktikm,2)) AS kd_max';
        $table = 'tb_kas_masuk';
        $where = "WHERE TO_TIMESTAMP('2020-11-09 22:51:14', 'YYYY-MM-DD HH:MI:SS') = $date";
        // and id_user= $id 
        $kd = $this->models->cKode($select, $table, $where, 'KM');
        var_dump($kd);
    }

    public function insert()
    {
        $json = [];
        $kdakun   = htmlspecialchars($this->input->post('kdakun'));
        $jmlkm  = htmlspecialchars($this->input->post('jmlkm'));
        $ketkm  = htmlspecialchars($this->input->post('ketkm'));



        $this->form_validation->set_rules('kdakun', 'Kode Akun', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('jmlkm', 'Jumlah', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ketkm', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'kdakun'     => form_error('kdakun'),
                'jmlkm'      => form_error('jmlkm'),
                'ketkm'      => form_error('ketkm')
            ];
        } else {
            # code..
            $date = date('Y-m-d H:i:s');
            $select = 'MAX(RIGHT(kdbuktikm,2)) AS kd_max';
            $table = 'tb_kas_masuk';
            $where = "WHERE tanggal_km = ";
            // and id_user= $id 
            $kd = $this->models->cKode($select, $table, $where, 'KM');

            $strreplace = [
                '.',
                'Rp',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jmlkm);
            $data = [
                'kdbuktikm' => $kd,
                'tanggal_km' => date('Y-m-d H:i:s'),
                'id_kode_akun'     => $kdakun,
                'jumlahkm'     => $rp,
                'ket_km'     => $ketkm
            ];
            $this->models->save('tb_kas_masuk', $data);
            $json = [
                'status' => '1',
                'kdakun',
                'jmlkm',
                'ketkm'
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
            'id_km' => $id
        ];
        $value = $this->models->get_data(null, 'tb_kas_masuk', $where)->row_array();

        $json = [
            'status'            => '1',
            'id_km'             => $value['id_km'],
            'id_kode_akun'      => $value['id_kode_akun'],
            'jumlahkm'          => $value['jumlahkm'],
            'ket_km'          => $value['ket_km']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json           = [];
        $id_km          = htmlspecialchars($this->input->post('id_km'));
        $id_kode_akun   = htmlspecialchars($this->input->post('id_kode_akun'));
        $jumlahkm       = htmlspecialchars($this->input->post('jumlahkm'));
        $ket_km         = htmlspecialchars($this->input->post('ket_km'));

        $this->form_validation->set_rules('id_km', 'id data km', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('id_kode_akun', 'Kode Akun', 'required', [
            'required' => 'Pilih %s'
        ]);

        $this->form_validation->set_rules('jumlahkm', 'Jumlah', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ket_km', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'id_km'  => form_error('id_km'),
                'id_kode_akun'   => form_error('id_kode_akun'),
                'jumlahkm'   => form_error('jumlahkm'),
                'ket_km'   => form_error('ket_km')
            ];
        } else {
            # code..
            $strreplace = [
                '.',
                'Rp',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jumlahkm);

            $data = [
                'id_kode_akun'    => $id_kode_akun,
                'jumlahkm'        => $rp,
                'ket_km'          => $ket_km
            ];
            $where = [
                'id_km' => $id_km
            ];
            $this->models->edit('tb_kas_masuk', $data, $where);
            $json = [
                'status' => '1',
                'id_km',
                'id_kode_akun',
                'jumlahkm',
                'ket_km'
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
                'id_km' => $id
            ];
            $this->models->delete('tb_kas_masuk', $where);
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
        $kdakun = $this->models->get_data(null, 'tb_data_akun')->result_array();
        foreach ($kdakun as $data) {
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
            '1' => '<option value="">--Pilih--</option>' . implode($outselect),
            '2' => '<option value="">--Pilih--</option>' . implode($outselect),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
