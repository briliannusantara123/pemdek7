
  <div class="container" style="margin-top: 30px;">
    <h1 style="text-align: center;">HISTORY TRANSAKSI</h1>
    <hr>
    <form action="<?= base_url() ?>index.php/HTransaksi" method="POST" style="margin-top: 20px;margin-bottom: 30px;">
    <div class="row">
      <div class="col-5">
        <label>Dari</label>
        <input type="date" name="dari" class="form-control" value="<?= $dari ?>">
      </div>
      <div class="col-5">
        <label>Sampai</label>
        <input type="date" name="sampai" class="form-control" value="<?= $sampai ?>">
      </div>
      <div class="col-2">
        <button type="submit" class="btn btn-primary" style="margin-top: 23px;">Filter</button>
      </div>
    </div>
    
  </form>
    <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama Menu</th>
        <th scope="col">Harga</th>
        <th scope="col">Qty</th>
        <th scope="col">Total Bayar</th>
        <th scope="col">Bayar</th>
        <th scope="col">Tgl Transaksi</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php 
        $no = 1;
        foreach ($transaksi as $p): ?>
        <tr>
          <th scope="row"><?= $no++ ?></th>
          <td><?= $p->nama_menu ?></td>
          <td><?= $p->harga ?></td>
          <td><?= $p->qty ?></td>
          <td><?= $p->harga * $p->qty ?></td>
          <td><?= $p->bayar ?></td>
          <td><?= $p->tgl_transaksi ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
  </table>
  </div>