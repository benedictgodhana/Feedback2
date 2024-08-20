<template>
    <div class="page-not-found">
          <h1 class="title">404</h1>
      <p class="message">Oops! The page you’re looking for doesn’t exist.</p>
      <a href ="/" class="back-link">Go back to Home</a>
    </div>
  </template>

  <script>
  export default {
    name: 'PageNotFound',
  }
  </script>

  <style scoped>
  .page-not-found {
    text-align: center;
    padding: 50px;
  }

  .not-found-image {
    max-width: 100%;
    height: auto;
  }

  .title {
    font-size: 72px;
    margin: 20px 0;
  }

  .message {
    font-size: 24px;
    margin-bottom: 30px;
  }

  .back-link {
    color: #42b983;
    font-size: 18px;
    text-decoration: none;
  }
  </style>
