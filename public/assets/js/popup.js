// Global variables
const popup = document.getElementById('project-popup');
const closeButton = document.getElementById('close-popup');
const triggerButton = document.getElementById('popup-trigger');
const navigation = document.getElementById('navigation-sticky');

// For the first time, create the sessionStorage item
if (sessionStorage.getItem('popupShown') === null) {
    sessionStorage.setItem('popupShown', 'false');
}

// Event listener for the trigger button to show the popup
triggerButton.addEventListener('click', (e) => {
    e.preventDefault();
    popup.style.display = 'block';
    navigation.style.position = 'static';
    sessionStorage.setItem('popupShown', 'false');
});

// Event listener for the close button to hide the popup anc continue in the website
closeButton.addEventListener('click', () => {
    popup.style.display = 'none';
    navigation.style.position = 'sticky';
    sessionStorage.setItem('popupShown', 'true');
});

// If the popup has not been shown yet, show it, else hide it
if (sessionStorage.getItem('popupShown') === 'false') {
    popup.style.display = 'block';
    navigation.style.position = 'static';
} else {
    const popup = document.getElementById('project-popup');
    popup.style.display = 'none';
    navigation.style.position = 'sticky';
}
