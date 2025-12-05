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

// unutk komuniti


const THREADS = {
    1: {
        id: 1,
        title: "Tips build portfolio UI/UX?",
        author: "Andi",
        category: "design",
        content: "Kalo mau bikin portfolio, mending fokus proyek kecil yang lengkap: research, wireframe, prototype. Share contoh dong.",
        replies: [
            { id: 1, author: "Nina", text: "Mulai dari case study kecil, jelasin problem & solusi." },
            { id: 2, author: "Mentor Andi", text: "Gunakan Figma untuk mockup & upload link figma ke portfolio." }
        ]
    },
    2: {
        id: 2,
        title: "Best resources to learn SQL?",
        author: "Nabila",
        category: "dev",
        content: "Ada rekomendasi resource belajar SQL praktek? Prefer yang ada latihan.",
        replies: [
            { id: 1, author: "Dito", text: "SQLZoo & Mode Analytics bagus buat practice." }
        ]
    },
    3: {
        id: 3,
        title: "How to prepare for tech interviews?",
        author: "Rico",
        category: "career",
        content: "Butuh checklist interview: coding + sistem design + HR. Ada template?",
        replies: [
            { id: 1, author: "Andi", text: "Latihan soal data structures, bikin list common behavioral questions." },
            { id: 2, author: "Nabila", text: "Jangan lupa mock interview sama teman." }
        ]
    }
};

// Function untuk membuka thread
function openThread(event, threadId) {
    event.preventDefault();
    const thread = THREADS[threadId];
    if (!thread) return;
    
    const pane = document.getElementById('threadPane');
    pane.innerHTML = `
        <div class="thread-detail">
            <div class="thread-head">
                <div>
                    <h2>${thread.title}</h2>
                    <p class="text-muted mb-0">by <strong>${thread.author}</strong></p>
                </div>
            </div>
            <div class="thread-content">
                <p>${thread.content}</p>
            </div>
            <div class="replies-section mt-4">
                <h4 class="mb-3">Replies (${thread.replies.length})</h4>
                ${thread.replies.map(reply => `
                    <div class="reply">
                        <strong>${reply.author}</strong>
                        <p class="mb-0 mt-2">${reply.text}</p>
                    </div>
                `).join('')}
            </div>
        </div>
    `;
    pane.classList.remove('empty');
}

// Function untuk membuka modal create post
document.addEventListener('DOMContentLoaded', function() {
    const btnCreatePost = document.getElementById('btnCreatePost');
    const modal = document.getElementById('modalCreate');
    
    if (btnCreatePost) {
        btnCreatePost.addEventListener('click', function() {
            modal.classList.add('show');
        });
    }
    
    // Filter tabs
    const tabs = document.querySelectorAll('.forum-tabs .tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const target = this.getAttribute('data-target');
            const threads = document.querySelectorAll('.thread-card');
            
            threads.forEach(thread => {
                if (target === 'all' || thread.getAttribute('data-category') === target) {
                    thread.style.display = 'flex';
                } else {
                    thread.style.display = 'none';
                }
            });
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchThread');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const threads = document.querySelectorAll('.thread-card');
            
            threads.forEach(thread => {
                const title = thread.querySelector('.thread-title').textContent.toLowerCase();
                const content = thread.querySelector('.text-muted').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || content.includes(searchTerm)) {
                    thread.style.display = 'flex';
                } else {
                    thread.style.display = 'none';
                }
            });
        });
    }
});

// Function untuk menutup modal
function closeModal() {
    const modal = document.getElementById('modalCreate');
    modal.classList.remove('show');
}

// Function untuk create post
function createPost() {
    const title = document.getElementById('postTitle').value;
    const category = document.getElementById('postCategory').value;
    const content = document.getElementById('postContent').value;
    
    if (!title || !content) {
        alert('Please fill in all fields');
        return;
    }
    
    // Add new thread to list
    const threadList = document.getElementById('threadList');
    const newThread = document.createElement('article');
    newThread.className = 'thread-card';
    newThread.setAttribute('data-category', category);
    
    const categoryNames = {
        'design': 'UI/UX',
        'dev': 'Programming',
        'career': 'Career',
        'project': 'Projects'
    };
    
    newThread.innerHTML = `
        <div class="thread-left">
            <h3 class="thread-title"><a href="#" onclick="openThread(event,${Date.now()})">${title}</a></h3>
            <p class="text-muted mb-2">${content.substring(0, 100)}... — <strong>You</strong></p>
            <div class="thread-meta">
                <span class="badge">${categoryNames[category]}</span>
                <span class="text-muted">• 0 replies</span>
                <span class="text-muted">• just now</span>
            </div>
        </div>
        <div class="thread-right">
            <button class="btn-small" onclick="openThread(event,${Date.now()})">View</button>
        </div>
    `;
    
    threadList.insertBefore(newThread, threadList.firstChild);
    
    // Reset form and close modal
    document.getElementById('postTitle').value = '';
    document.getElementById('postContent').value = '';
    closeModal();
    
    alert('Post created successfully!');
}