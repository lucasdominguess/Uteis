document.getElementById('form_config').addEventListener('submit', function(event) {
    event.preventDefault();


    const formData = new FormData(this);


    fetch('/admin/upload_arquivo', {
        method: 'POST', 
        body: formData
    })
    .then(response => response.json())
    .then(newResponse=> {
     
     
        let icon = newResponse.data.status == 'fail' ? 'error' : 'success' 
        let reload = newResponse.data.status=='fail' ? false : true
      
        let rotas = newResponse.data.location 
        let msg = newResponse.data.msg

        if(icon=='error'){
            fnMensagem(icon,msg)
            
        }else {
            fnMensagem(icon,msg,reload,rotas)
      
        }
        }
      
    )
    .catch(error => {
       
        console.error('Erro:', error);
    });
});

// buscando arquivos da pasta arquivo 
document.addEventListener("DOMContentLoaded",async ()=>{

    const response = await buscar('/admin/listar_arquivos')



    for(let i =0; i < response.length ; i++ ) { 
        // const num = Math.floor(Math.random() * (1000 - 1) + 1);
        const item = response[i] ; 
        // console.log(item['name'])
        const tr = document.createElement('tr')
        const button = document.createElement('a')
        const button2 = document.createElement('button')
        $(button).text('Download');
        $(button2).text('Excluir');
        button.id = `${item['name']}`;
        button2.id = `${item['id']}`;

        // tr.id = "tr""+num
        tr.innerHTML = `
     
        <td><a id=""</a>${item['name']}</td>
        <td><a id=""</a>${item['type']}</td>
        <td><a id=""</a>${item['folder']}</td>
        
      
        <td><a id=""</a>${item['create_time']}</td>
        
           
        
        
         `
        const td2=document.createElement('td')
        const td3=document.createElement('td')
        td2.append(button)
        td3.append(button2)
        tr.append(td2,td3)
        // $(tr).append(button,button2)
        $("#tb_arq").append(tr)
        $(button).addClass('btn btn-all btn-outline-primary ')
        $(button2).addClass('btn btn-all btn-outline-danger ')
        button.addEventListener('click',requestGETDownload);
        button2.addEventListener('click',confirmExcluir);

        // 
        
    }
    
        // <div>

      
        
        // </div>



});
