<li class="menu-header">Dashboard</li>
<li class="nav-item dropdown">
  <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Kode Akun</span></a>
  <ul class="dropdown-menu">
    <li><a class="nav-link" href="<?= site_url('akun1') ?>">Akun - 1</a></li>
    <li><a class="nav-link" href="<?= site_url('akun2') ?>">Akun - 2</a></li>
    <li><a class="nav-link" href="<?= site_url('akun3') ?>">Akun - 3</a></li>
  </ul>
</li>
<li class="menu-header">Activity</li>
<li class="#"><a class="nav-link" href="<?= site_url('jurnalumum') ?>"><i class="fas fa-calendar-alt"></i> <span>Jurnal Umum</span></a></li>
<li class="#"><a class="nav-link" href="<?= site_url('posting') ?>"><i class="fas fa-window-restore"></i></i><span>Posting</span></a></li>
<li class="#"><a class="nav-link" href="<?= site_url('neracasaldo') ?>"><i class="fas fa-clipboard-list"></i><span>Neraca Saldo</span></a></li>
<li class="#"><a class="nav-link" href="<?= site_url('neracalajur') ?>"><i class="fas fa-balance-scale"></i><span>Neraca Lajur</span></a></li>

<li class="nav-item dropdown">
  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Transaksi</span></a>
  <ul class="dropdown-menu">
    <li><a class="nav-link" href="<?= site_url('transaksi') ?>">Transaksi Jurnal</a></li>
    <li><a class="nav-link" href="<?= site_url('penyesuaian') ?>">Transaksi Penyesuaian</a></li>
    <li><a class="nav-link" href="<?= site_url('jurnalpenyesuaian') ?>">Jurnal Penyesuaian</a></li>
  </ul>
</li>

<li class="nav-item dropdown">
  <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Laporan Keuangan</span></a>
  <ul class="dropdown-menu">
    <li><a class="nav-link" href="<?= site_url('labarugi') ?>">Laba Rugi</a></li>
    <li><a class="nav-link" href="<?= site_url('pmodal') ?>">Perubahan Modal</a></li>
    <li><a class="nav-link" href="<?= site_url('neraca') ?>">Neraca</a></li>
    <li><a class="nav-link" href="<?= site_url('aruskas') ?>">Arus Kas</a></li>
  </ul>
</li>


<li class="#"><a class="nav-link" href="<?= site_url('admin') ?>"><i class="fas fa-users"></i><span>Users</span></a></li>