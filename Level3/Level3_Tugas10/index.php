<?php
	//----------Koneksi untuk Database----------
	$server = "localhost";
	$user = "root";
	$password = "";
	$database = "pijarcamp";

	$koneksi = mysqli_connect($server, $user, $password, $database) or die(mysql_error($koneksi));

	//----------Ketika tombol simpan di klik----------
	if (isset($_POST['simpan'])) { 

		// Pengujian apakah data akan di edit atau disimpan baru
		if ($_GET['hal'] == "edit") {
				// Data akan di edit
				$edit = mysqli_query($koneksi, "UPDATE produk set namaproduk = '$_POST[namaproduk]',
					keterangan = '$_POST[keterangan]',
					harga = '$_POST[harga]',
					jumlah = '$_POST[jumlah]'
					WHERE id = '$_GET[id]'
							");


				// Jika edit berhasil
				if ($edit) {
					echo "	<script>
								alert('Edit Data Berhasil');
								document.location='index.php';
							</script>";
				}else {
					echo "	<script>
								alert('Edit Data Gagal');
								document.location='index.php';
							</script>";
				}
			}else {
				// Data akan disimpan baru
				$simpan = mysqli_query($koneksi, "INSERT INTO produk (namaproduk, keterangan, harga, jumlah) 
					values 	('$_POST[namaproduk]',
							'$_POST[keterangan]',
							'$_POST[harga]',
							'$_POST[jumlah]')
							");


				// Jika simpan berhasil
				if ($simpan) {
					echo "	<script>
								alert('Simpan Data Berhasil');
								document.location='index.php';
							</script>";
				}else {
					echo "	<script>
								alert('Simpan Data Gagal');
								document.location='index.php';
							</script>";
				}
			}			
	}

	//----------Ketika tombol edit / hapus di klik----------
	if (isset($_GET['hal'])) {

		// Jika tombol edit diklik
		if ($_GET['hal'] == "edit") {
			// Tampilkan data yg di edit
			$tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$_GET[id]'");
			$data = mysqli_fetch_array($tampil);
			if ($data) {
				// Jika data ditemukan, maka data akan ditampung dulu ke dalam variabel
				$vnamaproduk = $data['namaproduk'];
				$vketerangan = $data['keterangan'];
				$vharga = $data['harga'];
				$vjumlah = $data['jumlah'];
			}
		}else if($_GET['hal'] == "hapus") {
			// Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$_GET[id]'");
			if ($hapus) {
				echo "	<script>
							alert('Hapus Data Sukses');
							document.location='index.php';
						</script>";
			}
		}
	}




?>				


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=`, initial-scale=1.0">
	<title>Level 3 | Tugas 10</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<h1 class="text-center">Level 3 | Tugas 10</h1>
<h2 class="text-center">C R U D</h2>
<p class="text-center">Yafao Zisokhi Daeli</p>
<div class="container">
	
	<!-- Awal card form -->
	<div class="card mt-5">
	  <div class="card-header bg-dark text-light">
	    Form Input
	  </div>
	  <div class="card-body">
	    <form action="" method="post">
	    	<div class="form-group">
	    		<label>Nama Produk</label>
	    		<input type="text" name="namaproduk" value="<?=@$vnamaproduk?> " class="form-control" placeholder="Masukan nama produk" required>
	    	</div><br>
	    	<div class="form-group">
	    		<label>Keterangan</label>
	    		<input type="text" name="keterangan" value="<?=@$vketerangan?>" class="form-control" placeholder="Keterangan" required>
	    	</div><br>
	    	<div class="form-group">
	    		<label>Harga</label>
	    		<input type="text" name="harga" value="<?=@$vharga?>" class="form-control" placeholder="Masukan harga" required>
	    	</div><br>
	    	<div class="form-group">
	    		<label>Jumlah</label>
	    		<input type="text" name="jumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Masukan jumlah" required>
	    	</div><br>
	    	<button type="submit" class="btn btn-success" name="simpan">Simpan</button>
	    	<button type="clear" class="btn btn-danger" name="simpan">Reset</button>
	    </form>
	  </div>
	</div>
	<!-- Awal card form -->

	<!-- Awal card tabel -->
	<div class="card mt-5">
	  <div class="card-header bg-dark text-light">
	    Daftar Produk
	  </div>
	  <div class="card-body">
	    
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th class="text-center">No</th>
	  			<th class="text-center">Nama Produk</th>
	  			<th class="text-center">Keterangan</th>
	  			<th class="text-center">Harga</th>
	  			<th class="text-center">Jumlah</th>
	  			<th class="text-center">Aksi</th>
	  		</tr>
	  		<?php 
	  		$no = 1;
	  		$tampil = mysqli_query($koneksi, "SELECT * FROM produk order by id desc");
	  		while ($data = mysqli_fetch_array($tampil)) :

	  		 ?>
	  		<tr>
	  			<td class="text-center"><?=$no++;?></td>
	  			<td class="text-center"><?=$data['namaproduk'];?></td>
	  			<td class="text-center"><?=$data['keterangan'];?></td>
	  			<td class="text-center"><?=$data['harga'];?></td>
	  			<td class="text-center"><?=$data['jumlah'];?></td>
	  			<td class="text-center">
	  				<a href="index.php?hal=edit&id=<?=$data['id'];?>" class="btn btn-warning">Edit</a>
	  				<a href="index.php?hal=hapus&id=<?=$data['id']?>" onclick="return confirm('Apakah yakin akan menghapus data?')"class="btn btn-danger">Hapus</a>	
	  			</td>
	  		</tr>
	  	<?php endwhile; //penutup perulangan while?>
	  	</table>

	  </div>
	</div>
	<!-- Awal card tabel -->

</div>




<script src="css/bootstrap.min.css"></script>	
</body>
</html>