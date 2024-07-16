<?php 
include("koneksi_ajax.php");
$barang = $_POST['id_barang'];
$tampil=mysqli_query($koneksi,"SELECT * FROM detail_barang WHERE id_barang='$barang'");
$id_barang=mysqli_num_rows($tampil);
 
if($id_barang > 0){    
    while($r=mysqli_fetch_array($tampil)){
        ?>
        <option value="<?php echo $r['id_detail_barang'] ?>"><?php echo $r['serial_code'] ?></option>
        <?php        
    }
}else{
    echo "<option selected>- Data Wilayah Tidak Ada, Pilih Yang Lain -</option>";
}
 
?>