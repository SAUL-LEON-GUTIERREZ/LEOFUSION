const products = [
  {
    name: "Cemento Tipo I - 42.5kg",
    description: "Ideal para estructuras de concreto de alto desempeño.",
    price: "S/ 33.00 referencial",
    image:
      "https://images.unsplash.com/photo-1590247813693-5541d1c609fd?auto=format&fit=crop&w=900&q=80",
  },
  {
    name: "Taladro Percutor 750W",
    description: "Herramienta eléctrica para perforación en concreto y metal.",
    price: "Solicitar precio",
    image:
      "https://images.unsplash.com/photo-1504148455328-c376907d081c?auto=format&fit=crop&w=900&q=80",
  },
  {
    name: "Tubería PVC Presión 1/2\"",
    description: "Conducción hidráulica para instalaciones domiciliarias y obra.",
    price: "S/ 19.90 referencial",
    image:
      "https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?auto=format&fit=crop&w=900&q=80",
  },
  {
    name: "Cable Eléctrico THW 2.5mm",
    description: "Alta resistencia para circuitos de iluminación y tomacorrientes.",
    price: "Solicitar precio",
    image:
      "https://images.unsplash.com/photo-1631563018883-80d259f5f70e?auto=format&fit=crop&w=900&q=80",
  },
  {
    name: "Pintura Látex Premium 1 galón",
    description: "Acabado uniforme y lavable para interiores y exteriores.",
    price: "S/ 84.00 referencial",
    image:
      "https://images.unsplash.com/photo-1562259949-e8e7689d7828?auto=format&fit=crop&w=900&q=80",
  },
  {
    name: "Casco de Seguridad Industrial",
    description: "Protección certificada para obra civil y operaciones de campo.",
    price: "Solicitar precio",
    image:
      "https://images.unsplash.com/photo-1596079890744-c1a0462d0975?auto=format&fit=crop&w=900&q=80",
  },
];

const productGrid = document.querySelector("#product-grid");

if (productGrid) {
  productGrid.innerHTML = products
    .map(
      (product) => `
        <div class="col-12 col-md-6 col-lg-4">
          <article class="product-card h-100 d-flex flex-column">
            <img src="${product.image}" alt="${product.name}" loading="lazy" />
            <h3>${product.name}</h3>
            <p class="mb-2 text-muted">${product.description}</p>
            <span class="price-pill">${product.price}</span>
            <a href="#cotiza-tu-obra" class="btn btn-outline-dark mt-auto">Cotizar</a>
          </article>
        </div>
      `
    )
    .join("");
}

const quoteForm = document.querySelector("#quote-form");
const formResponse = document.querySelector("#form-response");

if (quoteForm && formResponse) {
  quoteForm.addEventListener("submit", (event) => {
    // Se previene el envío solo para demo front-end.
    // En producción, remover preventDefault para permitir POST real al backend.
    event.preventDefault();

    if (!quoteForm.checkValidity()) {
      quoteForm.classList.add("was-validated");
      formResponse.textContent = "Completa los campos obligatorios antes de enviar la cotización.";
      formResponse.className = "small text-danger mt-3 mb-0";
      return;
    }

    formResponse.textContent =
      "Solicitud registrada. Un asesor comercial de LEOFUSION te contactará en breve por WhatsApp o correo.";
    formResponse.className = "small text-success mt-3 mb-0";
    quoteForm.reset();
    quoteForm.classList.remove("was-validated");
  });
}
