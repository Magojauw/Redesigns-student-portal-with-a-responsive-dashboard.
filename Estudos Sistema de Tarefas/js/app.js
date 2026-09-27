document.addEventListener('DOMContentLoaded', () => {
    const modal = document.querySelector('#task-modal');
    const sidebar = document.querySelector('#sidebar');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const taskInput = document.querySelector('#tarefa');

    const closeModal = () => {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
    };

    document.querySelectorAll('[data-open-modal]').forEach((button) => {
        button.addEventListener('click', () => {
            if (!modal) return;
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            taskInput?.focus();
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    modal?.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeModal();
    });

    menuToggle?.addEventListener('click', () => {
        const isOpen = sidebar?.classList.toggle('is-open') ?? false;
        menuToggle.setAttribute('aria-expanded', String(isOpen));
    });

    document.querySelectorAll('.sidebar a').forEach((link) => {
        link.addEventListener('click', () => {
            sidebar?.classList.remove('is-open');
            menuToggle?.setAttribute('aria-expanded', 'false');
        });
    });

    document.querySelector('[data-logout]')?.addEventListener('click', (event) => {
        event.preventDefault();
        window.alert('Sessão encerrada.');
    });
});
