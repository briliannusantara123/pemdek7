<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif}
.w3-bar-block .w3-bar-item {padding:20px}
</style>
</head>
<body>


  
<!-- !PAGE CONTENT! -->

<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Tambah Rekomendasi Baju
</button>
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#cari">
  Cari Baju
</button>

  <!-- First Photo Grid-->
  
  	<div class="w3-row-padding w3-padding-16 w3-center" id="food">
  		<?php foreach ($clothes as $c): ?>
  		 <?php $favorit = $this->Clothes_model->getFavorit($c->id) ?>
	    <div class="w3-quarter">
		    <?php if ($cuaca_id): ?>
		    	<?php if ($c->gambar): ?>
			    	<a href="<?= base_url() ?>index.php/Clothes/pilihbaju/<?= $cuaca_id ?>/<?= $acara_id ?>/<?= $c->id ?>"><img src="<?= base_url('gambar/'.$c->gambar) ?>" alt="Sandwich" style="width:100%;border-radius: 20px;"></a>
			    <?php else: ?>
			    	<a href="<?= base_url() ?>index.php/Clothes/pilihbaju/<?= $cuaca_id ?>/<?= $acara_id ?>/<?= $c->id ?>"><img src="<?= base_url('gambar/ni.png') ?>" alt="Sandwich" style="width:100%;border-radius: 20px;"></a>
			    <?php endif ?>
		    <?php else: ?>
			    	<?php if ($c->gambar): ?>
				    	<a href="<?= base_url() ?>index.php/Clothes/pilihbaju/<?= $c->cid ?>/<?= $c->aid ?>/<?= $c->id ?>"><img src="<?= base_url('gambar/'.$c->gambar) ?>" alt="Sandwich" style="width:100%;border-radius: 20px;"></a>
				    <?php else: ?>
				    	<a href="<?= base_url() ?>index.php/Clothes/pilihbaju/<?= $c->cid ?>/<?= $c->aid ?>/<?= $c->id ?>"><img src="<?= base_url('gambar/ni.png') ?>" alt="Sandwich" style="width:100%;border-radius: 20px;"></a>
				    <?php endif ?>
		    <?php endif ?>
	    
	      <?php if ($favorit > 5): ?>
	      	<h4><?= $c->recommendation ?> (Favorit)</h4>
	      <?php else: ?>
	      	<h4><?= $c->recommendation ?></h4>
	      <?php endif ?>
	      
	      <p>Stelan baju ini cocok di gunakan saat cuaca <?= $c->cuaca_name ?> dan untuk acara <?= $c->acara_name ?></p>
	    </div>
	    <?php endforeach ?>
	 </div>
  
  

  <!-- Pagination -->
  <!-- <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a href="#" class="w3-bar-item w3-button w3-hover-black">«</a>
      <a href="#" class="w3-bar-item w3-black w3-button">1</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">2</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">3</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">4</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">»</a>
    </div>
  </div> -->
  
  
  <!-- Footer -->
  

<!-- End page content -->
</div>
<!-- Modal -->
<!-- Modal for Adding Recommendations -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Rekomendasi Baju</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url() ?>index.php/Clothes/simpangambar" method="POST" id="dataForm" enctype="multipart/form-data">
                    <label for="cuaca_id">Cuaca</label>
                    <select id="cuaca_id" name="cuaca_id" class="form-control" required>
                        <?php foreach ($cuaca as $c): ?>
                            <option value="<?= $c->id ?>"><?= $c->cuaca_name ?></option>
                        <?php endforeach ?>
                    </select><br>

                    <label for="acara_id">Acara:</label>
                    <select id="acara_id" name="acara_id" class="form-control" required>
                        <?php foreach ($acara as $c): ?>
                            <option value="<?= $c->id ?>"><?= $c->acara_name ?></option>
                        <?php endforeach ?>
                    </select><br>

                    <label for="recommendation">Nama Rekomendasi:</label>
                    <input type="text" id="recommendation" name="recommendation" class="form-control" required><br>

                    <label for="gambar">Gambar:</label>
                    <input type="file" id="gambar" name="gambar" class="form-control" required><br>

                    <!-- Modal footer with submit button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Searching Items -->
