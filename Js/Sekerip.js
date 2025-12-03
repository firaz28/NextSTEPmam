// unutk begron image di home

document.addEventListener('DOMContentLoaded', () => {
    const initSlider = (rootSelector, imageSelector = 'img') => {
        const containers = document.querySelectorAll(rootSelector);

        containers.forEach((container) => {
            const images = container.querySelectorAll(imageSelector);
            if (!images.length) return;

            let currentIndex = 0;
            images[currentIndex].classList.add('active');

            if (images.length === 1) return;

            setInterval(() => {
                images[currentIndex].classList.remove('active');
                currentIndex = (currentIndex + 1) % images.length;
                images[currentIndex].classList.add('active');
            }, 5000);
        });
    };

    initSlider('.main-hero', 'img[class^="bg-hero-img"]');
    initSlider('div.bg-reg');
});
