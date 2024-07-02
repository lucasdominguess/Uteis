// import _, { map } from 'https://cdn.jsdelivr.net/npm/underscore@1.13.6/underscore-esm-min.js'


//construindo header de tabela dinamicamente 
function tH(keys) {
        keys.push('Editar')
        keys.push('Excluir')
        let h1 =document.createElement('h1');
        // h1.innerText='Tabela de Cadastrados'
        h1.id = 'h1_table'
    
        let table1 = document.createElement('table');
        
        let thead = document.createElement('thead');
        let tr = document.createElement('tr');
        thead.append(tr);
        table1.append(thead);
        let tbody = document.createElement('tbody');
        table1.append(tbody);
        let tag = document.querySelector('.htmlpags').id
        // table1.id =`table_${tag}`;
        table1.id ="table1";
        $(`#sessao_tabela`).append(table1,h1);
      
  
        
       
        for (let index = 0; index < keys.length; index++) {
            const element = keys[index];
            const tH = document.createElement('th');
            tH.innerText = element;
            
            tr.append(tH);
        }
            //adcionando tabela ao local exato do html
            // $(`#sessao_tabela_${tag}`).append(table1);
            $("#sessao_tabela").append(table1);
    
            $(table1).append(thead) ;
            $(table1).append(tbody) ;

            $(h1).addClass('h1s titletable'); 
            $('th').addClass('labelPerso'); 
            $(table1).addClass('table table-striped table-hover table-responsive')
            // $(table1).css('wigth','100%')
           
            $(tbody).addClass('tbody');
           
         
    };
// Construindo body de tabela dinamicamente
function arrumar(obj){      

  
  
        const values = Object.values(obj)
        // console.log(values)

        const tr = document.createElement('tr'); 
        for (let i = 0; i < values.length; i++) {  
            const el = values[i];
            const td = document.createElement('td'); 
            td.innerText = el
            tr.append(td);
            // tr.append(button)
            
        }
        const button = document.createElement('button')
        const button2 = document.createElement('button')
        
        
        $(button).addClass('btn btn-all btn-primary btn-sm ')
        $(button2).addClass('btn btn-all btn-danger btn-sm')
        
        $(button).text('Editar')
        $(button2).text('Excluir')
        button.id = values[0]
        button2.id = values[0]
        tr.id = 'tr'+values[0]  //atribuindo Id + valor passado no loop
      
  
    const td2=document.createElement('td')
    const td3=document.createElement('td')
    td2.append(button)
    td3.append(button2)
    tr.append(td2,td3)

  
    
    $('.tbody').append(tr);
    
    //evento botao de editar 
  
    button.addEventListener('click',requestGET);
    button2.addEventListener('click',confirmExcluir);
};
// buscando cards de usuarios pelo input 
function montar(obj)
{
    // console.log(obj)
    for (let i = 0; i < obj.length; i++) {
        const el = obj[i];
        let li = document.createElement('li');
        li.id = 'liPerso'                                    //onmouseover="fntest(this)
        li.innerHTML = `
        <div id="div_${el.id}" class="card cardPerso fadeIn">
            <div class="row" >
                <p><span class="spanPerso">Nome:&nbsp;&nbsp;</span>${el.nome}</p>
                <p><span class="spanPerso" >Nascimento:&nbsp;&nbsp;</span>${el.data_nascimento}</p>
                <div class="col-6 form-group">
                    <p><span class="spanPerso">CPF:&nbsp;&nbsp;</span>${el.cpf}</p>
                </div>
                <div class="col-6 form-group">
                    <p><span class="spanPerso">CEP:&nbsp;&nbsp;</span>${el.cep}</p>
                </div>
                <div class='div_btn '>
                <button id="${el.id}" type="button" class="btnEdit btn btn-outline-primary">Editar</button>
                <button id="btn2-${el.id}" class="btn btn-outline-danger">Excluir</button>
                </div>
                
            </div>
    </div>`
        

        $("#ul_cardlist").append(li)
          
        btnEdits('.btnEdit')
    }
}
    function btnEdits(key){
         $(key).click(function (e) {
         btn_editar(`${e.target.id}`)
        
   
}); 
}



async function buscarCard(v)
{
    let resposta = await fetch(`http://localhost:9000/listarcards?name=${v}`);
    
    let obj = await resposta.json()
    console.log(obj.data)
    console.log(obj.data.msg)
    if(!obj.data.length){
        setTimeout(
        msgErro(obj.data.msg),2500)
    }
    return obj.data
}

$("#ipt_search").on('input',_.throttle(async (e)=>{
    let v = e.target.value;
   console.log(v)
    if (v.length <= 3) {
        $("#ul_cardlist").html('')
    }else if (v.length > 3) {
        let res = await buscarCard(v)
        $("#ul_cardlist").html('')
        montar(res);
    }
},1200))
