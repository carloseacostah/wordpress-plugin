/* script */
document.addEventListener('DOMContentLoaded', function () {
  const boton = document.querySelector('.modulo__boton');
  if (boton) {
    boton.addEventListener('click', function () {
      alert('Botón clickeado');
    });
  }
});
