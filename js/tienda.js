document.addEventListener('DOMContentLoaded', () => {
  // Mobile menu
  const menuToggle = document.getElementById('menu-toggle');
  const mainNav = document.getElementById('main-nav');
  if (menuToggle && mainNav) {
    menuToggle.addEventListener('click', () => {
      mainNav.classList.toggle('is-open');
      const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', !expanded);
    });
  }

  // Add to cart buttons
  document.querySelectorAll('.js-add-cart').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const id = btn.dataset.id;
      const qtyInput = document.getElementById(`qty-${id}`);
      const qty = qtyInput ? qtyInput.value : 1;

      try {
        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('id', id);
        formData.append('cantidad', qty);

        const res = await fetch('api/carrito.php', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();
        
        if (data.ok) {
          const badge = document.getElementById('cart-badge');
          if (badge) {
            badge.textContent = data.items;
            badge.classList.remove('idein-cart-badge-hidden');
          }
          showToast('Agregado al carrito');
        } else {
          showToast(data.msg || 'Error al agregar', 'error');
        }
      } catch (err) {
        console.error(err);
        showToast('Error de conexión', 'error');
      }
    });
  });

  function showToast(msg, type = 'success') {
    const toast = document.getElementById('idein-toast');
    if (!toast) return;
    toast.textContent = msg;
    toast.style.display = 'block';
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.background = type === 'success' ? 'var(--success)' : 'var(--danger)';
    toast.style.color = 'white';
    toast.style.padding = '10px 20px';
    toast.style.borderRadius = '8px';
    toast.style.zIndex = '9999';
    setTimeout(() => {
      toast.style.display = 'none';
    }, 3000);
  }
});
