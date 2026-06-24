document.addEventListener('DOMContentLoaded', function () {

    // === 1. ЛОГИКА КАСТОМНОГО ВИДЕОПЛЕЕРА ===
    const videoWrapper = document.getElementById('customVideoPlayer');
    const video = document.getElementById('mainVideo');
    const playBtn = document.getElementById('videoPlayBtn');

    if (videoWrapper && video && playBtn) {
        // Функция запуска/паузы
        function toggleVideo() {
            if (video.paused) {
                video.play();
                videoWrapper.classList.add('is-playing');
                video.setAttribute('controls', 'true'); // Включаем родные кнопки управления после старта
            } else {
                video.pause();
                videoWrapper.classList.remove('is-playing');
            }
        }

        // Слушаем клики и по кнопке, и по самому видео
        playBtn.addEventListener('click', toggleVideo);
        video.addEventListener('click', toggleVideo);
    }

    // === 2. ЛОГИКА ВЫЕЗЖАЮЩЕГО ПОИСКА ===
    const searchTriggerBtn = document.getElementById('searchTriggerBtn');
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');

    if (searchTriggerBtn && searchInput && searchForm) {
        searchTriggerBtn.addEventListener('click', function (e) {
            // Если инпут скрыт — открываем его и ставим фокус
            if (searchInput.style.width === '0px' || searchInput.style.width === '') {
                e.preventDefault();
                searchInput.style.width = '180px';
                searchInput.style.opacity = '1';
                searchInput.style.paddingLeft = '10px';
                searchInput.style.paddingRight = '10px';
                searchInput.focus();
            } else {
                // Если инпут открыт и там что-то написано — отправляем форму
                if (searchInput.value.trim() !== '') {
                    searchForm.submit();
                } else {
                    // Если пусто — просто закрываем обратно
                    e.preventDefault();
                    searchInput.style.width = '0';
                    searchInput.style.opacity = '0';
                    searchInput.style.paddingLeft = '0';
                    searchInput.style.paddingRight = '0';
                }
            }
        });

        // Закрывать поиск, если кликнули мимо него
        document.addEventListener('click', function (e) {
            if (!searchForm.contains(e.target)) {
                searchInput.style.width = '0';
                searchInput.style.opacity = '0';
                searchInput.style.paddingLeft = '0';
                searchInput.style.paddingRight = '0';
            }
        });
    }

});
