const videoWrapper = document.getElementById('customVideoPlayer');
const video = document.getElementById('mainVideo');
const playBtn = document.getElementById('videoPlayBtn');

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