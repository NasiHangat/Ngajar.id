document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('token-modal');
    const bukaBtn = document.getElementById('buka-token');
    const tutupBtn = document.getElementById('tutup-modal');
    const tokenContent = document.getElementById('token-content');

    bukaBtn.addEventListener('click', () => {
        fetch('token.php')
            .then(response => response.text())
            .then(html => {
                tokenContent.innerHTML = html;
                modal.classList.remove('hidden');

                const options = tokenContent.querySelectorAll('.topup-option');
                const beliSection = tokenContent.querySelector('#beli-section');
                let selectedToken = null;

                options.forEach(option => {
                    option.addEventListener('click', () => {
                        options.forEach(o => o.classList.remove('border-4', 'border-green-500'));
                        option.classList.add('border-4', 'border-green-500');
                        selectedToken = {
                            tokens: option.dataset.tokens,
                            price: option.dataset.price
                        };
                        beliSection.classList.remove('hidden');
                    });
                });

                const beliBtn = tokenContent.querySelector('#beli-button');
                beliBtn.addEventListener('click', () => {
                    if (selectedToken) {
                        alert(`Lanjut ke proses pembayaran...\n${selectedToken.tokens} Token berhasil dibeli!`);
                        modal.classList.add('hidden');
                    }
                });
            });
    });

    tutupBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });
});
