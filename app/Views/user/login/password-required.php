<?= $this->extend('includes/layout') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/login/index.css'); ?>">
<style>
    .view {
        background: url("<?= base_url('images/nature-background.jpg') ?>")no-repeat center center;
        background-size: cover;
    }
</style>
<form method="POST" action="<?= base_url('user/login/password-required') ?>">
    <section class="view">
        <div class="mask rgba-stylish-strong h-100 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5">
                        <div class="card wow fadeIn" data-wow-delay="0.3s">
                            <div class="card-body">

                                <div class="form-header blue-gradient">
                                    <h3><i class="fas fa-user mt-2 mb-2"></i> Acesso Restrito</h3>
                                </div>

                                <div class="text-center">
                                    <img src="<?= base_url('images/logo-total-branca.png') ?>"></img>
                                    <h6 class="white-text"><?= session()->get('name') ?> </h6>
                                </div>

                                <div class="md-form">
                                    <i class="fas fa-lock prefix white-text"></i>
                                    <label for="password">Informe sua senha de acesso</label>
                                    <input name="password" type="password" class="form-control" autofocus required>
                                </div>


                                <div class="text-center">
                                    <button class="btn blue-gradient btn-lg">Acessar <i class="fas fa-arrow-right prefix white-text"></i></button>
                                </div>
                                <div class="text-center">
                                    <a class="btn peach-gradient btn-lg" href="<?= base_url(); ?>"><i class="fas fa-arrow-left prefix white-text"></i> Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<?= $this->endSection() ?>