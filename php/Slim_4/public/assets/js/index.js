
async function login(form)
{
    let response = await fetch ('/rota-login' , {
        method: 'post',
        body: form
    })

    if (response.status !== 200) {
        return null
    } else {
        let obj = await response.json();
        return obj;
    }
}

document.getElementById('botao_login').addEventListener("click", async ()=> {

    Swal.fire({
        icon: "success",
        title: "Seja bem-vindo(a)!",
        showConfirmButton: false,
        timer: 1500
      });

    // let form = new FormData(document.getElementById('form_login'));
    // let resposta = await login(form);
    // resposta = resposta.data;

    // if(resposta.cod === null) {
    //     // Sweet alert falando para inserir os dados corretamente!
    // }

    // if(resposta.cod === 'ok'){
    //     // Sweet alert falando bem-vinda Nádia
    // }

    // if(resposta.cod === 'fail'){
    //     // Sweet alert falando que aconteceu alguma coisa
    // }
})

const input_senha = document.querySelector("#input_senha");
const eyeBtn = document.querySelector(".eye-btn");

eyeBtn.addEventListener("click", () => {
    if(input_senha.type === "password"){
        input_senha.type = "text";
        eyeBtn.innerHTML = "<i class='uil uil-eye'></i>";
    }
    else {
        input_senha.type = "password";
        eyeBtn.innerHTML = "<i class='uil uil-eye-slash'></i>"
    }
})

document.getElementById('duvidas').addEventListener('click', () => {
    Swal.fire({
        title: "Duvidas?",
        text: "Ligue para: 4002-8922",
        icon: "question"
      });
});

document.getElementById('input_senha').addEventListener('')