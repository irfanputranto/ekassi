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
        $column_order = [null, 'tanggal_kk', 'ket_kk', 'id_kode_akun', 'id_jurnal', 'total'];
        $column_search = ['tanggal_kk', 'ket_kk', 'id_kode_akun', 'id_jurnal', 'total'];
        $order = ['tb_kas_keluar.id_kk' => 'desc'];
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
            $row[] = $field['tanggal_kk'];
            $row[] = $field['id_kode_akun'];
            $row[] = $field['id_jurnal'];
            $row[] = $field['ket_kk'];
            $row[] = '<p class="text-right">' . 'Rp. ' . number_format($field['total'], 0, ',', '.') . '</p>';
            $row[] = '<a class="ubah" data-link="' . base_url('keluar/ubah/') . $field['id_kk'] . '"><i class="fa fa-edit blue"></i></a> | <a class="delete" data-link="' . base_url('keluar/hapus/') . $field['id_kk'] . '"><i class="fa fa-trash-o red"></i></a>';
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

    public function jabatan()
    {
        $jabatan = $this->models->get_data(null, 'tb_jabatan')->result_array();
        $select = [];
        $outselect = [];
        foreach ($jabatan as $data) {
            $row = [];
            $row[] = '<option value="' . $data['id_jabatan'] . '">' . $data['nama_jabatan'] . '</option>';
            $select[] = $row;
        }
        if (count($select) != null) {
            # code...
            for ($i = 0; $i < count($select); $i++) {
                # code...
                $select1 = [];
                $select1 = $select[$i][0];
                $outselect[] = $select1;
            }
        }
        $json = [
            '1' => '<option value="">--Pilih--</option>' . implode($outselect),
            '3' => '<option value="">--Pilih--</option>' . implode($outselect),
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function jenis_kelamin()
    {
        $jk = [
            [
                'id_jk' => '1',
                'jeniskelamin' => 'Laki - Laki'
            ],
            [
                'id_jk' => '2',
                'jeniskelamin' => 'Perempuan'
            ],
        ];
        foreach ($jk as $data) {
            $row = [];
            $row[] = '<option value="' . $data['id_jk'] . '">' . $data['jeniskelamin'] . '</option>';
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

    public function insert()
    {
        $json = [];
        $nama_anggota   = htmlspecialchars($this->input->post('nama_anggota'));
        $jenis_kelamin  = htmlspecialchars($this->input->post('jenis_kelamin'));
        $jabatan = htmlspecialchars($this->input->post('jabatan'));
        $foto = $this->models->file('foto');

        $this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'nama_anggota' => form_error('nama_anggota'),
                'jenis_kelamin' => form_error('jenis_kelamin'),
                'jabatan' => form_error('jabatan')
            ];
        } else {
            # code..
            $data = [
                'nama_anggota'    => $nama_anggota,
                'jenis_kelamin'   => $jenis_kelamin,
                'id_jabatan'      => $jabatan,
                'image_anggota'   => $foto
            ];
            $this->models->save('tb_anggota', $data);
            $json = [
                'status' => '1',
                'nama_anggota',
                'jenis_kelamin',
                'jabatan',
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
            'id_anggota' => $id
        ];
        $value = $this->models->get_data(null, 'tb_anggota', $where)->row_array();

        $json = [
            'status'        => '1',
            'id_anggota'    => $value['id_anggota'],
            'nama_anggota'  => $value['nama_anggota'],
            'jenis_kelamin' => $value['jenis_kelamin'],
            'jabatan'       => $value['id_jabatan'],
            'fileedt'       => $value['image_anggota']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }

    public function update()
    {
        $json = [];
        $id_anggota = htmlspecialchars($this->input->post('id_anggota'));
        $nama_anggota = htmlspecialchars($this->input->post('nama_anggota'));
        $jenis_kelamin = htmlspecialchars($this->input->post('jenis_kelamin'));
        $jabatan = htmlspecialchars($this->input->post('jabatan'));
        $edtfile = htmlspecialchars($this->input->post('fileedt'));
        $foto = $this->models->file('foto', $edtfile);

        $this->form_validation->set_rules('id_anggota', 'Id anggota', 'required', [
            'required' => '0'
        ]);
        $this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);

        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required', [
            'required' => '%s Tidak Boleh Kosong'
        ]);
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            # code...
            $json = [
                'status'     => '0',
                'id_anggota'  => form_error('id_anggota'),
                'nama_anggota'   => form_error('nama_anggota'),
                'jenis_kelamin'   => form_error('jenis_kelamin'),
                'jabatan'  => form_error('jabatan')
            ];
        } else {
            # code..
            $data = [
                'nama_anggota'     => $nama_anggota,
                'jenis_kelamin'    => $jenis_kelamin,
                'id_jabatan'       => $jabatan,
                'image_anggota'    => $foto
            ];
            $where = [
                'id_anggota' => $id_anggota
            ];
            $this->models->edit('tb_anggota', $data, $where);
            $json = [
                'status' => '1',
                'id_anggota',
                'nama_anggota',
                'jenis_kelamin',
                'jabatan',
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
                'id_anggota' => $id
            ];
            $this->models->delete('tb_anggota', $where);
            $json  = [
                'status' => '1'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
