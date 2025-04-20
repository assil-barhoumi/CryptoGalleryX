document.addEventListener('DOMContentLoaded', () => {
const images = [
    '/images/background.jpg',
    '/images/background2.jpg',
    '/images/background3.jpg',
    '/images/background4.jpg',
    '/images/background5.jpg'
];
let currentImageIndex = 0;

const changeBackgroundImage = () => {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    const tempImage = new Image();   //précharger l'image avant de l'utiliser,transition fluide
    tempImage.onload = () => {  //une fois l img chargee elle definit l img de fond ,onload: événement associé aux obj Image
    document.body.style.backgroundImage = `url(${images[currentImageIndex]})`;
    }
    tempImage.src = images[currentImageIndex];    //declenche chargement. la source de l'image, cad l'URL de l'image à charger. 
};
changeBackgroundImage();
setInterval(changeBackgroundImage, 3000); 
//clearInterval
});