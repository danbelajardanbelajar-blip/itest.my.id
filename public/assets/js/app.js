document.addEventListener('DOMContentLoaded', () => {
    
    // Global form submission handler for SPA (Login, CRUD, etc)
    document.body.addEventListener('submit', async (e) => {
        const form = e.target;
        if (form.classList.contains('ajax-form')) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: form.method || 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();
                
                if (result.status === 'success') {
                    if (result.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: result.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            if (result.spa_redirect && window.router) {
                                window.router.navigate(result.spa_redirect);
                            } else if (result.spa_reload && window.router) {
                                window.router.navigate(window.location.pathname);
                            } else if (result.redirect) {
                                window.location.href = result.redirect; // Full reload
                            }
                        });
                    } else {
                        if (result.spa_redirect && window.router) {
                            window.router.navigate(result.spa_redirect);
                        } else if (result.spa_reload && window.router) {
                            window.router.navigate(window.location.pathname);
                        } else if (result.redirect) {
                            window.location.href = result.redirect;
                        }
                    }
                } else {
                    Swal.fire('Error', result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Terjadi kesalahan koneksi', 'error');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            }
        }
    });

    // Global delete handler
    window.deleteItem = function(url, title = 'Hapus Data?') {
        Swal.fire({
            title: title,
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const res = await response.json();
                    
                    if (res.status === 'success') {
                        Swal.fire('Terhapus!', res.message, 'success').then(() => {
                            if (window.router) {
                                window.router.navigate(window.location.pathname);
                            } else {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Gagal menghapus data', 'error');
                    }
                } catch (e) {
                    Swal.fire('Error', 'Terjadi kesalahan koneksi', 'error');
                }
            }
        });
    };

});
