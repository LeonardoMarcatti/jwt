$('#home').on('click', function(){
    showHomePage();
    setTimeout(() => {
        getCategorias();
    }, 100);

     $('#response').html('');
});

$(document).on('change', '#categoria', function (p) { 
    if (p.target.value != 0) {
       let id = p.target.value;
       $.ajax({
           type: "get",
           url: "https://api.mercadolibre.com/categories/" + id,
           data: null,
           success: function (response) {
               let card = `<div class="card col-6 offset-3">
               <img src="${response.picture}" class="card-img-top" alt="Foto da categoria">
               <div class="card-body">
                 <h5 class="card-title">${response.name}</h5>
                 <h6 class="card-text">Qte. ítens:</h6>
                 <p>${(response.total_items_in_this_category).toLocaleString('pt')}</p>
               </div>`;
               card += `<div class="card-body">
               <a href="${response.permalink}" class="card-link" >Link da Categoria</a>
                    </div>
                </div>`;
                $('#card').html(card);
                response.children_categories.forEach(element => {
                    gravaSubcategoria({'id_mae': response.id, element});
                });
           },
           complete: () =>  {}
       });       
    };
 });

 function gravaSubcategoria(p) {
     $.ajax({
        type: "post",
        url: "../create_subcategoria.php",
        data: JSON.stringify(p),
        success: function (response) {
          
        }
    });
 }