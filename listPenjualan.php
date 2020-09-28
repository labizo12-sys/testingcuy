<?php 
    session_start();
    include "koneksi.php";
	$username=$_SESSION['login'];
	$tampilkan="select * from users where username='$username';";
	$query_tampilkan=mysql_query($tampilkan);	
	date_default_timezone_set('Asia/Jakarta');
    $waktu2 = date("d-M-Y");
	if($hasil=mysql_fetch_array($query_tampilkan)){
		if($username=="manager"){
		    $fullname=$hasil['username'];
		}
		else{
		    Header("location:http://sps-food.com/?pesan=login");
		}
	}
	else{
		Header("location:http://sps-food.com/?pesan=login");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Sps Food</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color:MintCream;">
<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="logokecil.png" height="35" width="200"></a>
    </div>
    <ul class="nav navbar-nav">
        <li ><a href="inputBarang.php">Input Jenis Barang</a></li>
        <li ><a href="inputStock.php">Input Stock</a></li>    
	    <li ><a href="listStock.php">List Stock</a></li>
        <li ><a href="inputPenjualan.php">Input Penjualan</a></li>	
        <li class="active" ><a href="listPenjualan.php">List Penjualan</a></li>
	    <li ><a href="laporan.php">Laporan Laba Rugi</a></li>
	    <li ><a href="summary.php">Summary Penjualan</a></li>
	    <li ><a href="listRecord.php">List Record</a></li>  
	    <li ><a href="creatUser.php">Create User</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span><?php echo ' '."$fullname";?>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="editprofil.php" <span class="glyphicon glyphicon-edit"></span> ManageAccount</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> &nbsp&nbsp&nbspSign Out</a></li>
          
        </ul>
      </li>
	  
    </ul>
  </div>
</nav>
<div id="content">
        	<h2 align="center">List Penjualan</h2>
            <!-- <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>     <p>Silahkan download file yang sudah di Upload di website ini. Untuk men-Download Anda bisa mengklik Judul file yang di inginkan.</p>
			-->
			<br>
			<form method="POST"  >
			<label for="pwd">Filter By :</label>
			<Select Name="id" id="id" onchange="showUser(this.value)">
				<option selected="selected">Pilih Filter</option>
				<option value="barang">Nama Barang</option>
				<option value="supplier">Nama Pembeli</option>
				<option value="jumlah">Kuantiti</option>
				<option value="tanggal">Expired Date</option>
			</Select>
			<button type="submit" name="sign">Sort</button></br>
			</form>
			</div>
			<div id="content2">
			<?php 
			if(isset($_GET["pesan"])){
			$pesan= $_GET["pesan"];
			//echo $pesan;
				if($pesan=="berhasil"){
					//echo "Upload Success";
					echo '
								<div class="alert alert-success">
								<strong>Success!</strong>';
						echo " Upload Success";
						echo '</div>'	;
				}
				else if($pesan=="gagal"){
					//echo "Upload Failed";
					echo '
					<div class="alert alert-danger">
					<strong>Failed!</strong>';
							echo " Upload Failed";
							echo '</div>'	;
				}
				else if($pesan=="berhasil2"){
					//echo "Upload Success";
					echo '
								<div class="alert alert-success">
								<strong>Success!</strong>';
						echo " Download Success";
						echo '</div>'	;
				}	
				
				
			}
			
		
			?>
			
			
            <p>
			
            <table border="1" class="table table-hover">
			
            	<tr bgcolor="#ccffff">
					<th width="30">No. Surat Penjualan</th>
                	<th width="70">No. Surat Stock</th>
                    <th width="70">Nama Pembeli</th>
                    <th width="70">Alamat Pembeli</th>
                    <th width="70">Kode Barang</th>
                    <th width="70">Jenis Barang</th>
                    <th width="70">Gramasi</th>
                    <!--<th width="70">Stock</th>-->
					<th width="100">Harga Modal</th>
					<th width="70">TGL EXP</th>
					<th width="70">Margin Keuntungan</th>
					<th width="70">Harga Jual</th>
					<th width="70">Biaya Transport</th>
					<th width="70">Biaya JNE</th>
					<th width="70">Biaya Komisi</th>
					<th width="70">Kuantiti Penjualan</th>
					<th width="70">Harga Total Penjualan</th>
					<th width="70">Jatuh Tempo</th>
					<th width="70">Last Edited By</th>
					<th width="70">Aksi</th>	

                </tr>
                <?php
				$tampilkan="select *,a.margin_keuntungan as margin_keuntungan, DATE_FORMAT(c.tanggal_exp,'%d-%b-%Y') as tanggal_exp, DATE_FORMAT(a.jatuh_tempo,'%d-%b-%Y') as jatuh_tempo from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock ORDER BY tanggal_jual DESC;";
				if (isset($_POST['sign'])) {
					if($_POST['id']=="barang"){
						$tampilkan="select *,a.margin_keuntungan as margin_keuntungan, DATE_FORMAT(c.tanggal_exp,'%d-%b-%Y') as tanggal_exp, DATE_FORMAT(a.jatuh_tempo,'%d-%b-%Y') as jatuh_tempo from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock ORDER BY b.jenis_barang ASC;";
					}
					else if($_POST['id']=="supplier"){
						$tampilkan="select *,a.margin_keuntungan as margin_keuntungan, DATE_FORMAT(c.tanggal_exp,'%d-%b-%Y') as tanggal_exp, DATE_FORMAT(a.jatuh_tempo,'%d-%b-%Y') as jatuh_tempo from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock ORDER BY nama_pembeli ASC;";
					}
					else if($_POST['id']=="jumlah"){
						$tampilkan="select *,a.margin_keuntungan as margin_keuntungan, DATE_FORMAT(c.tanggal_exp,'%d-%b-%Y') as tanggal_exp, DATE_FORMAT(a.jatuh_tempo,'%d-%b-%Y') as jatuh_tempo from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock ORDER BY a.kuantiti_barang ASC;";
					}
					else{
						$tampilkan="select *,a.margin_keuntungan as margin_keuntungan, DATE_FORMAT(c.tanggal_exp,'%d-%b-%Y') as tanggal_exp, DATE_FORMAT(a.jatuh_tempo,'%d-%b-%Y') as jatuh_tempo from transaksi d join penjualan a on d.id_penjualan = a.id_penjualan join barang b on a.kode_barang = b.kode_barang join stock c on a.id_stock = c.id_stock ORDER BY jatuh_tempo ASC;";
					}
				}
						$query_tampilkan=mysql_query($tampilkan);
						$temp = -1;
						while($hasil=mysql_fetch_array($query_tampilkan))
							{
								$id_transaksi=$hasil['id_transaksi'];
								$id_penjualan=$hasil['id_penjualan'];								
								$id=$hasil['id'];
								$nama_pembeli=$hasil['nama_pembeli'];
								$alamat_pembeli=$hasil['alamat_pembeli'];
								$kode_barang=$hasil['kode_barang'];
								$jenis_barang=$hasil['jenis_barang'];
								$gramasi_barang=$hasil['satuan'];
								$kuantiti_barang=$hasil['kuantiti_barang'];
								$harga_modal=$hasil['harga_modal'];
								$tanggal_exp=$hasil['tanggal_exp'];
								$margin_keuntungan=$hasil['margin_keuntungan'];
								$biaya_transport = "0";
								if($hasil['biaya_transport'] != "0"){
									$biaya_transport = $hasil['biaya_transport']/$hasil['jumlah_pembelian'];
								}
								$biaya_jne = "0";
								if($hasil['biaya_jne'] != "0"){
									$biaya_jne = $hasil['biaya_jne']/$hasil['jumlah_pembelian'];
								}
								$biaya_komisi = "0";
								if($hasil['biaya_komisi'] != "0"){
									$biaya_komisi = $hasil['biaya_komisi']/$hasil['jumlah_pembelian'];
								}
								$harga_jual=$hasil['harga_jual'] - ($biaya_transport+$biaya_jne+$biaya_komisi);
								$jumlah_pembelian=$hasil['jumlah_pembelian'];
								$harga_total_pembelian=$hasil['harga_total_pembelian'];
								$jatuh_tempo=$hasil['jatuh_tempo'];
								$last_edited_by=$hasil['last_edited_by'];
								
								$harga_jual=number_format($harga_jual*1, 2, ',', '.');
								$margin_keuntungan=number_format($margin_keuntungan*1, 2, ',', '.');
								$harga_modal=number_format($harga_modal*1, 2, ',', '.');
								$harga_total_pembelian=number_format($harga_total_pembelian*1, 2, ',', '.');
								if($temp != $id_transaksi)
								{
									$temp = $id_transaksi;
								
								    date_default_timezone_set('Asia/Jakarta');
            						$current = strtotime(date("d-M-y"));
                                    $date    = strtotime($jatuh_tempo);
                                
                                    $datediff = $date - $current;
                                    $difference = floor($datediff/(60*60*24));
                                    if($difference == 0)
                                    {
                                        //hari ini
                                        //merah
                                        echo '
                                        <tr style="color: #ff0000">';
                                    }
                                    else if($difference >= 1 && $difference <= 7)
                                    {
                                        //7 hari sebelum
                                        //kuning
                                        echo '
            					    	<tr style="color: #ff9900">';
                                    }
                                    else
                                    {
                                        //kemarin
                                        //merah
                                        echo '
                                        <tr style="color: #000000">';
                                    }  
                					echo '
									<td align="center">SJP-'.$temp.'</td>						
									<td align="center" ><a href= listPenjualanDetail.php?id=', $id ,' target="_blank">'.$id.'</a>
									<button> <a href =deletePenjualan.php?id=', $hasil['id_penjualan'],' >Delete</a></button> <button><a href =editPenjualan.php?id=', $hasil['id_penjualan'],'&idTrans=', $temp ,' >Edit</a></button></td>
									<td style="color: <?php echo $color; ?>;">'.$nama_pembeli.'</td>
									<td style="color: <?php echo $color; ?>;">'.$alamat_pembeli.'</td>
									<td style="color: <?php echo $color; ?>;">'.$kode_barang.'</td>
									<td style="color: <?php echo $color; ?>;">'.$jenis_barang.'</td>
									<td style="color: <?php echo $color; ?>;">'.$gramasi_barang.'</td>
									<!--<td style="color: <?php echo $color; ?>;">'.$kuantiti_barang.'</td>-->
									<td style="color: <?php echo $color; ?>;">'.$harga_modal.'</td>
									<td style="color: <?php echo $color; ?>;">'.$tanggal_exp.'</td>
									<td style="color: <?php echo $color; ?>;">'.$margin_keuntungan.'</td>
									<td style="color: <?php echo $color; ?>;">'.$harga_jual.'</td>
									<td style="color: <?php echo $color; ?>;">'.$biaya_transport.'</td>
									<td style="color: <?php echo $color; ?>;">'.$biaya_jne.'</td>
									<td style="color: <?php echo $color; ?>;">'.$biaya_komisi.'</td>
									<td style="color: <?php echo $color; ?>;">'.$jumlah_pembelian.'</td>
									<td style="color: <?php echo $color; ?>;">'.$harga_total_pembelian.'</td>
									<td style="color: <?php echo $color; ?>;">'.$jatuh_tempo.'</td>
									<td style="color: <?php echo $color; ?>;">'.$last_edited_by.'</td>
									<td> <button><a href= demo.php?id=', $hasil['id_transaksi'] ,'&tgl=', $waktu2 ,' target="_blank">Surat Jalan</a></button>
									<button><a href= invoice.php?id=', $hasil['id_transaksi'] ,'&tgl=', $waktu2 ,'  target="_blank">Invoice</a></button></td>
									</tr>';
								}
								else
								{
									$temp = $id_transaksi;
									date_default_timezone_set('Asia/Jakarta');
            						$current = strtotime(date("d-M-y"));
                                    $date    = strtotime($jatuh_tempo);
                                
                                    $datediff = $date - $current;
                                    $difference = floor($datediff/(60*60*24));
                                    if($difference == 0)
                                    {
                                        //hari ini
                                        //merah
                                        echo '
                                        <tr style="color: #ff0000">';
                                    }
                                    else if($difference >= 1 && $difference <= 7)
                                    {
                                        //7 hari sebelum
                                        //kuning
                                        echo '
            					    	<tr style="color: #ff9900">';
                                    }
                                    else
                                    {
                                        //kemarin
                                        //merah
                                        echo '
                                        <tr style="color: #000000">';
                                    }  
									echo '
									<td align="center">SJP-'.$temp.'</td>						
									<td align="center"><a href= listPenjualanDetail.php?id=', $id ,' target="_blank">'.$id.'</a>
									<button><a href =deletePenjualan.php?id=', $hasil['id_penjualan'],' >Delete</a></button>  <button><a href =editPenjualan.php?id=', $hasil['id_penjualan'],'&idTrans=', $temp ,' >Edit</a></button></td>
									<td style="color: <?php echo $color; ?>;">'.$nama_pembeli.'</td>
									<td style="color: <?php echo $color; ?>;">'.$alamat_pembeli.'</td>
									<td style="color: <?php echo $color; ?>;">'.$kode_barang.'</td>
									<td style="color: <?php echo $color; ?>;">'.$jenis_barang.'</td>
									<td style="color: <?php echo $color; ?>;">'.$gramasi_barang.'</td>
									<!--<td style="color: <?php echo $color; ?>;">'.$kuantiti_barang.'</td>-->
									<td style="color: <?php echo $color; ?>;">'.$harga_modal.'</td>
									<td style="color: <?php echo $color; ?>;">'.$tanggal_exp.'</td>
									<td style="color: <?php echo $color; ?>;">'.$margin_keuntungan.'</td>
									<td style="color: <?php echo $color; ?>;">'.$harga_jual.'</td>
									<td style="color: <?php echo $color; ?>;">'.$biaya_transport.'</td>
									<td style="color: <?php echo $color; ?>;">'.$biaya_jne.'</td>
									<td style="color: <?php echo $color; ?>;">'.$biaya_komisi.'</td>
									<td style="color: <?php echo $color; ?>;">'.$jumlah_pembelian.'</td>
									<td style="color: <?php echo $color; ?>;">'.$harga_total_pembelian.'</td>
									<td style="color: <?php echo $color; ?>;">'.$jatuh_tempo.'</td>
									<td style="color: <?php echo $color; ?>;">'.$last_edited_by.'</td>
									<td>
									</tr>';
								}
							}
				
				?>
				<script>
				window.onscroll = function() {myFunction()};

				var navbar = document.getElementById("navbar");
				var content = document.getElementById("content");
				var sticky = content.offsetTop;

				function myFunction() {
				  if (window.pageYOffset >= sticky) {
					navbar.classList.add("sticky");
				  } else {
					navbar.classList.remove("sticky");
				  }
				}
				</script>
            </table>
		
            </p>
        </div>
  <div class="footer"><p>2019 SPS FOOD</p></div>


</body>
</html>