 <!-- page content -->
 <div class="right_col" role="main">
     <div class="">
         <div class="page-title">
             <div class="title_left">
                 <h3><?= $subtitel; ?> </h3>
             </div>

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

                         <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" data-link=<?= base_url('keluar/data'); ?> cellspacing="0" width="100%">
                             <thead>
                                 <tr>
                                     <th>No.</th>
                                     <th>Tanggal</th>
                                     <th>Kode Akun</th>
                                     <th>Jurnal</th>
                                     <th>Keterangan</th>
                                     <th>Total</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tbody>
                             </tbody>
                             <!-- <tfoot>
                                 <tr>
                                     <th colspan="5"></th>
                                     <th style="text-align:right">Total:</th>
                                     <th></th>
                                 </tr>
                             </tfoot> -->
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
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_anggota">Nama Anggota
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 input-nama_anggota clear-nama_anggota" name="nama_anggota" placeholder="Nama Anggota" type="text" autocomplete="off">
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_kelamin">Jenis Kelamin
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="jenis_kelamin" id="select-0" class="form-control col-md-7 col-xs-12 input-jenis_kelamin clear-jenis_kelamin dataselect" data-link="<?= base_url('Anggota/jenis_kelamin') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">Jabatan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="jabatan" id="select-1" class="form-control col-md-7 col-xs-12 input-jabatan clear-jabatan dataselect" data-link="<?= base_url('Anggota/jabatan') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Foto
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="file" name="foto" placeholder="Foto" class="form-control col-md-7 col-xs-12 clear-foto">
                             <span class="help-block"></span>
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary simpan" data-link="<?= base_url('anggota/tambah'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
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
                     <input type="hidden" name="id_anggota" class="edtinput-id_anggota clear-id_anggota">
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_anggota">Nama Anggota
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 edtinput-nama_anggota clear-nama_anggota" name="nama_anggota" placeholder="Nama Anggota" type="text" autocomplete="off">
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_kelamin">Jenis Kelamin
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="jenis_kelamin" id="select-2" class="form-control col-md-7 col-xs-12 edtinput-jenis_kelamin clear-jenis_kelamin dataselect" data-link="<?= base_url('Anggota/jenis_kelamin') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">Jabatan
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="jabatan" id="select-3" class="form-control col-md-7 col-xs-12 edtinput-jabatan clear-jabatan dataselect" data-link="<?= base_url('Anggota/jabatan') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Foto
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="file" name="foto" placeholder="Foto" class="form-control col-md-7 col-xs-12 clear-foto">
                             <span class="help-block"></span>
                             <input type="hidden" name="fileedt" class="edtinput-fileedt clear-fileedt">
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary edtsimpan" data-link="<?= base_url('anggota/put'); ?>"><i class="fa fa-spinner fa-pulse loading" style="display: none;"></i> Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>