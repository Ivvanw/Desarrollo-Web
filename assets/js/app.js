/**
 * Tutor Web · Interacciones generales
 */
document.addEventListener('DOMContentLoaded', () => {
    // Botón "Copiar" en cada bloque de código
    document.querySelectorAll('pre').forEach((bloque) => {
        const codigo = bloque.querySelector('code');
        if (!codigo) {
            return;
        }

        const boton = document.createElement('button');
        boton.type = 'button';
        boton.className = 'code-copy';
        boton.textContent = 'Copiar';
        boton.setAttribute('aria-label', 'Copiar código');

        boton.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(codigo.textContent);
                boton.textContent = '¡Copiado!';
                boton.classList.add('copiado');
            } catch (error) {
                boton.textContent = 'No se pudo copiar';
            }

            setTimeout(() => {
                boton.textContent = 'Copiar';
                boton.classList.remove('copiado');
            }, 1800);
        });

        bloque.appendChild(boton);
    });

    // Cierra el menú móvil al elegir una opción
    document.querySelectorAll('#menuPrincipal .dropdown-item').forEach((enlace) => {
        enlace.addEventListener('click', () => {
            const menu = document.getElementById('menuPrincipal');
            if (menu && menu.classList.contains('show')) {
                bootstrap.Collapse.getOrCreateInstance(menu).hide();
            }
        });
    });
});
