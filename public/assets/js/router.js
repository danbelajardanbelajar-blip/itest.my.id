class Router {
    constructor() {
        this.contentContainer = document.getElementById('app-content');
        this.loader = document.getElementById('page-loader');
        this.init();
    }

    init() {
        // Intercept all link clicks
        document.body.addEventListener('click', e => {
            const link = e.target.closest('a');
            if (link && link.href && link.href.startsWith(window.location.origin)) {
                // Ignore links with target="_blank" or specific classes
                if (link.target === '_blank' || link.classList.contains('no-spa')) return;
                
                e.preventDefault();
                this.navigate(link.href);
            }
        });

        // Handle back/forward buttons
        window.addEventListener('popstate', () => {
            this.loadPage(window.location.href, false);
        });

        // Highlight active sidebar on initial load
        this.updateSidebarActiveState(window.location.href);
    }

    navigate(url) {
        if (window.location.href === url) return;
        history.pushState(null, '', url);
        this.loadPage(url, true);
    }

    async loadPage(url, pushState = true) {
        this.showLoader();
        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.redirected) {
                // Handle server side redirect
                window.location.href = response.url;
                return;
            }

            const html = await response.text();
            
            // Render the partial view
            if (this.contentContainer) {
                this.contentContainer.style.opacity = 0;
                setTimeout(() => {
                    this.contentContainer.innerHTML = html;
                    this.contentContainer.style.opacity = 1;
                    
                    // Re-initialize scripts inside the new content if any
                    this.executeScripts(this.contentContainer);
                    
                    // Update active state on sidebar
                    this.updateSidebarActiveState(url);
                }, 150);
            } else {
                // Fallback full reload if container not found
                window.location.href = url;
            }

        } catch (error) {
            console.error('Error loading page:', error);
            Swal.fire('Error', 'Gagal memuat halaman', 'error');
        } finally {
            this.hideLoader();
        }
    }

    executeScripts(container) {
        const scripts = container.querySelectorAll('script');
        scripts.forEach(oldScript => {
            const newScript = document.createElement('script');
            Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
            newScript.appendChild(document.createTextNode(oldScript.innerHTML));
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });
    }

    updateSidebarActiveState(url) {
        let targetPath = '';
        try {
            const parsedUrl = new URL(url, window.location.origin);
            targetPath = parsedUrl.pathname.replace(/\/+$/, '').toLowerCase();
        } catch(e) {
            targetPath = String(url).toLowerCase();
        }

        // Sub-route aliases to parent menus
        const subRouteAliases = {
            'create_exam': 'exams',
            'editexam': 'exams',
            'create_question': 'questions',
            'editquestion': 'questions',
            'create_user': 'users',
            'editstudent': 'users',
            'create_staff': 'staff',
            'editstaff': 'staff',
            'create_school': 'schools',
            'editschool': 'schools',
            'create_room': 'rooms',
            'editroom': 'rooms',
            'create_class': 'classes',
            'editclass': 'classes',
            'create_account_user': 'account_users',
            'edit_account_user': 'account_users'
        };

        let activeKeyword = '';
        for (const [sub, parent] of Object.entries(subRouteAliases)) {
            if (targetPath.includes(sub)) {
                activeKeyword = parent;
                break;
            }
        }

        const navItems = document.querySelectorAll('.sidebar-nav .nav-item, .sidebar-nav button, .sidebar-nav a, .nav-buttons-group button, .nav-buttons-group a');
        
        navItems.forEach(item => {
            item.classList.remove('active');

            const onclickAttr = item.getAttribute('onclick') || '';
            const hrefAttr = item.getAttribute('href') || '';
            
            const match = onclickAttr.match(/navigate\(['"]([^'"]+)['"]\)/);
            let itemUrl = match && match[1] ? match[1] : hrefAttr;

            if (itemUrl) {
                let itemPath = '';
                try {
                    const parsedItemUrl = new URL(itemUrl, window.location.origin);
                    itemPath = parsedItemUrl.pathname.replace(/\/+$/, '').toLowerCase();
                } catch(e) {
                    itemPath = String(itemUrl).toLowerCase();
                }

                if (itemPath === targetPath) {
                    item.classList.add('active');
                } else if (activeKeyword && itemPath.endsWith('/' + activeKeyword)) {
                    item.classList.add('active');
                } else if (targetPath.endsWith(itemPath) && !itemPath.endsWith('/admin') && !itemPath.endsWith('/teacher') && !itemPath.endsWith('/student')) {
                    item.classList.add('active');
                }
            }
        });

        // Close mobile drawer if opened
        const adminSidebar = document.querySelector('.admin-sidebar');
        if (adminSidebar && adminSidebar.classList.contains('mobile-open')) {
            adminSidebar.classList.remove('mobile-open');
            const overlay = document.querySelector('.mobile-sidebar-overlay');
            if (overlay) overlay.style.display = 'none';
        }
        const studentHeader = document.querySelector('.header-actions');
        if (studentHeader && studentHeader.classList.contains('mobile-open')) {
            studentHeader.classList.remove('mobile-open');
        }
    }

    showLoader() {
        if (this.loader) this.loader.style.display = 'flex';
    }

    hideLoader() {
        if (this.loader) this.loader.style.display = 'none';
    }
}

// Initialize Router when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.router = new Router();
});
