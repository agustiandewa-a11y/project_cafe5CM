let cart = {};
let prices = {};

function addToCart(item, harga) {
    if (!cart[item]) {
        cart[item] = 1;
        prices[item] = harga;
    } else {
        cart[item]++;
    }
    updateCart();
}

function decreaseItem(item) {
    if (cart[item]) {
        cart[item]--;
        if (cart[item] <= 0) {
            delete cart[item];
            delete prices[item];
        }
    }
    updateCart();
}

function updateCart() {
    let total = 0, harga = 0;
    for (let item in cart) {
        total += cart[item];
        harga += cart[item] * prices[item];
    }
    document.getElementById('cartCount').innerText = total;
    document.getElementById('totalHarga').innerText = 'Total: Rp ' + harga.toLocaleString();
}

function showCart() {
    let text = 'Halo 5CM Cafe,%0A Saya ingin pesan:%0A';
    let totalHarga = 0;
    for (let item in cart) {
        text += item + ' x' + cart[item] + '%0A';
        totalHarga += cart[item] * prices[item];
    }
    text += '%0ATotal: Rp ' + totalHarga.toLocaleString();
    window.open('https://wa.me/628950891543?text=' + text);
}


function scrollToMenu(element) {
    element.scrollIntoView({ behavior: 'smooth' });
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

window.addEventListener('scroll', () => {
    const btn = document.getElementById('backTop');
    if (btn) {
        if (window.scrollY > 300) btn.style.display = 'block';
        else btn.style.display = 'none';
    }
});


const inputGambar = document.getElementById('inputGambar');
const previewGambar = document.getElementById('previewGambar');

if (inputGambar && previewGambar) {
    const gambarAwal = previewGambar.getAttribute('src');

    inputGambar.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                previewGambar.setAttribute('src', this.result);
                previewGambar.style.display = 'block';
            });
            reader.readAsDataURL(file);
        } else {
            if (gambarAwal && gambarAwal !== '#') {
                previewGambar.setAttribute('src', gambarAwal);
            } else {
                previewGambar.style.display = 'none';
                previewGambar.setAttribute('src', '#');
            }
        }
    });
}