<div class="modal fade" id="cari" tabindex="-1" aria-labelledby="cariLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cariLabel">Cari Rekomendasi Baju</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url() ?>index.php/Clothes" method="POST" id="searchForm" enctype="multipart/form-data">
                    <label for="search_cuaca_id">Cuaca</label>
                    <select id="search_cuaca_id" name="cuaca_id" class="form-control">
                    	<option value="">Pilih Cuaca</option>
                        <?php foreach ($cuaca as $c): ?>
                            <option value="<?= $c->id ?>"><?= $c->cuaca_name ?></option>
                        <?php endforeach ?>
                    </select><br>

                    <label for="search_acara_id">Acara:</label>
                    <select id="search_acara_id" name="acara_id" class="form-control">
                    	<option value="">Pilih Acara</option>
                        <?php foreach ($acara as $c): ?>
                            <option value="<?= $c->id ?>"><?= $c->acara_name ?></option>
                        <?php endforeach ?>
                    </select><br>
                    <!-- Modal footer with submit button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitBtn').on('click', function(event) {
            event.preventDefault(); // Mencegah form dari submit default

            // Mengambil data dari form
            var formData = $('#dataForm').serialize();
            console.log(formData);

            $.ajax({
                url: 'http://localhost:8080/create_data', // URL endpoint API Prolog
                type: 'POST',
                data: formData, // Mengirimkan data form sebagai string query
                dataType: 'json', // Pastikan respons dari server adalah JSON
                success: function(response) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Berhasil Menambahkan Data Baju',
                        icon: 'success',
                        confirmButtonColor: "#223c77",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        // Tutup modal setelah notifikasi ditampilkan
                        $('#exampleModal').modal('hide');
                        location.reload();
                    });
                    $.ajax({
		                url: '<?= base_url() ?>index.php/Clothes/simpangambar', // URL endpoint API Prolog
		                type: 'POST',
		                data: formData, // Mengirimkan data form sebagai string query
		                dataType: 'json', // Pastikan respons dari server adalah JSON
		                success: function(response) {
		                    Swal.fire({
		                        title: 'Sukses!',
		                        text: 'Berhasil Menambahkan Data Baju',
		                        icon: 'success',
		                        confirmButtonColor: "#223c77",
		                        confirmButtonText: 'OK',
		                        allowOutsideClick: false,
		                        allowEscapeKey: false
		                    }).then(() => {
		                        // Tutup modal setelah notifikasi ditampilkan
		                        $('#exampleModal').modal('hide');
		                        location.reload();
		                    });
		                    
		                }
		            });

                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menambahkan data baju.',
                        icon: 'error',
                        confirmButtonColor: "#223c77",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                }
            });
        });
        function getData() {
                $.ajax({
                    url: '<?= base_url() ?>index.php/Clothes/fetch_data', // URL controller CodeIgniter
                    type: 'GET',
                    dataType: 'json', // Pastikan respons dari server adalah JSON
                    success: function(data) {
                    console.log(data); // Menampilkan data di console

                    // Mengolah data, misalnya menampilkannya di tabel
                    var tableContent = '';
                    $.each(data, function(index, item) {
                        tableContent += '<tr>';
                        tableContent += '<td>' + item.cuaca_id + '</td>';
                        tableContent += '<td>' + item.acara_id + '</td>';
                        tableContent += '<td>' + item.recommendation + '</td>';
                        tableContent += '</tr>';
                    });

                    $('#dataTable tbody').html(tableContent); // Menambahkan data ke tabel
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error); // Menampilkan pesan error di console
                }
                });
            }

            // Panggil fungsi untuk mengambil data saat dokumen siap
            getData();
    });
</script>

</body>
</html>