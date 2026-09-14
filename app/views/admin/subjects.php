<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Data Mata Pelajaran</h1>
            <p>Kelola data mata pelajaran yang tersedia untuk ujian dan soal.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/create_subject') ?>')">
                <i class="fas fa-plus"></i>
                <span>Tambah Mata Pelajaran</span>
            </button>
        </div>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Kode</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Mata Pelajaran</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($subjects)): ?>
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada data mata pelajaran terdaftar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($subjects as $subject): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease;">
                            <td style="padding: 16px 12px;"><?= htmlspecialchars($subject->code ?? '-') ?></td>
                            <td style="padding: 16px 12px; font-weight: 500; color: #fff;"><?= htmlspecialchars($subject->name) ?></td>
                            <td style="padding: 16px 12px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <button class="btn-icon" onclick="window.router.navigate('<?= url('admin/editSubject/' . $subject->id) ?>')" title="Edit" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon" onclick="deleteSubject(<?= $subject->id ?>)" title="Hapus" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function deleteSubject(id) {
    Swal.fire({
        title: 'Hapus Mata Pelajaran?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#374151',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('<?= url('admin/deleteSubject/') ?>' + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    Swal.fire('Terhapus!', data.message, 'success')
                    .then(() => {
                        window.router.navigate('<?= url('admin/subjects') ?>');
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            });
        }
    });
}
</script>
