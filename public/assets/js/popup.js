// Global variables
const popup = document.getElementById('project-popup');
const closeButton = document.getElementById('close-popup');
const triggerButton = document.getElementById('popup-trigger');
const navigation = document.getElementById('navigation-sticky');

// Event listener for the trigger button to show the popup
triggerButton.addEventListener('click', (e) => {
    e.preventDefault();
    popup.style.display = 'block';
    navigation.style.position = 'static';
});

// Event listener for the close button to hide the popup anc continue in the website
closeButton.addEventListener('click', (e) => {
    e.preventDefault();
    popup.style.display = 'none';
    navigation.style.position = 'sticky';
});
