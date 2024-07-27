    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
      <?php if ($this->session->flashdata('notif')) { ?>
            var isi = <?= json_encode($this->session->flashdata('notif'))?>;
            Swal.fire({
                title: 'Sukses!',
                text: isi,
                icon: 'success',
                confirmButtonColor: "#223c77",
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            })
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
            var isi = <?= json_encode($this->session->flashdata('error'))?>;
            Swal.fire({
                title: 'Notification!',
                text: isi,
                icon: 'warning',
                confirmButtonColor: "#223c77",
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            })
        <?php } ?>
    </script>
  </body>
</html>