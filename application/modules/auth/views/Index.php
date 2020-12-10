<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form id="form" method="POST">
                    <h1><?= $title; ?></h1>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control input-username clear-username" placeholder="Username" autofocus />
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control input-password clear-password" placeholder="Password" />
                        <span class="help-block"></span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-default signin" data-link="<?= base_url('validasi/data') ?>" data-pagelink="<?= base_url('home') ?>"><i class="fa fa-arrow-circle-right"></i> Masuk</button>
                    </div>
                    <div class="clearfix"></div>

                </form>
            </section>
        </div>
    </div>
</div>