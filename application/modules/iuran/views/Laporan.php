 <!-- page content -->
 <div class="right_col" role="main">
     <div class="">
         <div class="page-title">
             <!-- <div class="title_left">
                 <h3><?= $subtitel; ?> </h3>
             </div> -->

         </div>

         <div class="clearfix"></div>

         <div class="row">

             <div class="col-md-12 col-sm-12 col-xs-12">
                 <div class="x_panel">
                     <div class="x_title">
                         <h2><?= $laporansubtitel; ?></h2>

                         <div class="clearfix"></div>
                     </div>

                     <div class="x_content">
                         <div>
                             <div class="col-md-3">
                                 Rentang Tanggal
                                 <form class="form-horizontal">
                                     <fieldset>
                                         <div class="control-group">
                                             <div class="controls">
                                                 <div class="input-prepend input-group">
                                                     <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                     <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="<?= date('d-m-Y') ?>" />
                                                 </div>
                                             </div>
                                         </div>



                                     </fieldset>
                                 </form>
                             </div>

                             <div class="col-md-5" style="margin-top: 20px;">
                                 <form class="form-horizontal">
                                     <fieldset>
                                         <div class="control-group">
                                             <div class="controls">
                                                 <a href="<?= base_url('cetakiuran') ?>" class="btn btn-primary">Cetak</a>
                                             </div>
                                         </div>
                                     </fieldset>
                                 </form>
                             </div>

                         </div>

                         <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" data-link=<?= base_url('laporandata'); ?> data-posisicol="7" data-foot="iuran" cellspacing="0" width="100%">
                             <thead>
                                 <tr>
                                     <th class="text-center">No.</th>
                                     <th class="text-center">Tanggal</th>
                                     <th class="text-center">Kode Akun</th>
                                     <th class="text-center">Nama Akun</th>
                                     <th class="text-center">Nama Anggota</th>
                                     <th class="text-center">Jabatan</th>
                                     <th class="text-center">Keterangan</th>
                                     <th class="text-center">Jumlah</th>

                                 </tr>
                             </thead>
                             <tbody>
                             </tbody>
                             <tfoot>
                                 <tr>
                                     <th colspan="7" class="text-center">Total</th>
                                     <th class="text-right"></th>
                                 </tr>
                             </tfoot>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- /page content -->

 <div class="modal fade modalbutton" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                 </button>
                 <h4 class="modal-title"><i class="fa fa-plus blue"></i> Tambah Data</h4>
             </div>
             <form id="form" class="form-horizontal form-label-left">
                 <div class="modal-body">

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kdakun">Kode Akun
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="kdakun" id="select-0" class="form-control col-md-7 col-xs-12 input-kdakun clear-kdakun dataselect" data-link="<?= base_url('ia/kodeakun') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="anggota">Anggota
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="anggota" id="select-1" class="form-control col-md-7 col-xs-12 input-anggota clear-anggota dataselect" data-link="<?= base_url('ia/anggota') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>


                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jmlhiuran">Jumlah (Rp.)
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 input-jmlhiuran clear-jmlhiuran money" name="jmlhiuran" placeholder="Jumlah (Rp.)" type="text" autocomplete="off" data-affixes-stay="true" data-prefix="Rp " data-thousands="." data-decimal="," data-precision="0">
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ketiuran">Keterangan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <textarea name="ketiuran" cols="2" rows="2" class="form-control col-md-7 col-xs-12 input-ketiuran clear-ketiuran" placeholder="Keterangan"></textarea>
                             <span class="help-block"></span>
                         </div>
                     </div>


                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary simpan" data-link="<?= base_url('ia/tambah'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>


 <div class="modal fade updatemodal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                 </button>
                 <h4 class="modal-title"><i class="fa fa-edit blue"></i> Update Data</h4>
             </div>
             <form class="form-horizontal form-label-left">
                 <div class="modal-body">
                     <input type="hidden" name="id_iuran" class="edtinput-id_iuran clear-id_iuran">

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_kode_akun">Kode Akun
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="id_kode_akun" id="select-2" class="form-control col-md-7 col-xs-12 edtinput-id_kode_akun clear-id_kode_akun dataselect" data-link="<?= base_url('ia/kodeakun') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="anggota">Anggota
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="anggota" id="select-3" class="form-control col-md-7 col-xs-12 edtinput-anggota clear-anggota dataselect" data-link="<?= base_url('ia/anggota') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jmlhiuran">Jumlah (Rp.)
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 edtinput-jmlhiuran clear-jmlhiuran money" name="jmlhiuran" placeholder="Jumlah (Rp.)" type="text" autocomplete="off" data-affixes-stay="true" data-prefix="Rp " data-thousands="." data-decimal="," data-precision="0">
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ketiuran">Keterangan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <textarea name="ketiuran" cols="2" rows="2" class="form-control col-md-7 col-xs-12 edtinput-ketiuran clear-ketiuran" placeholder="Keterangan"></textarea>
                             <span class="help-block"></span>
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary edtsimpan" data-link="<?= base_url('ia/put'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>