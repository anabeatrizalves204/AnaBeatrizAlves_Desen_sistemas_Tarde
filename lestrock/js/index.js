document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("lista-produtos");
  const btnMais = document.getElementById("carregar-mais");

  if (!container || !btnMais) return;

  let pagina = 1;
  const termo = "pagode";
  const key = "CdGODaeIwjOSStGpHleL";
  const secret = "vSgbqlAacxUTOCXAKXKgaBuTUEoEXBRs";

  function carregarDiscos() {
    fetch(`https://api.discogs.com/database/search?q=${termo}&type=release&page=${pagina}&per_page=12&key=${key}&secret=${secret}`)
      .then(res => res.json())
      .then(data => {
        if (!data.results || data.results.length === 0) {
          btnMais.style.display = "none";
          return;
        }

        data.results.forEach(item => {
          const card = document.createElement("div");
          card.className = "produto";

          card.innerHTML = `
            <img src="${item.cover_image}" alt="${item.title}">
            <h3>${item.title}</h3>
            <p>${item.genre ? item.genre.join(', ') : 'Gênero desconhecido'}</p>
            <button>Ver Detalhes</button>
          `;

          container.appendChild(card);
        });

        pagina++;
      })
      .catch(err => {
        console.error("Erro ao buscar produtos:", err);
        container.innerHTML = "<p>Erro ao carregar produtos.</p>";
      });
  }

  // Carrega a primeira página ao iniciar
  carregarDiscos();

  // Ao clicar em "Carregar mais"
  btnMais.addEventListener("click", carregarDiscos);
});
