$(document).ready(function() {
    $('#getIdBarang').change(function() {
        var id_barang = $(this).val();
        $.ajax({
            url: '<?= base_url("Detail_request/get_serial_codes") ?>',
            method: 'POST',
            data: {id_barang: id_barang},
            dataType: 'json',
            success: function(response) {
                var options = '<option value="">Pilih Nomor Seri</option>';
                $.each(response, function(index, value) {
                    options += '<option value="' + value.serial_code + '">' + value.serial_code + '</option>';
                });
                $('#showSerialCode').html(options);
            }
        });
    });
});
