<?php
	include "hak-akses.php";
	foreach ($hak_akses as $ha):
?>
<!-- START PAGE SIDEBAR -->
<div class="page-sidebar" >
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="<?= $base_url; ?>"></a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="<?= $base_url . 'assets/img/pegawai/' . $foto_pegawai; ?>" alt="<?= $foto_pegawai; ?>"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="<?= $base_url . 'assets/img/pegawai/' . $foto_pegawai; ?>" alt="<?= $foto_pegawai; ?>" alt="<?= $foto_pegawai; ?>"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name"><?= substr($nama_pegawai, 0, 10); ?></div>
                    <div class="profile-data-title"><?= strtoupper(substr($level_pegawai, 0, 10)); ?></div>
                </div>
            </div>                                                                        
        </li>
        

        <li <?php if($menu=='Dashboard') { echo 'class="active"'; } ?> >
            <a href="<?= $base_url; ?>"><span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span></a>                        
        </li>

        <?php
        	if(($ha['pembayaran']=='1') OR ($ha['transaksi']=='1') ) {
        ?>
        <li class="xn-title">Pembayaran</li>
        <?php
        	}
        	if(($ha['pembayaran']=='1')) {
        ?>                    
        <li <?php if($menu=='Transaksi') { echo 'class="active"'; } ?>>
            <a href="<?= $base_url . "page/transaksi/" ?>"><span class="fa fa-shopping-cart"></span> <span class="xn-text">Transaksi Pembayaran</span></a>
        </li>
        <?php
        	}
        	if(($ha['transaksi']=='1')) {
        ?>

        <li <?php if($menu=='Pembayaran') { echo 'class="active"'; } ?>>
            <a href="<?= $base_url . "page/pembayaran/" ?>"><span class="fa fa-money"></span> <span class="xn-text">Tambah Pembayaran</span></a>
        </li>
        <?php
            }
            if(($ha['hapus_pembayaran']=='1')) {
        ?>

        <li <?php if($menu=='Hapus Pembayaran') { echo 'class="active"'; } ?>>
            <a href="<?= $base_url . "page/pembayaran-hapus/" ?>"><span class="fa fa-trash-o"></span> <span class="xn-text">Hapus Pembayaran</span></a>
        </li>
        <?php
            }
            if(($ha['pembayaran']=='1')) {
        ?>                    
        <li <?php if($menu=='Transaksi Tunggakan') { echo 'class="active"'; } ?>>
            <a href="<?= $base_url . "page/transaksi-tunggakan/" ?>"><span class="fa fa-shopping-cart"></span> <span class="xn-text">Transaksi Tunggakan</span></a>
        </li>
       	<?php
       		}
        	if(($ha['jurusan']=='1') OR ($ha['rumah']=='1') OR ($ha['warga']=='1') ) {
        ?>
        <li class="xn-title">Kelola Data</li>
        <li class="xn-openable <?php if($submenu=='Data Master') { echo 'active'; } ?>">
            <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Data Master</span></a>
            <ul>
            	<?php
		            if(($ha['siswa']=='1')) {
		        ?>
                <li <?php if($menu=='Warga') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/warga/" ?>"><span class="fa fa-male"></span> Warga</a></li>
                <?php
                	}
                	if(($ha['jurusan']=='1')) {
                ?>
                <li <?php if($menu=='Jurusan') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/jurusan/" ?>"><span class="fa fa-desktop"></span> Jurusan</a></li>
                <?php
                	}
                	if(($ha['kelas']=='1')) {
                ?>
                <li <?php if($menu=='Rumah') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/rumah/" ?>"><span class="fa fa-home"></span> rumah</a></li>
                <?php
                	}
                ?>
                                         
            </ul>
        </li>
        <?php
        	}
        	if(($ha['laporan_jenis_pembayaran']=='1') OR ($ha['laporan_pembayaran']=='1') OR ($ha['laporan_warga']=='1') OR ($ha['laporan_jurusan']=='1')OR ($ha['laporan_rumah']=='1') OR ($ha['laporan_pengguna']=='1') ) {
        ?>
        <li class="xn-openable <?php if($submenu=='Laporan') { echo 'active'; } ?>">
            <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Laporan</span></a>
            <ul>
            	<?php
                	if(($ha['laporan_jenis_pembayaran']=='1')) {
                ?>
                <li <?php if($menu=='Laporan Jenis Pembayaran') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/laporan-jenis-pembayaran/" ?>"><span class="fa fa-files-o"></span> Jenis Pembayaran</a></li>
                <?php
                	}
                	if(($ha['laporan_pembayaran']=='1')) {
                        if(($level_pegawai=='Admin') OR ($level_pegawai=='Pegawai')) {
                ?>
                        <li <?php if($menu=='Laporan Pembayaran') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/laporan-pembayaran/" ?>"><span class="fa fa-files-o"></span> Pembayaran</a></li>

                <?php
                        } else {
                ?>
                         <li <?php if($menu=='Laporan Pembayaran') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/laporan-pembayaran-walirumah/" ?>"><span class="fa fa-files-o"></span> Pembayaran</a></li>
                <?php
                        }
                	}
                	if(($ha['laporan_siswa']=='1')) {
                ?>
                <li <?php if($menu=='Laporan warga') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/laporan-siswa/" ?>"><span class="fa fa-files-o"></span> warga</a></li>
                <?php
                	}
                	if(($ha['laporan_jurusan']=='1')) {
                ?>
                <li <?php if($menu=='Laporan Jurusan') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/laporan-jurusan/" ?>"><span class="fa fa-files-o"></span> Jurusan</a></li>
                <?php
                	}
                	if(($ha['laporan_kelas']=='1')) {
                ?>
                <li <?php if($menu=='Laporan rumah') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/laporan-kelas/" ?>"><span class="fa fa-files-o"></span> rumah</a></li>
                <?php
                	}
                	if(($ha['laporan_pengguna']=='1')) {
                ?>
                <li <?php if($menu=='Laporan Pengguna') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/laporan-pengguna/" ?>"><span class="fa fa-files-o"></span> Pengguna</a></li>
                <?php
                	}
                ?>
                                         
            </ul>
        </li>
        <?php
        	}
        	if(($ha['pengguna']=='1') OR ($ha['hak_akses']=='1') OR ($ha['backup']=='1')) {
        ?>
        <li class="xn-title">Pengaturan</li>
        <li class="xn-openable <?php if($submenu=='Pengaturan') { echo 'active'; } ?>">
            <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">Pengaturan</span></a>
            <ul>
            	<?php
		        	if(($ha['pengguna']=='1') OR ($ha['hak_akses']=='1') OR ($ha['backup']=='1')) {
		        ?>
                <li <?php if($menu=='Pengguna') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/pengguna/" ?>"><span class="fa fa-users"></span> Pengguna</a></li>
                <?php
		        	}
		        ?>
                <li <?php if($menu=='Akun') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/akun/" ?>"><span class="fa fa-user"></span> Akun</a></li>
                <?php
		        	if(($ha['hak_akses']=='1') OR ($ha['backup']=='1')) {
		        ?>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-globe"></span> Aplikasi</a>
                    <ul>     
                    	<?php
				        	if(($ha['hak_akses']=='1')) {
				        ?>                               
                        <li <?php if($menu=='Hak Akses') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/hak-akses/" ?>">Hak Akses</a></li>
                        <?php
                        	}
				        	if(($ha['backup']=='1')) {
				        ?>  
                        <li <?php if($menu=='Backup') { echo 'class="active"'; } ?>><a href="<?= $base_url . "page/backup/" ?>">Backup</a></li>
                        <?php
                        	}
				        ?> 
                    </ul>
                </li>
                <?php
                	}
                ?>                            
            </ul>
        </li>
        <?php
        	}
        ?>
    </ul>
    <!-- END X-NAVIGATION -->
</div>
<!-- END PAGE SIDEBAR -->

<?php
	endforeach;
?>