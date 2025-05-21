// Add modal
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

//Edit modal

// const openModalBtnEdit = document.getElementById('editAccountButton');
// const closeModalBtnEdit = document.getElementById('closeEditModalAccount');
// const modalEdit = document.getElementById('editAccountModal');

// openModalBtnEdit.addEventListener('click', () => {
//     modalEdit.classList.remove('hidden');
// });

// closeModalBtnEdit.addEventListener('click', () => {
//     modalEdit.classList.add('hidden');
// });

// modalEdit.addEventListener('click', (event) => {
//     if (event.target === modalEdit) {
//         modalEdit.classList.add('hidden');
//     }
// });
