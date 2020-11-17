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

class Iuran extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */

    protected $data = array(
        'title' => 'E-kas | Iuran Anggota',
        'subtitel' => 'Iuran Anggota'
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
        $table = 'tb_iuran';
        $column_order = [null, 'tb_iuran.id_anggota', 'tanggal_iuran', 'keterangan', 'keterangan', 'tb_iuran.id_kode_akun', 'id_akun', 'tb_anggota.nama_anggota', 'tb_data_akun.nama_akun', 'tb_data_akun.nama_akun', 'tb_jabatan.nama_jabatan'];
        $column_search = ['tb_iuran.id_anggota', 'tanggal_iuran', 'keterangan', 'keterangan', 'tb_iuran.id_kode_akun', 'id_akun', 'tb_anggota.nama_anggota', 'tb_data_akun.nama_akun', 'tb_data_akun.nama_akun', 'tb_jabatan.nama_jabatan'];
        $order = ['tb_iuran.id_iuran' => 'desc'];
        $join = [
            'tb_data_akun'  => 'tb_data_akun.id_kode_akun = tb_iuran.id_kode_akun',
            'tb_anggota'    => 'tb_anggota.id_anggota = tb_iuran.id_anggota',
            'tb_jabatan'    => 'tb_jabatan.id_jabatan = tb_anggota.id_jabatan'
        ];
        /*
         * Data Site Datatables
         */
        $this->db->where("to_char(tanggal_iuran, 'YYYY-MM-DD') >=", date('Y-m-d', strtotime('-1 month')));
        $this->db->where("to_char(tanggal_iuran, 'YYYY-MM-DD') <=", date('Y-m-d'));
        $list = $this->models->get_datatables(null, $table, $join, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = date("d-m-Y H:i:s", strtotime($field['tanggal_iuran']));
            $row[] = $field['kode_akun'];
            $row[] = $field['nama_akun'];
            $row[] = $field['nama_anggota'];
            $row[] = $field['nama_jabatan'];
            $row[] = $field['keterangan'];
            $row[] = 'Rp. ' . number_format($field['uang_iuran'], 0, ',', '.');
            $row[] = '<a class="ubah" data-link="' . base_url('ia/ubah/') . $field['id_iuran'] . '"><i class="fa fa-edit blue"></i></a>';
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
        $kdakun     = htmlspecialchars($this->input->post('kdakun'));
        $anggota    = htmlspecialchars($this->input->post('anggota'));
        $jmlhiuran  = htmlspecialchars($this->input->post('jmlhiuran'));
        $ketiuran   = htmlspecialchars($this->input->post('ketiuran'));



        $this->form_validation->set_rules('kdakun', 'Kode Akun', 'required', [
            'required' => '%s Harus Dipilih'
        ]);
        $this->form_validation->set_rules('anggota', 'Anggota', 'required', [
            'required' => '%s Harus Dipilih'
        ]);
        $this->form_validation->set_rules('jmlhiuran', 'Jumlah (Rp.)', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ketiuran', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'kdakun'     => form_error('kdakun'),
                'anggota'    => form_error('anggota'),
                'jmlhiuran'  => form_error('jmlhiuran'),
                'ketiuran'   => form_error('ketiuran')
            ];
        } else {
            # code..
            $select = 'MAX(RIGHT(kdbuktiia,2)) AS kd_max';
            $table = 'tb_iuran';
            $where = "WHERE to_char(tanggal_iuran, 'YYYY-MM-DD') = to_char(now(), 'YYYY-MM-DD')";
            $kd = $this->models->cKode($select, $table, $where, 'IA');

            $strreplace = [
                '.',
                'Rp ',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jmlhiuran);
            $data = [
                'kdbuktiia'         => $kd,
                'tanggal_iuran'     => date('Y-m-d H:i:s'),
                'id_kode_akun'      => $kdakun,
                'id_anggota'        => $anggota,
                'uang_iuran'        => $rp,
                'keterangan'        => $ketiuran
            ];
            $this->models->save('tb_iuran', $data);
            $json = [
                'status' => '1',
                'kdakun',
                'anggota',
                'jmlhiuran',
                'ketiuran'
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
            'id_iuran' => $id
        ];
        $value = $this->models->get_data(null, 'tb_iuran', $where)->row_array();

        $json = [
            'status'            => '1',
            'id_iuran'          => $value['id_iuran'],
            'id_kode_akun'      => $value['id_kode_akun'],
            'anggota'           => $value['id_anggota'],
            'jmlhiuran'         => $value['uang_iuran'],
            'ketiuran'          => $value['keterangan']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json           = [];

        $id_iuran          = htmlspecialchars($this->input->post('id_iuran'));
        $id_kode_akun   = htmlspecialchars($this->input->post('id_kode_akun'));
        $anggota   = htmlspecialchars($this->input->post('anggota'));
        $jmlhiuran       = htmlspecialchars($this->input->post('jmlhiuran'));
        $ketiuran         = htmlspecialchars($this->input->post('ketiuran'));

        $this->form_validation->set_rules('id_iuran', 'id data', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('id_kode_akun', 'Kode Akun', 'required', [
            'required' => 'Pilih %s'
        ]);
        $this->form_validation->set_rules('anggota', 'Anggota', 'required', [
            'required' => 'Pilih %s'
        ]);

        $this->form_validation->set_rules('jmlhiuran', 'Jumlah (Rp.)', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ketiuran', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'        => '0',
                'id_iuran'      => form_error('id_iuran'),
                'id_kode_akun'  => form_error('id_kode_akun'),
                'anggota'       => form_error('anggota'),
                'jmlhiuran'     => form_error('jmlhiuran'),
                'ketiuran'      => form_error('ketiuran')
            ];
        } else {
            # code..
            $strreplace = [
                '.',
                'Rp',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jmlhiuran);

            $data = [
                'id_kode_akun'    => $id_kode_akun,
                'id_anggota'    => $anggota,
                'uang_iuran'      => $rp,
                'keterangan'      => $ketiuran
            ];
            $where = [
                'id_iuran' => $id_iuran
            ];
            $this->models->edit('tb_iuran', $data, $where);
            $json = [
                'status' => '1',
                'id_iuran',
                'id_kode_akun',
                'anggota',
                'jmlhiuran',
                'ketiuran'
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
            '0' => '<option value="">--Pilih--</option>' . implode($outselect),
            '2' => '<option value="">--Pilih--</option>' . implode($outselect),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function kdiurananggota()
    {
        $join = [
            'tb_jabatan' => 'tb_jabatan.id_jabatan = tb_anggota.id_jabatan'
        ];
        $anggota = $this->models->get_data(null, 'tb_anggota', null, $join)->result_array();
        foreach ($anggota as $data) {
            $row = [];
            $row[] = '<option value="' . $data['id_anggota'] . '">' . $data['nama_anggota'] . ' - ' . $data['nama_jabatan'] . '</option>';
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
            '3' => '<option value="">--Pilih--</option>' . implode($outselect),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
