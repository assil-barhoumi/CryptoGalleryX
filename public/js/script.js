const contactUsButton = document.querySelector('.contact-us-button');
const contactUsSection = document.getElementById('contact-us');

contactUsButton.addEventListener('click', () => {
    contactUsSection.scrollIntoView({ behavior: 'smooth' });
});