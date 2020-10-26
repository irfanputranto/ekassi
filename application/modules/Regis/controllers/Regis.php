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
}
