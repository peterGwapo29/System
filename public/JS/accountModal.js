// JavaScript to toggle the modal
const openModalBtn = document.getElementById('addAccountButton');
const closeModalBtn = document.getElementById('closeModalAccount');
const modal = document.getElementById('accountModal');

// Open modal
openModalBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

// Close modal by clicking the close button
closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});

// Close modal when clicking outside of the modal content
modal.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.classList.add('hidden');
    }
});
