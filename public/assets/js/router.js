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
            this.contentContainer.style.opacity = 0;
            setTimeout(() => {
                this.contentContainer.innerHTML = html;
                this.contentContainer.style.opacity = 1;
                
                // Re-initialize scripts inside the new content if any
                this.executeScripts(this.contentContainer);
                
                // Update active state on sidebar
                this.updateSidebarActiveState(url);
            }, 200);

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
        const links = document.querySelectorAll('.sidebar .nav-link');
        links.forEach(link => {
            link.classList.remove('active');
            if (link.href === url) {
                link.classList.add('active');
            }
        });
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
