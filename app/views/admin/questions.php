<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Bank Soal</h2>
    <div>
        <button class="btn btn-outline-success me-2"><i class="fas fa-file-excel me-2"></i>Import Soal</button>
        <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Soal</button>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle datatable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Teks Soal</th>
                        <th>Tipe</th>
                        <th>Tingkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($questions as $q): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($q->subject_name) ?> <br><small class="text-muted"><?= e($q->class_name) ?></small></td>
                        <td><?= substr(strip_tags($q->question_text), 0, 50) ?>...</td>
                        <td>
                            <span class="badge bg-secondary"><?= $q->question_type == 'multiple_choice' ? 'Pilihan Ganda' : 'Essay' ?></span>
                        </td>
                        <td>
                            <?php 
                                $badgeClass = 'bg-success';
                                if($q->difficulty == 'medium') $badgeClass = 'bg-warning text-dark';
                                if($q->difficulty == 'hard') $badgeClass = 'bg-danger';
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($q->difficulty) ?></span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info text-white" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('.datatable')) {
            $('.datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                }
            });
        }
    });
</script>
