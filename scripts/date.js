document.addEventListener('DOMContentLoaded', () => {
    const dateElement = document.querySelector('footer > #date'); // Selecting the date container by ID
    const today = new Date();
    dateElement.textContent = `${today.getMonth() + 1}/${today.getDate()}/${today.getFullYear()}`;
});





