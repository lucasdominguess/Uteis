$(document).ready(async ()=>{


    const num = Math.floor(Math.random() * (4 - 1)) + 1;

    const body = document.querySelector('.body_recsenha')
    $(body).css('background-image', `url("/assets/img/back${num}.jpg")`);
});