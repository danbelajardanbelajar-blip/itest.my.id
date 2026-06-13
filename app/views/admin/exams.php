<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manajemen Ujian</h2>
    <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>Buat Ujian Baru</button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle datatable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Waktu</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($exams as $e): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><div class="fw-bold"><?= e($e->title) ?></div></td>
                        <td><?= e($e->subject_name) ?> <br><small class="text-muted"><?= e($e->class_name) ?></small></td>
                        <td>
                            <div class="small">
                                <i class="fas fa-calendar text-muted me-1"></i> <?= date('d M Y H:i', strtotime($e->start_time)) ?> <br>
                                <i class="fas fa-flag-checkered text-muted me-1"></i> <?= date('d M Y H:i', strtotime($e->end_time)) ?>
                            </div>
                        </td>
                        <td><?= $e->duration_minutes ?> Menit</td>
                        <td>
                            <?php if($e->status == 'published'): ?>
                                <span class="badge bg-success">Published</span>
                            <?php elseif($e->status == 'finished'): ?>
                                <span class="badge bg-secondary">Selesai</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info text-white" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-secondary" title="Peserta"><i class="fas fa-users"></i></button>
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
