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

class Jurnal extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */

    protected $data = array(
        'title' => 'E-kas | Jurnal Umum',
        'subtitel' => 'Jurnal Umum',
        'laporantitle' => 'E-kas | Laporan Jurnal Umum',
        'laporansubtitel' => 'Laporan Jurnal Umum',
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
        BackendController::check_logged_in('login');
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
        $table = 'tb_jurnal';
        $column_order = [null, 'kodebukti_jurnal', 'tanggal_jurnal', 'id_kode_akun', 'debet', 'kredit', 'ket_jurnal', 'id_akun'];
        $column_search = ['kodebukti_jurnal', 'tanggal_jurnal', 'id_kode_akun', 'debet', 'kredit', 'ket_jurnal', 'id_akun'];
        $order = ['tb_jurnal.id_jurnal' => 'desc'];
        $join = [
            'tb_data_akun' => 'tb_data_akun.id_kode_akun = tb_jurnal.id_kode_akun'
        ];

        /*
         * Data Site Datatables
         */
        $this->db->where("to_char(tanggal_jurnal, 'YYYY-MM-DD') >=", date('Y-m-d'));
        $this->db->where("to_char(tanggal_jurnal, 'YYYY-MM-DD') <=", date('Y-m-d', strtotime('+1 month')));
        $this->db->like("kodebukti_jurnal", "JU");
        $list = $this->models->get_datatables(null, $table, $join, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = date("d-m-Y H:i:s", strtotime($field['tanggal_jurnal']));
            $row[] = $field['kodebukti_jurnal'];
            $row[] = $field['ket_jurnal'];
            $row[] = $field['kode_akun'];
            $row[] = $field['nama_akun'];
            $row[] = "Rp. " . number_format($field['debet'], 0, ',', '.');
            $row[] = "Rp. " . number_format($field['kredit'], 0, ',', '.');
            $row[] = '<a class="ubah" data-link="' . base_url('jn/ubah/') . $field['id_jurnal'] . '"><i class="fa fa-edit blue"></i></a>';
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
        $debet   = htmlspecialchars($this->input->post('debet'));
        $kredit   = htmlspecialchars($this->input->post('kredit'));
        $jmljurnal  = htmlspecialchars($this->input->post('jmljurnal'));
        $ketjunral  = htmlspecialchars($this->input->post('ketjunral'));


        $this->form_validation->set_rules('debet', 'Debet', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('kredit', 'Kredit', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('jmljurnal', 'Jumlah', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ketjunral', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'            => '0',
                'debet'             => form_error('debet'),
                'kredit'            => form_error('kredit'),
                'jmljurnal'         => form_error('jmljurnal'),
                'ketjunral'         => form_error('ketjunral')
            ];
        } else {
            # code..
            $select = 'MAX(RIGHT(kodebukti_jurnal,2)) AS kd_max';
            $table = 'tb_jurnal';
            $where = "WHERE to_char(tanggal_jurnal, 'YYYY-MM-DD') = to_char(now(), 'YYYY-MM-DD')";
            $kd = $this->models->cKode($select, $table, $where, 'JU');

            $strreplace = [
                '.',
                'Rp',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jmljurnal);
            $debit = [
                'kodebukti_jurnal'     => $kd,
                'tanggal_jurnal'       => date('Y-m-d H:i:s'),
                'id_kode_akun'         => $debet,
                'debet'                => 0,
                'kredit'               => $rp,
                'ket_jurnal'           => $ketjunral
            ];
            $kredit = [
                'kodebukti_jurnal'      => $kd,
                'tanggal_jurnal'        => date('Y-m-d H:i:s'),
                'id_kode_akun'          => $kredit,
                'debet'                 => $rp,
                'kredit'                => 0,
                'ket_jurnal'            => $ketjunral
            ];
            $this->models->save('tb_jurnal', $debit);
            $this->models->save('tb_jurnal', $kredit);
            $json = [
                'status' => '1',
                'debet',
                'kredit',
                'jmljurnal',
                'ketjunral'
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
            'id_jurnal' => $id
        ];
        $value = $this->models->get_data(null, 'tb_jurnal', $where)->row_array();
        if ($value['debet'] != 0) {
            $jmljurnal = $value['debet'];
            $jns = 'D';
        } else {
            $jmljurnal = $value['kredit'];
            $jns = 'K';
        }
        $json = [
            'status'            => '1',
            'id_jurnal'         => $value['id_jurnal'],
            'jmljurnal'         => $jmljurnal,
            'ketjunral'         => $value['ket_jurnal'],
            'jenisdata'         => $jns
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json               = [];
        $id_jurnal          = htmlspecialchars($this->input->post('id_jurnal'));
        $jmljurnal          = htmlspecialchars($this->input->post('jmljurnal'));
        $ketjunral          = htmlspecialchars($this->input->post('ketjunral'));
        $jenisdata          = htmlspecialchars($this->input->post('jenisdata'));

        $this->form_validation->set_rules('id_jurnal', 'id data kk', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('jmljurnal', 'Jumlah', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('ketjunral', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('jenisdata', 'Keterangan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'id_jurnal'  => form_error('id_jurnal'),
                'jmljurnal'  => form_error('jmljurnal'),
                'ketjunral'   => form_error('ketjunral'),
                'jenisdata'   => form_error('jenisdata'),
            ];
        } else {
            # code..
            $strreplace = [
                '.',
                'Rp',
                ' '
            ];
            $rp = str_replace($strreplace, '', $jmljurnal);

            $debit = [
                'debet'                => $rp,
                'kredit'               => 0,
                'ket_jurnal'           => $ketjunral
            ];
            $kredit = [
                'debet'                 => 0,
                'kredit'                => $rp,
                'ket_jurnal'            => $ketjunral
            ];

            $where = [
                'id_jurnal' => $id_jurnal
            ];
            if ($jenisdata == "D") {
                $this->models->edit('tb_jurnal', $debit, $where);
            } else {
                $this->models->edit('tb_jurnal', $kredit, $where);
            }
            $json = [
                'status' => '1',
                'id_jurnal',
                'jmljurnal',
                'ketjunral',
                'jenisdata',
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
            '1' => '<option value="">--Pilih Debet--</option>' . implode($outselect),
            '2' => '<option value="">--Pilih Kredit--</option>' . implode($outselect),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }


    public function laporan()
    {
        $this->render_page('Laporan', $this->data);
    }

    public function get_data_laporan()
    {
        $tanggalawal    = $this->input->post('inputstart');
        $tanggalakhir   = $this->input->post('inputend');

        $session = [
            'tanggalawal'   => $tanggalawal,
            'tanggalakhir'  => $tanggalakhir
        ];
        $this->session->set_userdata($session);

        $table = 'tb_jurnal';
        $column_order = [null, 'kodebukti_jurnal', 'tanggal_jurnal', 'id_kode_akun', 'debet', 'kredit', 'ket_jurnal', 'id_akun'];
        $column_search = ['kodebukti_jurnal', 'tanggal_jurnal', 'id_kode_akun', 'debet', 'kredit', 'ket_jurnal', 'id_akun'];
        $order = ['tb_jurnal.id_jurnal' => 'desc'];
        $join = [
            'tb_data_akun' => 'tb_data_akun.id_kode_akun = tb_jurnal.id_kode_akun'
        ];

        /*
         * Data Site Datatables
         */
        if ($tanggalawal != null && $tanggalakhir != null) {

            $this->db->where(["to_char(tanggal_jurnal, 'YYYY-MM-DD') >=" => date("Y-m-d", strtotime($tanggalawal))]);
            $this->db->where(["to_char(tanggal_jurnal, 'YYYY-MM-DD') <=" => date("Y-m-d", strtotime($tanggalakhir))]);
        }
        $this->db->like("kodebukti_jurnal", "JU");
        $list = $this->models->get_datatables(null, $table, $join, $column_order, $column_search, $order)->result_array();
        $data = [];
        $no   = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = date("d-m-Y H:i:s", strtotime($field['tanggal_jurnal']));
            $row[] = $field['kodebukti_jurnal'];
            $row[] = $field['ket_jurnal'];
            $row[] = $field['kode_akun'];
            $row[] = $field['nama_akun'];
            $row[] = "Rp. " . number_format($field['debet'], 0, ',', '.');
            $row[] = "Rp. " . number_format($field['kredit'], 0, ',', '.');
            $data[] = $row;
        }

        if ($tanggalawal != null && $tanggalakhir != null) {
            # code...
            $this->db->where(["to_char(tanggal_jurnal, 'YYYY-MM-DD') >=" => date("Y-m-d", strtotime($tanggalawal))]);
            $this->db->where(["to_char(tanggal_jurnal, 'YYYY-MM-DD') <=" => date("Y-m-d", strtotime($tanggalakhir))]);
        }
        $recordsFiltered = $this->models->count_filtered(null, $table, $join, $column_order, $column_search, $order);

        $json = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->models->count_all($table),
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function cetak()
    {
        $mpdf = new \Mpdf\Mpdf();

        $tanggalawal = $this->session->userdata('tanggalawal');
        $tanggalakhir = $this->session->userdata('tanggalakhir');

        $this->db->select('*');
        $this->db->join('tb_data_akun', 'tb_data_akun.id_kode_akun = tb_jurnal.id_kode_akun');

        if ($tanggalawal != null && $tanggalakhir != null) {
            # code...
            $this->db->where(["to_char(tanggal_jurnal, 'YYYY-MM-DD') >=" => date("Y-m-d", strtotime($tanggalawal))]);
            $this->db->where(["to_char(tanggal_jurnal, 'YYYY-MM-DD') <=" => date("Y-m-d", strtotime($tanggalakhir))]);

            $tanggal = 'Tanggal ' . date('d-m-Y', strtotime($tanggalawal)) . ' - ' . date('d-m-Y', strtotime($tanggalakhir));
        } else {
            # code...
            $tanggal = '';
        }
        $this->db->order_by('id_jurnal', 'DESC');
        $data['laporandata'] = $this->db->get('tb_jurnal')->result_array();
        $data['tanggal'] = $tanggal;
        $data['title']  = 'Laporan Kas keluar';
        $download = 'Laporan_kaskeluar.pdf';
        $data = $this->load->view('Cetak', $data, TRUE);
        $mpdf->WriteHTML($data);
        $mpdf->Output($download, 'I');
    }
}
