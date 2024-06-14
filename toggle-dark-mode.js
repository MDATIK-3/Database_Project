document.addEventListener('DOMContentLoaded', () => {
    const mode = localStorage.getItem('mode');
    const body = document.body;
    const toggleButton = document.createElement('button');
    const toggleIcon = document.createElement('img');
    const toggleText = document.createElement('span');

    toggleButton.className = 'toggle-button';
    toggleIcon.id = 'toggle-icon';
    toggleIcon.src = 'https://cdn-icons-png.flaticon.com/512/169/169367.png';
    toggleIcon.alt = 'Toggle Icon';
    toggleIcon.width = '24';
    toggleText.textContent = 'Dark Mode';
    
    toggleButton.appendChild(toggleIcon);
    toggleButton.appendChild(toggleText);
    
    toggleButton.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('mode', 'dark');
            toggleIcon.src = 'https://cdn-icons-png.flaticon.com/512/169/169367.png';
            toggleText.textContent = 'Light Mode';
        } else {
            localStorage.setItem('mode', 'light');
            toggleIcon.src = 'https://cdn-icons-png.flaticon.com/512/169/169367.png';
            toggleText.textContent = 'Dark Mode';
        }
    });

    const existingToggle = document.querySelector('.toggle-button');
    if (existingToggle) {
        existingToggle.remove(); // Remove existing toggle button if any
    }

    document.body.appendChild(toggleButton);

    if (mode === 'dark') {
        body.classList.add('dark-mode');
        toggleIcon.src = 'https://cdn-icons-png.flaticon.com/512/169/169367.png';
        toggleText.textContent = 'Light Mode';
    }
});
