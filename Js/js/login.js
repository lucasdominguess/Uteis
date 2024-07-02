
// Verifique se há uma mensagem na URL
const params = new URLSearchParams(window.location.search);
const msg = params.get('msg');

if (msg) {
    const dados = JSON.parse(decodeURIComponent(msg));
    let icon = dados['status'] == 'fail' ? 'error' : 'success'
    let title = dados['msg'] 

    Swal.fire({
        icon: icon,
        // icon : status === 'fail' ? 'error',
        title: title,
        // text: msg1
    });
}
