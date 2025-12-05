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

// untkj di maykurs

function openTab(tabName, element) {
    const sections = document.querySelectorAll('.course-ongoing, .course-completed');
    sections.forEach(section => {
        section.classList.remove('active-section');
    });
    
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    const selectedSection = document.getElementById(tabName);
    if (selectedSection) {
        selectedSection.classList.add('active-section');
    }
    
    if (element) {
        element.classList.add('active');
    }
}