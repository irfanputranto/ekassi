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
                         <h2><?= $subtitel; ?></h2>

                         <div class="clearfix"></div>
                     </div>
                     <div class="x_content">

                         <a class="btn btn-round btn-primary mb-5 mt-5 inputdata" data-toggle="modal" data-target=".modalbutton"> <span class="fa fa-plus"></span> Tambah</a>

                         <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" data-link=<?= base_url('jn/data'); ?> data-posisicol="6" data-posisicol1="7" data-foot="jurnal" cellspacing="0" width="100%">
                             <thead>
                                 <tr>
                                     <th class="text-center">No.</th>
                                     <th class="text-center">Tanggal</th>
                                     <th class="text-center">Kode Jurnal</th>
                                     <th class="text-center">Keterangan</th>
                                     <th class="text-center">Kode Akun</th>
                                     <th class="text-center">Nama Akun</th>
                                     <th class="text-center">Debet</th>
                                     <th class="text-center">Kredit</th>
                                     <th class="text-center">Aksi</th>
                                 </tr>
                             </thead>
                             <tbody>
                             </tbody>
                             <tfoot>
                                 <tr>
                                     <th colspan="6" class="text-center"></th>
                                     <th class="text-right"></th>
                                     <th class="text-right"></th>
                                     <th></th>
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
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="debet">Debet
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="debet" id="select-1" class="form-control col-md-7 col-xs-12 input-debet clear-debet dataselect" data-link="<?= base_url('jn/kodeakun') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kredit">Kredit
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="kredit" id="select-2" class="form-control col-md-7 col-xs-12 input-kredit clear-kredit dataselect" data-link="<?= base_url('jn/kodeakun') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jmljurnal">Jumlah (Rp.)
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 input-jmljurnal clear-jmljurnal money" name="jmljurnal" placeholder="Jumlah (Rp.)" type="text" autocomplete="off" data-affixes-stay="true" data-prefix="Rp " data-thousands="." data-decimal="," data-precision="0">
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ketjunral">Keterangan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <textarea name="ketjunral" cols="2" rows="2" class="form-control col-md-7 col-xs-12 input-ketjunral clear-ketjunral" placeholder="Keterangan"></textarea>
                             <span class="help-block"></span>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary simpan" data-link="<?= base_url('jn/tambah'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
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
                     <input type="hidden" name="id_jurnal" class="edtinput-id_jurnal clear-id_jurnal">
                     <input type="hidden" name="jenisdata" class="edtinput-jenisdata clear-jenisdata">

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jmljurnal">Jumlah (Rp.)
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 edtinput-jmljurnal clear-jmljurnal money" name="jmljurnal" placeholder="Jumlah (Rp.)" type="text" autocomplete="off" data-affixes-stay="true" data-prefix="Rp " data-thousands="." data-decimal="," data-precision="0">
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ketjunral">Keterangan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <textarea name="ketjunral" cols="2" rows="2" class="form-control col-md-7 col-xs-12 edtinput-ketjunral clear-ketjunral" placeholder="Keterangan"></textarea>
                             <span class="help-block"></span>
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary edtsimpan" data-link="<?= base_url('jn/put'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>