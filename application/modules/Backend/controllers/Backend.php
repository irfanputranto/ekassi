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

class Backend extends BackendController
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */
    protected $data = array(
        'title' => 'E-kas | Dashboard'
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

        $this->render_page('dashboard/Index', $this->data);
    }

    public function chart()
    {
        $selectiu = 'sum(tb_iuran.uang_iuran) AS iuranrp';
        $whereiu  = [
            "to_char(tanggal_iuran, 'YYYY-MM-DD') >=" => date("Y-m-d", strtotime("-1 month")),
            "to_char(tanggal_iuran, 'YYYY-MM-DD') <=" => date("Y-m-d")
        ];
        $iuran = $this->models->get_data($selectiu, 'tb_iuran', $whereiu)->row_array();

        $selectkm = 'sum(tb_kas_masuk.jumlahkm) AS uangmasuk';
        $wherekm = [
            "to_char(tanggal_km, 'YYYY-MM-DD') >=" => date("Y-m-d", strtotime("-1 month")),
            "to_char(tanggal_km, 'YYYY-MM-DD') <=" => date("Y-m-d")
        ];
        $kasmasuk = $this->models->get_data($selectkm, 'tb_kas_masuk', $wherekm)->row_array();

        $selectkk  = 'sum(tb_kas_keluar.jumlahkk) AS uangkeluar';
        $wherekk   = [
            "to_char(tanggal_kk, 'YYYY-MM-DD') >=" => date("Y-m-d", strtotime("-1 month")),
            "to_char(tanggal_kk, 'YYYY-MM-DD') <=" => date("Y-m-d")
        ];
        $kaskeluar = $this->models->get_data($selectkk, 'tb_kas_keluar', $wherekk)->row_array();
        $html = '';
        $html .= '<div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-users blue"></i> Iuran</span>
        <div class="count blue">
           Rp. ' . number_format($iuran['iuranrp'], 0, ',', '.') . '
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-arrow-down green"></i> Kas Masuk</span>
        <div class="count green">Rp. ' . number_format($kasmasuk['uangmasuk'], 0, ',', '.') . '</div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-arrow-up red"></i> Kas Keluar</span>
        <div class="count red">Rp. ' . number_format($kaskeluar['uangkeluar'], 0, ',', '.') . '</div>
    </div>';

        $json = [
            'data' => $html
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
    }
}
