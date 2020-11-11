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
        // $this->db->where('tb_kas_keluar.tanggal_kk', date('Y-m-d'));
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
            $row[] = '<a class="ubah" data-link="' . base_url('kk/ubah/') . $field['id_kk'] . '"><i class="fa fa-edit blue"></i></a>';
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
        $select = 'MAX(RIGHT(kdbuktikk,2)) AS kd_max';
        $table = 'tb_kas_keluar';
        $where = "WHERE to_char(tanggal_kk, 'YYYY-MM-DD') = to_char(now(), 'YYYY-MM-DD')";
        $kd = $this->models->cKode($select, $table, $where, 'KK');
        var_dump($kd);
        die;
    }

    public function insert()
    {
        $json = [];
        $kdakun   = htmlspecialchars($this->input->post('kdakun'));
        $jmlkk  = htmlspecialchars($this->input->post('jmlkk'));
        $ketkk  = htmlspecialchars($this->input->post('ketkk'));



        $this->form_validation->set_rules('kdakun', 'Kode Akun', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('jmlkk', 'Jumlah', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ketkk', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'kdakun'     => form_error('kdakun'),
                'jmlkk'      => form_error('jmlkk'),
                'ketkk'      => form_error('ketkk')
            ];
        } else {
            # code..
            $select = 'MAX(RIGHT(kdbuktikk,2)) AS kd_max';
            $table = 'tb_kas_keluar';
            $where = "WHERE to_char(tanggal_kk, 'YYYY-MM-DD') = to_char(now(), 'YYYY-MM-DD')";
            $kd = $this->models->cKode($select, $table, $where, 'KK');

            $strreplace = [
                '.',
                'Rp',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jmlkk);
            $data = [
                'kdbuktikk' => $kd,
                'tanggal_kk' => date('Y-m-d'),
                'id_kode_akun'     => $kdakun,
                'jumlahkk'     => $rp,
                'ket_kk'     => $ketkk
            ];
            $this->models->save('tb_kas_keluar', $data);
            $json = [
                'status' => '1',
                'kdakun',
                'jmlkk',
                'ketkk'
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
            'id_kk' => $id
        ];
        $value = $this->models->get_data(null, 'tb_kas_keluar', $where)->row_array();

        $json = [
            'status'            => '1',
            'id_kk'             => $value['id_kk'],
            'id_kode_akun'      => $value['id_kode_akun'],
            'jumlahkk'          => $value['jumlahkk'],
            'ket_kk'          => $value['ket_kk']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json           = [];
        $id_kk          = htmlspecialchars($this->input->post('id_kk'));
        $id_kode_akun   = htmlspecialchars($this->input->post('id_kode_akun'));
        $jumlahkk       = htmlspecialchars($this->input->post('jumlahkk'));
        $ket_kk         = htmlspecialchars($this->input->post('ket_kk'));

        $this->form_validation->set_rules('id_kk', 'id data kk', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('id_kode_akun', 'Kode Akun', 'required', [
            'required' => 'Pilih %s'
        ]);

        $this->form_validation->set_rules('jumlahkk', 'Jumlah', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ket_kk', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'id_kk'  => form_error('id_kk'),
                'id_kode_akun'   => form_error('id_kode_akun'),
                'jumlahkk'   => form_error('jumlahkk'),
                'ket_kk'   => form_error('ket_kk')
            ];
        } else {
            # code..
            $strreplace = [
                '.',
                'Rp',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jumlahkk);

            $data = [
                'id_kode_akun'    => $id_kode_akun,
                'jumlahkk'        => $rp,
                'ket_kk'          => $ket_kk
            ];
            $where = [
                'id_kk' => $id_kk
            ];
            $this->models->edit('tb_kas_keluar', $data, $where);
            $json = [
                'status' => '1',
                'id_kk',
                'id_kode_akun',
                'jumlahkk',
                'ket_kk'
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
                'id_kk' => $id
            ];
            $this->models->delete('tb_kas_keluar', $where);
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
