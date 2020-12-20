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
                                                 <a href="<?= base_url('cetakkasmasuk') ?>" class="btn btn-primary">Cetak</a>
                                             </div>
                                         </div>
                                     </fieldset>
                                 </form>
                             </div>
                         </div>

                         <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" data-link=<?= base_url('laporandatakasmasuk'); ?> data-posisicol="6" data-foot="iuran" cellspacing="0" width="100%">
                             <thead>
                                 <tr>
                                     <th class="text-center">No.</th>
                                     <th class="text-center">Tanggal</th>
                                     <th class="text-center">Kode Bukti</th>
                                     <th class="text-center">Kode Akun</th>
                                     <th class="text-center">Nama Akun</th>
                                     <th class="text-center">Keterangan</th>
                                     <th class="text-center">Total</th>
                                 </tr>
                             </thead>
                             <tbody>
                             </tbody>
                             <tfoot>
                                 <tr>
                                     <th class="text-center" colspan="6"></th>
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