<template>
  <div>
    <h1 class="text-center mb-5">Парсинг изображений</h1>
    <form v-on:submit.prevent="submitForm">
      <div class="form-group mb-3">
        <label for="url">Ссылка для парсинга</label>
        <input type="text" class="form-control" id="url" placeholder="Ссылка для парсинга" v-model="form.url">
      </div>
      <div class="form-group mb-3">
        <button class="btn btn-primary">Парсить</button>
      </div>
      <div v-if="message"
           class="alert alert-primary"
           v-bind:class="{ 'alert-primary': !isSuccess && !hasError, 'alert-success': isSuccess , 'alert-danger': hasError}"
           role="alert">
        {{ this.message }}
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'app',
  data(){
    return{
      form: {
        url: '',
      },
      message: '',
      isSuccess: false,
      hasError: false,
    }
  },
  methods:{
    submitForm(){
      this.message = 'Ожидаем...';

      axios.post('/api/v1/parse-image', this.form)
        .then((response) => {
          this.message = response.data.message;
          this.isSuccess = true;
        })
        .catch((error) => {
          this.message = 'Ошибка. Попробуйте позже';
          this.hasError = true;
        });
    }
  }
}
</script>
