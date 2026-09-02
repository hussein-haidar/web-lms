<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Profil Saya</h3>
            </div>

            <div class="box-body">
                <?php if (session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <center>
                    <div class="form-group">
                        <label>Foto Profil</label>
                        <p></p>
                        <img src="<?= base_url('fotoprofil/' . ($profil['foto_profil'] ?? 'default.png')) ?>"
                            class="img-circle"
                            width="100" height="100"
                            onerror="this.src='<?= base_url('fotoprofil/default.png') ?>'">
                    </div>
                </center>

                <div class="form-group">
                    <label>Email</label>
                    <input name="email" value="<?= esc($profil['email'] ?? '') ?>"
                        class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input name="username" value="<?= esc($profil['username'] ?? '') ?>"
                        class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input name="kata_sandi" type="password" id="ShowPass" value="<?= esc($profil['kata_sandi'] ?? '') ?>"
                        class="form-control" readonly>
                    <input type="checkbox" onclick="myFunction()">&nbsp; Show Password
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input name="nama_lengkap" value="<?= esc($profil['nama_lengkap'] ?? '') ?>"
                        class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" value="<?= esc($profil['no_telepon'] ?? '') ?>"
                        class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <input type="text" value="<?= ucfirst($profil['level'] ?? '') ?>"
                        class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Terakhir Login</label>
                    <input type="text" value="<?= esc($profil['last_login'] ?? 'Belum pernah login') ?>"
                        class="form-control" readonly>
                </div>

                <div class="text-center mt-3">
                    <a href="<?= base_url('home_superadmin/edit_profil') ?>"
                        class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

<script>
function myFunction() {
    var x = document.getElementById("ShowPass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

<?= $this->endSection() ?>