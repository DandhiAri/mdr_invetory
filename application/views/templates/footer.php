<footer class="page-footer">
    <div class="font-13">2024 © <b>PT Mangli Djaya Raya</b> </div>
    <a class="px-4" href="<?= base_url('assets'); ?>http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank"></a>
    <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
</footer>
</div>
    </div>
	
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
 $('#getIdBarang').on("change",function() { 
 var idbarang = $(this).val(); 
 //alert(idbarang);
 
 $.ajax({
 type: 'POST', 
 url: '<?= site_url();?>Barang/getdetailbarang', 
 data: {'id_barang' : idbarang} , 
	success: function(s) {
			//alert(s);		
			$('#showSerialCode').append(s); 
			$('#serial_code').val(data.serial_code).append('selected','selected');
		}
	});
 });
 
</script>


</body>

</html>

