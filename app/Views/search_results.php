<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container-fluid mt-4">

    <h1 class="h3 mb-4 text-gray-800">Hasil Pencarian</h1>
    <h2 class="h5 mb-4 text-gray-600">Menampilkan hasil untuk: <strong><?= esc($query); ?></strong></h2>

    <!-- Tabel Produk -->
    <?php if (empty($products)): ?>
        <div class="alert alert-warning" role="alert">
            <strong>Tidak ada produk ditemukan.</strong>
        </div>
    <?php else: ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Thumbnail</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['product'] ?></td>
                            <td>
                                <?php if ($product['thumbnail']): ?>
                                    <img src="<?= base_url('uploads/' . $product['thumbnail']); ?>" alt="Thumbnail" width="100">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>                          
                            <td><?= $product['price'] ?></td>
                            <td><?= $product['name_categories'] ?? 'No Category' ?></td>
                            <td>
                                <!-- Button Edit -->
                                <button class="btn btn-warning btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#editProductModal<?= $product['id'] ?>">
                                    <i class="fas fa-edit"> Edit</i>
                                </button>

                                <!-- Form Hapus -->
                                <form action="/products/delete/<?= $product['id'] ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"> Hapus</i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Produk -->
                        <div class="modal fade" id="editProductModal<?= $product['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel<?= $product['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/products/update/<?= $product['id'] ?>" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editProductModalLabel<?= $product['id'] ?>">Edit Produk</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="product" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" name="product" 
                                                       value="<?= $product['product'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="thumbnail" class="form-label">Ganti Thumbnail (Opsional)</label>
                                                <input type="file" class="form-control" name="thumbnail" accept="image/*">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengubah thumbnail.</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Harga</label>
                                                <input type="number" class="form-control" name="price" 
                                                       value="<?= $product['price'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Kategori</label>
                                                <select name="category_id" class="form-control" required>
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?= $category['id'] ?>" 
                                                            <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                                            <?= $category['name_categories'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (session()->getFlashdata('message')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '<?= session()->getFlashdata('message') ?>',
            timer: 3000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>
