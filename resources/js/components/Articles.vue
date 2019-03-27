<template>
  <article>
    <h2>Criar artigo</h2>
    <div class="row">
      <div class="col-12">
        <form @submit.prevent="addArticle">
          <div class="form-group">
            <label for="titulo"><strong>Título do Artigo</strong></label>
            <input type="text" class="form-control" id="titulo" placeholder="Insira o título"
            v-model="article.titulo" required>
          </div>
          <div class="form-group">
            <label for="texto"><strong>Texto</strong></label>
            <textarea class="form-control" id="texto" rows="3" v-model="article.texto" required></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info" style="width: 100%;">Postar</button>
          </div>
        </form>
      </div>
    </div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
          <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Anterior</a>
        </li>
        <li class="page-item disabled"><a class="page-link text-dark" href="#">Página {{pagination.current_page}} de {{pagination.last_page}}</a></li>
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
          <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">
          Próximo</a></li>
      </ul>
    </nav>
    <h2>Artigos</h2>
    <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
      <h3>{{article.titulo}}</h3>
      <p>{{article.texto}}</p>
      <button class="btn btn-warning mb-2" @click="editArticle(article)">Editar</button>
      <button class="btn btn-danger" @click="destroyArticle(article.id)">Delete</button>
    </div>
  </article>
</template>
<script>
  export default{
    data(){
      return {
        articles: [],
        article: {id: '', titulo:'',texto: ''},
        article_id: '',
        pagination: {},
        edit: false,
      }
    },
    created(){
      this.fetchArticles();
    },
    methods: {
      fetchArticles(page_url){
        var vm = this;
        var page_url = page_url || 'api/artigo';
        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            this.articles = res.data;
            vm.makePagination(res); // propriedades do paginator
          });
      },
      makePagination(paginator){
        let pagination = {
          current_page: paginator.current_page,
          last_page: paginator.last_page,
          next_page_url: paginator.next_page_url,
          prev_page_url: paginator.prev_page_url,
        }
        this.pagination = pagination;
      },
      // CRUD
      destroyArticle(id){
        if(confirm("Você tem certeza que deseja remover?")){
          fetch(`api/artigo/${id}`,{method:'delete'})
          .then(res => res.json())
          .then(data => {
            alert("Excluído com sucesso");
            this.fetchArticles();
          })
          .catch(error => console.log(error));
        }
      },
      addArticle(){
        if (this.edit === false){
          fetch("api/artigo",{
            method:'post',
            body: JSON.stringify(this.article),
            headers: {
                'Content-type':'content-type/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            })
            .then(res => res.json())
            .then(data => {
              this.article.titulo = "";
              this.article.texto = "";
              alert("Você postou algo incrivel!");
              this.fetchArticles();
            })
            .catch(error => console.log(error));
        }
        else{
          fetch('api/artigo',{
            method:'put',
            body: JSON.stringify(this.article),
            headers: {
                'Content-type':'content-type/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            })
            .then(res => res.json())
            .then(data => {
              this.article.titulo = "";
              this.article.texto = "";
              alert("Uau! O que era bom ficou melhor");
              this.fetchArticles();
            })
            .catch(error => console.log(error));
        }
      },
      editArticle(article){
        this.edit = true;
        this.article.id = article.id;
        this.article.article_id = article.id;
        this.article.texto = article.texto;
        this.article.titulo = article.titulo;

      }
    }
  }
</script>