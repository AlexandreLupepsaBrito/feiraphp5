const carouselItems = document.querySelectorAll('.carousel-item');
let currentItem = 0;

function showItem(index) {
    carouselItems.forEach((item, i) => {
        item.style.display = i === index ? 'block' : 'none';
    });
}

function nextItem() {
    currentItem = (currentItem + 1) % carouselItems.length;
    showItem(currentItem);
}

// Muda o item a cada 5 segundos
setInterval(nextItem, 5000); // 5000 milissegundos = 5 segundos

// Opcional: Adiciona botões de navegação
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

if (prevButton && nextButton) {
    prevButton.addEventListener('click', () => {
        currentItem = (currentItem - 1 + carouselItems.length) % carouselItems.length;
        showItem(currentItem);
    });

    nextButton.addEventListener('click', () => {
        nextItem(); // Usa a função nextItem já definida
    });
}

// Inicializa o primeiro item
showItem(currentItem);