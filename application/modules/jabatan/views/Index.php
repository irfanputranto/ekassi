 <!-- page content -->
 <div class="right_col" role="main">
     <div class="">
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

                         <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" data-link=<?= base_url('jabatan/data'); ?> cellspacing="0" width="100%">
                             <thead>
                                 <tr>
                                     <th>No.</th>
                                     <th>Jabatan</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tbody>
                             </tbody>
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
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_jabatan">Jabatan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 input-nama_jabatan clear-nama_jabatan" name="nama_jabatan" placeholder="Jabatan" type="text" autocomplete="off">
                             <span class="help-block"></span>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary simpan" data-link="<?= base_url('jabatan/tambah'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
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
                     <input type="hidden" name="id_jabatan" class="edtinput-id_jabatan clear-id_jabatan">
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_jabatan">Jabatan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 edtinput-nama_jabatan clear-nama_jabatan" name="nama_jabatan" placeholder="Jabatan" type="text" autocomplete="off">
                             <span class="help-block"></span>
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary edtsimpan" data-link="<?= base_url('jabatan/put'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>