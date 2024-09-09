<template>
    <v-app>
    <Navbar />


    <v-container fluid>
      <v-row
  class="d-flex align-center justify-center"
  style="background-image: url('/Images/male-worker-answering-telework-phone-call-center-using-audio-headset-microphone-young-man-working-customer-care-disability-friendly-office-handheld-shot-close-up.jpg'); background-size: cover; background-position: center; height: 1000px; margin-top: 20px;background-color: rgba(0, 0, 0, 0.5);"
>
  <v-col
    cols="12"
    md="6"
    class="text-white d-flex flex-column align-center justify-center"
    style="padding: 100px 50px; background-color: rgba(0, 0, 0, 0.5);"
  >
    <v-card-title
      class="text-center mb-5  animated-title"
      style="font-size: clamp(16px, 4vw, 36px); font-weight: bold; line-height: 1.2;"
    >
      #Welcome to the @iLab Feedback System
    </v-card-title>
    <p class="text-center" style="font-size: clamp(14px, 2vw, 18px);">
      Your voice matters. Share your thoughts, experiences, and feedback to help us improve and serve you better.
    </p>
    <br>
    <v-btn class="mt-5" style="text-transform: capitalize;background-color: darkblue;color:white" :href="route('feedback')">Give feedback</v-btn>
  </v-col>
</v-row>




    </v-container>




</v-app>
  </template>

  <script>
  import Navbar from '../Components/Navbar.vue';

  export default {
    components: {
      Navbar,
    },
    data() {
      return {
        signUpMode: false,
        email: '',
        password: '',
      };
    },
    methods: {
      submitForm() {
        // Form submission logic
      },
    },
  };
  </script>

  <style scoped>



  .logo {
    margin-top: 90px;
  }

  .v-card-title {
    font-size: 28px;
  }

  .footer-top {
  background-color: #4CAF50;
  color: white;
  padding: 20px 0;
}

.footer-links {
  list-style-type: none;
  padding: 0;
}

.footer-links li {
  margin-bottom: 10px;
}

.footer-links a {
  color: white;
  text-decoration: none;
  font-size: 14px;
}

.footer-bottom {
  background-color: black;
  padding: 20px 0;
}

.footer-bottom .mdi-icon {
  margin-right: 10px;
}

@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.animated-title {
  animation: fadeInUp 1.5s ease-out;
}

/* Adjust font size for responsiveness */
.v-card-title {
  font-size: 48px;
  font-weight: bold;
  line-height: 1.2;
}

.v-card-title.fade-in-up {
  animation-delay: 0.5s;
}

.text-center.fade-in-up {
  animation-delay: 1s;
}

@media (max-width: 600px) {
  .v-card-title {
    font-size: 24px;
  }

  .text-center {
    font-size: 16px;
  }
}
  </style>
