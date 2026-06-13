<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manajemen Pengguna</h2>
    <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah Siswa</button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <ul class="nav nav-tabs mb-4" id="userTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab">Siswa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="admins-tab" data-bs-toggle="tab" data-bs-target="#admins" type="button" role="tab">Admin</button>
            </li>
        </ul>
        <div class="tab-content" id="userTabsContent">
            <div class="tab-pane fade show active" id="students" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle datatable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Lengkap</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($students as $student): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= e($student->nis) ?></td>
                                <td>
                                    <div class="fw-bold"><?= e($student->name) ?></div>
                                    <div class="small text-muted"><?= e($student->email) ?></div>
                                </td>
                                <td><?= e($student->class_name) ?> - <?= e($student->major_name) ?></td>
                                <td>
                                    <?php if($student->status == 'active'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" title="Edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-warning" title="Reset Password"><i class="fas fa-key"></i></button>
                                    <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="admins" role="tabpanel">
                <p class="text-muted">Data admin akan tampil di sini.</p>
            </div>
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
