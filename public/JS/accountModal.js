const openModalBtn = document.getElementById('addAccountButton');
const closeModalBtn = document.getElementById('closeModalAccount');
const modal = document.getElementById('accountModal');

openModalBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});

modal.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.classList.add('hidden');
    }
});