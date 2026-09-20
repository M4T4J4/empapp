document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.getElementById('mobile-menu-button');
    const nav = document.getElementById('main-navigation');

    if (menuButton && nav) {
        menuButton.addEventListener('click', () => {
            const isExpanded = menuButton.getAttribute('aria-expanded') === 'true';
            menuButton.setAttribute('aria-expanded', String(!isExpanded));
            nav.classList.toggle('hidden');
        });

        nav.querySelectorAll('a, button').forEach((item) => {
            item.addEventListener('click', () => {
                if (window.innerWidth < 768) {
                    menuButton.setAttribute('aria-expanded', 'false');
                    nav.classList.add('hidden');
                }
            });
        });
    }

    const toasts = document.querySelectorAll('.toast');

    toasts.forEach((toast) => {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(8px)';
            toast.style.filter = 'blur(1px)';

            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    });
});
