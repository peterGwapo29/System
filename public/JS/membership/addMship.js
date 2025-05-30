document.getElementById('addMembershipButton').addEventListener('click', () => {
    document.getElementById('membershipModal').classList.remove('hidden');
});

document.getElementById('closeModalMembership').addEventListener('click', () => {
    document.getElementById('membershipModal').classList.add('hidden');
});
