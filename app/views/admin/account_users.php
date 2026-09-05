<div class="dashboard-view fade-in">
    <div class="view-header flex-between" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1>Kelola Pengguna Sistem</h1>
            <p>Kelola semua akun pengguna (Admin, Guru, dan Siswa), hak akses peran, serta status akun.</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button class="btn-primary-admin" onclick="window.router.navigate('<?= url('admin/create_account_user') ?>')">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Pengguna</span>
            </button>
        </div>
    </div>

    <!-- Role Filter Tabs -->
    <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
        <?php $currentRole = $_GET['role'] ?? ''; ?>
        <button onclick="window.router.navigate('<?= url('admin/account_users') ?>')" class="btn-secondary-admin <?= empty($currentRole) ? 'active' : '' ?>" style="<?= empty($currentRole) ? 'background: #3b82f6; border-color: #3b82f6; color: white;' : '' ?>">
            Semua (<?= count($all_users) ?>)
        </button>
        <button onclick="window.router.navigate('<?= url('admin/account_users?role=admin') ?>')" class="btn-secondary-admin <?= $currentRole === 'admin' ? 'active' : '' ?>" style="<?= $currentRole === 'admin' ? 'background: #3b82f6; border-color: #3b82f6; color: white;' : '' ?>">
            <i class="fas fa-user-shield"></i> Admin
        </button>
        <button onclick="window.router.navigate('<?= url('admin/account_users?role=teacher') ?>')" class="btn-secondary-admin <?= $currentRole === 'teacher' ? 'active' : '' ?>" style="<?= $currentRole === 'teacher' ? 'background: #3b82f6; border-color: #3b82f6; color: white;' : '' ?>">
            <i class="fas fa-chalkboard-teacher"></i> Guru
        </button>
        <button onclick="window.router.navigate('<?= url('admin/account_users?role=student') ?>')" class="btn-secondary-admin <?= $currentRole === 'student' ? 'active' : '' ?>" style="<?= $currentRole === 'student' ? 'background: #3b82f6; border-color: #3b82f6; color: white;' : '' ?>">
            <i class="fas fa-user-graduate"></i> Siswa
        </button>
    </div>

    <div class="admin-recent-section glass-panel">
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 1%; text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">#</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Pengguna</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Username / ID</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Email</th>
                        <th style="text-align: left; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Peran (Role)</th>
                        <th style="text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Status</th>
                        <th style="width: 1%; text-align: center; padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($users)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: var(--text-muted);">Tidak ada data pengguna ditemukan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($users as $i => $u): ?>
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-muted);"><?= $i + 1 ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light); font-weight: 500;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(59,130,246,0.2); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">
                                            <?= strtoupper(substr($u->name, 0, 1)) ?>
                                        </div>
                                        <span><?= e($u->name) ?></span>
                                    </div>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-light); font-family: monospace;"><?= e($u->username) ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--text-muted);"><?= e($u->email) ?></td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <?php 
                                        $roleBg = '#3b82f6';
                                        $roleText = 'Admin';
                                        if ($u->role === 'teacher') {
                                            $roleBg = '#8b5cf6';
                                            $roleText = 'Guru';
                                        } elseif ($u->role === 'student') {
                                            $roleBg = '#10b981';
                                            $roleText = 'Siswa';
                                        }
                                    ?>
                                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; background: <?= $roleBg ?>22; color: <?= $roleBg ?>; border: 1px solid <?= $roleBg ?>44;">
                                        <?= $roleText ?>
                                    </span>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                    <button onclick="toggleStatus(<?= $u->id ?>)" title="Klik untuk ubah status" style="background: none; border: none; cursor: pointer; padding: 0;">
                                        <span class="badge" style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; background: <?= $u->status === 'active' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)' ?>; color: <?= $u->status === 'active' ? '#34d399' : '#f87171' ?>;">
                                            <?= $u->status === 'active' ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    </button>
                                </td>
                                <td style="padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <button class="action-btn" onclick="window.router.navigate('<?= url('admin/edit_account_user/' . $u->id) ?>')" title="Edit Pengguna" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #3b82f6; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                            <i class="fas fa-edit" style="font-size: 14px;"></i>
                                        </button>
                                        <?php if($u->id != Auth::user()->id): ?>
                                            <button class="action-btn" onclick="deleteUser(<?= $u->id ?>)" title="Hapus Akun" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 8px; color: #ef4444; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; transition: all 0.2s;">
                                                <i class="fas fa-trash-alt" style="font-size: 14px;"></i>
                                            </button>
                                        <?php endif; ?>
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
function deleteUser(id) {
    window.deleteItem('<?= url('admin/delete_account_user/') ?>' + id, 'Hapus Akun Pengguna?');
}

async function toggleStatus(id) {
    try {
        const res = await fetch('<?= url('admin/toggle_user_status/') ?>' + id, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (data.status === 'success') {
            if (window.router) {
                window.router.loadPage(window.location.href, false);
            } else {
                location.reload();
            }
        }
    } catch(e) {
        console.error(e);
    }
}
</script>
