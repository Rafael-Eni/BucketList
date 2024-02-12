function createHeart() {
    const heart = document.createElement('div');
    heart.classList.add('heart');

    heart.style.left = Math.random() * 100 + "vw";
    heart.style.animationDuration = Math.random() * 2 + 3 + "s";

    const array = ['🍆', '🍌', '🍎', '🍔', '🍫', '🥪', '🍺', '🌶️', '🥭', '🍇', '🍈', '🍉', '🍋', '🍏', '🍑', '🍒', '🍓', '🥝', '🥞'];
    const index = Math.floor(Math.random() * array.length);

    heart.innerText = array[index];

    const container = document.getElementById('main-container')

    container.appendChild(heart);

    setTimeout(() => {
        heart.remove();
    }, 5000);
}


document.addEventListener('mousemove', function (e) {
    let body = document.querySelector('body');
    let circle = document.getElementById('abs-dog');
    let left = e.clientX - 100;
    let top = e.clientY - 100;

    circle.style.left = left + 'px';
    circle.style.top = top + 'px';


});

// setInterval(createHeart, 300);