<?php 
include("koneksi.php");
$idbarang = $_POST['id_barang'];
$var_dump($idbarang);
$tampil=mysqli_query($koneksi,"SELECT * FROM detail_barang WHERE id_barang='$idbarang'");
$jml=mysqli_num_rows($tampil);
 
if($jml > 0){    
    while($r=mysqli_fetch_array($tampil)){
        ?>
        <option value="<?php echo $r['serial_code'] ?>"><?php echo $r['serial_code'] ?></option>
        <?php        
    }
}else{
    echo "<option selected>- Item Detail Tidak Ditemukan, Pilih Yang Lain -</option>";
}
 
?>