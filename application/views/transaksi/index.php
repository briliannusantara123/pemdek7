<div class="container" style="margin-top: 30px;">
    <h1 style="text-align: center;">TRANSAKSI</h1>
    <hr>
	<form action="<?= base_url() ?>index.php/Transaksi" method="POST">
		<div class="mb-3">
		  <label for="exampleFormControlInput1" class="form-label">Menu</label>
		  <select name="id_menu" class="form-control" id="options">
		  	<option selected="" disabled="">Pilih Menu</option>
		  	<?php foreach ($menu as $m): ?>
		  		<option value="<?= $m->id ?>"><?= $m->nama_menu ?></option>
		  	<?php endforeach ?>
		  </select>
		</div>
		<div class="mb-3">
		  <label for="exampleFormControlInput1" class="form-label">Qty</label>
		  <input type="number" name="qty" class="form-control" id="qty">
		</div>
		<div class="mb-3">
		  <label for="exampleFormControlInput1" class="form-label">Total Bayar</label>
		  <input type="number" class="form-control" id="total_bayar" readonly="">
		</div>
		<input type="hidden" id="harga" readonly>
		<div class="mb-3">
		  <label for="exampleFormControlInput1" class="form-label">Bayar</label>
		  <input type="number" name="bayar" class="form-control" id="bayar">
		</div>
		<div class="mb-3">
		  <label for="exampleFormControlInput1" class="form-label">Kembalian</label>
		  <input type="number" class="form-control" id="kembalian" readonly="">
		</div>
		<div class="mb-3">
		  <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Transaksi</button>
		</div>
	</form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = document.getElementById('options');
            const harga = document.getElementById('harga');
            const bayar = document.getElementById('bayar');
            const kembalian = document.getElementById('kembalian');
            const qty = document.getElementById('qty');
            const total_bayar = document.getElementById('total_bayar');


            selectElement.addEventListener('change', function () {

                $.ajax({
                    url: '<?=base_url()?>index.php/Transaksi/getMenu/' + selectElement.value,
                    type: 'GET',
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data) {
                            harga.value = data.harga;
                        } else {
                            harga.value = 1;
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
                qty.addEventListener('input', function () {
                	var jumlah = harga.value * qty.value;
                	total_bayar.value = jumlah;
                });
                bayar.addEventListener('input', function () {
                	var jumlah = harga.value * qty.value;
                	var hasil = bayar.value - jumlah;
                	kembalian.value = hasil;
                });
            });
        });
    </script>