 <!-- page content -->
 <div class="right_col" role="main">
     <div class="">
         <div class="page-title">
             <div class="title_left">
                 <h3><?= $subtitel; ?> </h3>
             </div>

             <!-- <div class="title_right">
                 <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                     <div class="input-group">
                         <input type="text" class="form-control" placeholder="Search for...">
                         <span class="input-group-btn">
                             <button class="btn btn-default" type="button">Go!</button>
                         </span>
                     </div>
                 </div>
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

                         <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" data-link=<?= base_url('Akun/data'); ?> cellspacing="0" width="100%">
                             <thead>
                                 <tr>
                                     <th>No.</th>
                                     <th>Nama Lengkap</th>
                                     <th>Username</th>
                                     <th>Foto</th>
                                     <th>Akses</th>
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

 <div class="modal fade modalbutton" tabindex="-1" role="dialog" aria-hidden="true">
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
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_akun">Nama Lengkap
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input class="form-control col-md-7 col-xs-12 input-nama_akun clear-nama_akun" name="nama_akun" placeholder="Nama Pengguna" type="text" autocomplete="off">
                             <span class="help-block"></span>
                         </div>
                     </div>

                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="text" id="username" name="username" placeholder="Username" class="form-control col-md-7 col-xs-12 input-username clear-username" autocomplete="off">
                             <span class="help-block"></span>
                         </div>
                     </div>


                     <div class="item form-group">
                         <label for="password" class="control-label col-md-3">Kata Sandi</label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input id="password" type="password" name="password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12 input-password clear-password" autocomplete="off" placeholder="Kata Sandi">
                             <span class="help-block"></span>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Ulang Kata Sandi</label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input id="password2" type="password" name="password2" data-validate-linked="password" class="form-control col-md-7 col-xs-12 input-password2 clear-password2" autocomplete="off" placeholder="Ulang Kata Sandi">
                             <span class="help-block"></span>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="idlevel">Level
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="idlevel" id="idlevel" class="form-control col-md-7 col-xs-12 input-idlevel clear-idlevel dataselect" data-link="<?= base_url('Regis/level') ?>">
                             </select>
                             <span class="help-block"></span>
                         </div>
                     </div>
                     <div class="item form-group">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Foto
                         </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="file" id="foto" name="foto" placeholder="Foto" class="form-control col-md-7 col-xs-12 clear-foto">
                             <span class="help-block"></span>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default tutup" data-dismiss="modal">Tutup</button>
                     <button type="button" class="btn btn-primary simpan" data-link="<?= base_url('Akun/tambah'); ?>">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>