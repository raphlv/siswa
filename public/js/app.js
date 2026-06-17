/**
 * IGAKERTA Publisher - Custom Interactivity Script
 */

document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. Mobile Navigation Menu Toggle
    // ==========================================
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function () {
            navMenu.classList.toggle('active');
            // Toggle hamburger animation if desired
            const spans = menuToggle.querySelectorAll('span');
            spans.forEach(span => span.classList.toggle('active'));
        });
    }

    // Close menu when clicking a link
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navMenu) navMenu.classList.remove('active');
        });
    });

    // ==========================================
    // 1.1 Desktop Dropdown Hover & Mobile Toggle
    // ==========================================
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const link = dropdown.querySelector('.nav-link');
        const menu = dropdown.querySelector('.dropdown-menu');

        // Desktop hover behavior
        if (window.innerWidth > 992) {
            dropdown.addEventListener('mouseenter', () => {
                if (menu) menu.style.display = 'block';
            });
            dropdown.addEventListener('mouseleave', () => {
                if (menu) menu.style.display = '';
            });
        }

        // Mobile click toggle (for touch)
        if (link && menu) {
            link.addEventListener('click', (e) => {
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    const isOpen = menu.style.display === 'block';
                    // Close all other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = '');
                    if (!isOpen) {
                        menu.style.display = 'block';
                    }
                }
            });
        }
    });

    // ==========================================
    // 1.2 Smooth Scroll for Anchor Links
    // ==========================================
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            // Only handle same-page anchors
            if (href.startsWith('#') && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });


    // ==========================================
    // 2. Bookstore: Client-side Search and Filter
    // ==========================================
    const filterButtons = document.querySelectorAll('.filter-btn');
    const bookCards = document.querySelectorAll('.book-card-item');
    const searchInput = document.getElementById('book-search');

    let currentCategory = 'all';
    let searchQuery = '';

    function filterBooks() {
        let visibleCount = 0;
        const noResults = document.getElementById('no-books-found');
        const countSpan = document.getElementById('visible-books-count');

        bookCards.forEach(card => {
            const category = card.getAttribute('data-category').toLowerCase();
            const title = card.getAttribute('data-title').toLowerCase();
            const author = card.getAttribute('data-author').toLowerCase();

            const matchesCategory = (currentCategory === 'all' || category === currentCategory);
            const matchesSearch = (title.includes(searchQuery) || author.includes(searchQuery));

            if (matchesCategory && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (countSpan) {
            countSpan.textContent = visibleCount;
        }

        if (noResults) {
            if (visibleCount === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }
    }

    // Filter Button Click Handlers
    if (filterButtons.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                currentCategory = this.getAttribute('data-filter').toLowerCase();
                filterBooks();
            });
        });
    }

    // Search Input Change Handler
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.toLowerCase().trim();
            filterBooks();
        });
    }

    // Bookstore Sort Handler
    const sortFilter = document.getElementById('sort-filter');
    const catalogGrid = document.getElementById('book-catalog-grid');
    if (sortFilter && catalogGrid) {
        sortFilter.addEventListener('change', function () {
            const val = this.value;
            const cards = Array.from(catalogGrid.querySelectorAll('.book-card-item'));
            cards.sort((a, b) => {
                if (val === 'latest') {
                    // sort by year
                    return parseInt(b.getAttribute('data-year')) - parseInt(a.getAttribute('data-year'));
                } else if (val === 'title-asc') {
                    return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
                } else if (val === 'price-asc') {
                    return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
                } else if (val === 'price-desc') {
                    return parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price'));
                }
                return 0;
            });
            catalogGrid.innerHTML = '';
            cards.forEach(c => catalogGrid.appendChild(c));
        });
    }


    // ==========================================
    // 3. Bookstore: Book Details Modal & WhatsApp Order
    // ==========================================
    const detailButtons = document.querySelectorAll('.btn-detail');
    const modal = document.getElementById('book-detail-modal');
    const modalClose = document.getElementById('modal-close-btn');

    if (detailButtons.length > 0 && modal) {
        detailButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                // Fetch book attributes
                const title = this.getAttribute('data-title');
                const author = this.getAttribute('data-author');
                const category = this.getAttribute('data-category');
                const priceFormatted = this.getAttribute('data-price-formatted');
                const priceRaw = this.getAttribute('data-price-raw');
                const description = this.getAttribute('data-description');
                const pages = this.getAttribute('data-pages') || '-';
                const year = this.getAttribute('data-year') || '-';
                const isbn = this.getAttribute('data-isbn') || '-';

                // Populate modal content
                document.getElementById('m-title').textContent = title;
                document.getElementById('m-author').textContent = author;
                document.getElementById('m-category').textContent = category;
                document.getElementById('m-pages').textContent = pages + ' Halaman';
                document.getElementById('m-year').textContent = year;
                document.getElementById('m-isbn').textContent = isbn;
                document.getElementById('m-desc').textContent = description;
                document.getElementById('m-price').textContent = priceFormatted;

                // Setup cover typography preview inside modal
                const titleCover = document.getElementById('m-title-cover');
                const authorCover = document.getElementById('m-author-cover');
                const catCover = document.getElementById('m-category-badge-cover');
                if (titleCover) titleCover.textContent = title;
                if (authorCover) authorCover.textContent = author;
                if (catCover) catCover.textContent = category;

                // WhatsApp Pre-filled Message Configuration
                const waBtn = document.getElementById('m-wa-btn');
                if (waBtn) {
                    const phoneNumber = '62813xxxxxxxx'; // IGAKERTA CS Phone
                    const message = `Halo Admin IGAKERTA,%0A%0ASaya ingin memesan buku berikut:%0A%0A*Judul:* ${encodeURIComponent(title)}%0A*Penulis:* ${encodeURIComponent(author)}%0A*Kategori:* ${encodeURIComponent(category)}%0A*Harga:* ${encodeURIComponent(priceFormatted)}%0A%0AMohon info cara pembayaran dan pengirimannya. Terima kasih!`;
                    waBtn.href = `https://wa.me/${phoneNumber}?text=${message}`;
                }

                // Show modal
                modal.style.display = 'flex';
            });
        });
    }

    // Close Modal Event Listeners
    if (modalClose) {
        modalClose.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }

    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }


    // ==========================================
    // 3.1 FAQ Accordions Toggling
    // ==========================================
    const faqHeaders = document.querySelectorAll('.faq-header');
    if (faqHeaders.length > 0) {
        faqHeaders.forEach(header => {
            header.addEventListener('click', function () {
                const item = this.parentNode;
                const isActive = item.classList.contains('active');

                // close other items
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));

                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
    }


    // ==========================================
    // 3.2 Mitra Tabs Filtering
    // ==========================================
    const mitraTabs = document.querySelectorAll('.mitra-tab');
    const mitraCards = document.querySelectorAll('.mitra-card');
    if (mitraTabs.length > 0) {
        mitraTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                mitraTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                mitraCards.forEach(card => {
                    const type = card.getAttribute('data-type');
                    if (filter === 'all' || type === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }


    // ==========================================
    // 3.3 Articles (News) Filtering & Searching
    // ==========================================
    const catPills = document.querySelectorAll('.cat-pill');
    const articleCards = document.querySelectorAll('.artikel-feed-card');
    const articleSearch = document.getElementById('article-search');
    const articleSort = document.getElementById('article-sort');
    const feedGrid = document.getElementById('artikel-feed-grid');

    let currentArtCat = 'all';
    let artQuery = '';

    function filterArticles() {
        articleCards.forEach(card => {
            const category = card.getAttribute('data-category');
            const title = card.getAttribute('data-title').toLowerCase();

            const matchesCat = (currentArtCat === 'all' || category === currentArtCat);
            const matchesSearch = title.includes(artQuery);

            if (matchesCat && matchesSearch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    if (catPills.length > 0) {
        catPills.forEach(pill => {
            pill.addEventListener('click', function () {
                catPills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                currentArtCat = this.getAttribute('data-filter');
                filterArticles();
            });
        });
    }

    if (articleSearch) {
        articleSearch.addEventListener('input', function () {
            artQuery = this.value.toLowerCase().trim();
            filterArticles();
        });
    }

    if (articleSort && feedGrid) {
        articleSort.addEventListener('change', function () {
            const cards = Array.from(feedGrid.querySelectorAll('.artikel-feed-card'));
            cards.reverse();
            feedGrid.innerHTML = '';
            cards.forEach(c => feedGrid.appendChild(c));
        });
    }


    // ==========================================
    // 4. Manuscript Submission Form (AJAX / Fetch)
    // ==========================================
    const submissionForm = document.getElementById('manuscript-submission-form');
    const manuscriptInput = document.getElementById('manuscript-file');
    const fileZone = document.getElementById('file-upload-zone');
    const fileInfo = document.getElementById('selected-file-info');

    // Drag and Drop for file zone
    if (fileZone && manuscriptInput) {
        fileZone.addEventListener('click', () => manuscriptInput.click());

        manuscriptInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                const name = this.files[0].name;
                const sizeMB = (this.files[0].size / (1024 * 1024)).toFixed(2);
                fileInfo.textContent = `File terpilih: ${name} (${sizeMB} MB)`;
            } else {
                fileInfo.textContent = '';
            }
        });

        // Highlight drag events
        ['dragenter', 'dragover'].forEach(eventName => {
            fileZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                fileZone.style.borderColor = 'var(--color-accent)';
                fileZone.style.backgroundColor = 'rgba(217,119,6,0.05)';
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                fileZone.style.borderColor = 'var(--color-text-light)';
                fileZone.style.backgroundColor = 'var(--color-bg-base)';
            }, false);
        });

        fileZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                manuscriptInput.files = files;
                const name = files[0].name;
                const sizeMB = (files[0].size / (1024 * 1024)).toFixed(2);
                fileInfo.textContent = `File terpilih: ${name} (${sizeMB} MB)`;
            }
        });
    }

    // Submit via AJAX
    if (submissionForm) {
        submissionForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Clear previous errors
            const errorSpans = submissionForm.querySelectorAll('.error-message');
            errorSpans.forEach(span => span.remove());
            const formInputs = submissionForm.querySelectorAll('.form-input, .form-textarea');
            formInputs.forEach(input => {
                input.style.borderColor = 'var(--color-bg-alt)';
            });

            const alertSuccess = document.getElementById('alert-success');
            const alertError = document.getElementById('alert-error');
            const submitBtn = document.getElementById('submit-btn');

            if (alertSuccess) alertSuccess.style.display = 'none';
            if (alertError) alertError.style.display = 'none';

            // Show loading
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner"></span> Mengirim Naskah...';

            // Prepare form data
            const formData = new FormData(this);

            // Fetch AJAX Request
            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    // Reset loading
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;

                    if (res.status === 200 && res.body.success) {
                        // Success
                        if (alertSuccess) {
                            alertSuccess.textContent = res.body.message;
                            alertSuccess.style.display = 'block';
                            // Scroll to alert
                            alertSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        submissionForm.reset();
                        if (fileInfo) fileInfo.textContent = '';
                    } else if (res.status === 422) {
                        // Validation Errors
                        const errors = res.body.errors;
                        Object.keys(errors).forEach(field => {
                            const inputElement = document.getElementById(field);
                            if (inputElement) {
                                inputElement.style.borderColor = '#ef4444';

                                // Create error helper span
                                const errorSpan = document.createElement('span');
                                errorSpan.className = 'error-message';
                                errorSpan.style.color = '#ef4444';
                                errorSpan.style.fontSize = '0.8rem';
                                errorSpan.style.display = 'block';
                                errorSpan.style.marginTop = '0.25rem';
                                errorSpan.textContent = errors[field][0];

                                // Insert error after input element or after the file zone
                                if (field === 'manuscript') {
                                    fileZone.parentNode.appendChild(errorSpan);
                                } else {
                                    inputElement.parentNode.appendChild(errorSpan);
                                }
                            }
                        });

                        if (alertError) {
                            alertError.textContent = 'Terjadi kesalahan pengisian data. Silakan periksa kembali formulir Anda.';
                            alertError.style.display = 'block';
                            alertError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        // Other error
                        if (alertError) {
                            alertError.textContent = 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi atau hubungi kami langsung via WhatsApp.';
                            alertError.style.display = 'block';
                            alertError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error submitting form:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;

                    if (alertError) {
                        alertError.textContent = 'Koneksi bermasalah. Pastikan Anda terhubung ke internet dan coba lagi.';
                        alertError.style.display = 'block';
                    }
                });
        });
    }

    // ==========================================
    // 5. Contact Form Submission (AJAX / Fetch)
    // ==========================================
    const contactForm = document.getElementById('contact-message-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Clear previous errors
            const errorSpans = contactForm.querySelectorAll('.error-message');
            errorSpans.forEach(span => span.remove());
            const formInputs = contactForm.querySelectorAll('input, textarea');
            formInputs.forEach(input => {
                input.style.borderColor = 'rgba(25, 14, 47, 0.08)';
            });

            const alertSuccess = document.getElementById('contact-alert-success');
            const alertError = document.getElementById('contact-alert-error');
            const submitBtn = document.getElementById('contact-submit-btn');

            if (alertSuccess) alertSuccess.style.display = 'none';
            if (alertError) alertError.style.display = 'none';

            // Show loading
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner"></span> Mengirim Pesan...';

            // Prepare form data
            const formData = new FormData(this);

            // Fetch AJAX Request
            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    // Reset loading
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;

                    if (res.status === 200 && res.body.success) {
                        // Success
                        if (alertSuccess) {
                            alertSuccess.textContent = res.body.message;
                            alertSuccess.style.display = 'block';
                            alertSuccess.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        contactForm.reset();
                    } else if (res.status === 422) {
                        // Validation Errors
                        const errors = res.body.errors;
                        Object.keys(errors).forEach(field => {
                            const inputElement = document.getElementById(field);
                            if (inputElement) {
                                inputElement.style.borderColor = '#ef4444';

                                const errorSpan = document.createElement('span');
                                errorSpan.className = 'error-message';
                                errorSpan.style.color = '#ef4444';
                                errorSpan.style.fontSize = '0.8rem';
                                errorSpan.style.display = 'block';
                                errorSpan.style.marginTop = '0.25rem';
                                errorSpan.textContent = errors[field][0];

                                inputElement.parentNode.appendChild(errorSpan);
                            }
                        });

                        if (alertError) {
                            alertError.textContent = 'Terjadi kesalahan pengisian data. Silakan periksa kembali formulir Anda.';
                            alertError.style.display = 'block';
                            alertError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    } else {
                        // Other error
                        if (alertError) {
                            alertError.textContent = 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi.';
                            alertError.style.display = 'block';
                            alertError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error submitting contact form:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;

                    if (alertError) {
                        alertError.textContent = 'Koneksi bermasalah. Pastikan Anda terhubung ke internet dan coba lagi.';
                        alertError.style.display = 'block';
                    }
                });
        });
    }

});
