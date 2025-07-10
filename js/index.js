document.addEventListener('DOMContentLoaded', () => {
  // Tarjetas informativas
  document.querySelectorAll('.card-section').forEach(card => {
    card.addEventListener('click', () => {
      card.classList.toggle('active');
    });
  });

  // Botón flotante para subir
  const btnTop = document.createElement('button');
  btnTop.id = "btn-top";
  btnTop.innerHTML = "⬆";
  document.body.appendChild(btnTop);

  window.addEventListener("scroll", () => {
    btnTop.style.display = window.scrollY > 300 ? "block" : "none";
  });

  btnTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});
