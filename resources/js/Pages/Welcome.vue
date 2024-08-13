<template>
    <Navbar />
    <div class="container">
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <div class="logo">
              <img
                src="/Images/iLab white Logo-01.png"
                alt="Logo"
                class="logo-image"
              />
            </div>

          </div>
        </div>
        <div class="panel right-panel">
            <v-container><
            <v-card width="100%" max-width="1300" elevation="0">

                <v-toolbar color="white" >
                    <v-card-title style="font-weight: 900;">
                        Welcome to @iLabAfrica Feedback System
                    </v-card-title>
                    <v-spacer></v-spacer>
                    
                </v-toolbar>

                <v-card-text class="text-center">
          <v-row justify="start">
            <v-col cols="12" md="6">
              <v-card class="pa-4" outlined elevation="0" variant="outlined">
                <v-icon size="28">mdi-lightbulb-outline</v-icon>
                <v-card-title class="text-overline">Ideas</v-card-title>
                <v-divider></v-divider>
                <v-list-item
                  lines="two"
                  class="feedback-item"
                  link
                  style="background-color: darkblue;color:white"
                >
                  Share your great ideas with us
                </v-list-item>
              </v-card>
            </v-col>
            <v-col cols="12" md="6">
              <v-card class="pa-4" outlined elevation="0" variant="outlined">
                <v-icon size="28">mdi-comment-check-outline</v-icon>
                <v-card-title class="text-overline">Feedback</v-card-title>
                <v-divider></v-divider>
                <v-list-item
                  lines="two"
                  class="feedback-item"
                  link
                  style="background-color: darkblue;color:white"

                >
                  Provide feedback on your experiences
                </v-list-item>
              </v-card>
            </v-col>
            <v-col cols="12" md="6">
              <v-card class="pa-4" outlined elevation="0" variant="outlined">
                <v-icon size="28">mdi-alert-circle-outline</v-icon>
                <v-card-title class="text-overline">Issues</v-card-title>
                <v-divider></v-divider>
                <v-list-item
                  lines="two"
                  class="feedback-item"
                  link
                  style="background-color: darkblue;color:white"

                >
                  Report any issues you encounter
                </v-list-item>
              </v-card>
            </v-col>
            <v-col cols="12" md="6">
              <v-card class="pa-4" outlined elevation="0" variant="outlined">
                <v-icon size="28">mdi-help-circle-outline</v-icon>
                <v-card-title class="text-overline">Suggestions</v-card-title>
                <v-divider></v-divider>
                <v-list-item
                  lines="two"
                  class="feedback-item"
                  link
                  style="background-color: darkblue;color:white"

                >
                  Share with us your valuable suggestions
                </v-list-item>
              </v-card>
            </v-col>
          </v-row>
          <v-btn width="100%"  color="orange" height="43px" text :href="route('feedback')"  elevation="5" class="mt-16">
            <v-icon color="white" size="23">mdi-email</v-icon>
            <span style="color:white; font-size:17px;text-transform: capitalize;">Give Feedback</span>
          </v-btn>
        </v-card-text>

          </v-card>

</v-container>


        </div>
      </div>
    </div>
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


  .text-content {
    font-size: 18px;
    line-height: 1.6;
    color: #333;
  }

  .content-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px;
  }

  .welcome-text {
    margin-top: 20px;
    color: black;
  }

  .logo-image {
    max-width: 100%;
    height: auto;
    margin-top: 80px;
  }

  .give-feedback-btn {
    margin-top: 290px;
  }

  .home-btn {
    margin-left: 1680px;
    text-decoration: none;
    border: 2px solid;
  }


  .forms-container {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
  }

  .signin-signup {
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
    left: 75%;
    width: 50%;
    transition: 1s 0.7s ease-in-out;
    display: grid;
    grid-template-columns: 1fr;
    z-index: 5;
  }

  .title {
    font-size: 2.2rem;
    color: #444;
    margin-bottom: 10px;
  }

  .input-field input {
    background: none;
    outline: none;
    border: none;
    line-height: 1;
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
  }

  .input-field input::placeholder {
    color: #aaa;
    font-weight: 500;
  }

  .social-text {
    padding: 0.7rem 0;
    font-size: 1rem;
  }

  .social-media {
    display: flex;
    justify-content: center;
  }

  .social-icon {
    height: 46px;
    width: 46px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 0.45rem;
    color: #333;
    border-radius: 50%;
    border: 1px solid #333;
    text-decoration: none;
    font-size: 1.1rem;
    transition: 0.3s;
  }

  .social-icon:hover {
    color: #4481eb;
    border-color: #4481eb;
  }

  .btn {
    width: 380px;
    background-color: darkblue;
    border: none;
    outline: none;
    height: 49px;
    border-radius: 49px;
    color: #fff;
    text-transform: uppercase;
    font-weight: 600;
    margin: 10px 0;
    cursor: pointer;
    transition: 0.5s;
  }

  .btn:hover {
    background-color: green;
  }

  .panels-container {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
  }

  .container:before {
    content: "";
    position: absolute;
    height:100%;
    width: 100%;
    right: 0%;
    transform: translateY(0%);
    background:darkblue;
    transition: 1.8s ease-in-out;
    background-position: contain;
    z-index: 6;
  }

  .image {
    width: 100%;
    transition: transform 1.1s ease-in-out;
    transition-delay: 0.4s;
  }

  .panel {
    align-items: flex-end;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    text-align: center;
    z-index: 9;
  }

  .left-panel {
    padding: 3rem 17% 2rem 12%;
  }

  .right-panel {
    padding: 2rem 12% 12rem 10%;
  }

  .panel .content {
    color:darkblue;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.6s;
    margin-top: -220px;
  }

  .panel h3 {
    font-weight: 600;
    line-height: 1;
    font-size: 1.5rem;
    margin-left: -300px;
  }

  .panel p {
    font-size: 0.95rem;
    padding: 0.7rem 0;
    margin-left: -210px;
  }

  .btn.transparent {
    margin: 0;
    background: none;
    border: 2px solid #fff;
    width: 230px;
    height: 41px;
    font-weight: 600;
    font-size: 0.8rem;
  }

  .right-panel .image,
  .right-panel .content {
    transform: translateX(800px);
  }

  .container.sign-up-mode:before {
    transform: translate(100%, -50%);
    right: 52%;
  }

  .container.sign-up-mode .left-panel .image,
  .container.sign-up-mode .left-panel .content {
    transform: translateX(-800px);
  }

  .container.sign-up-mode .right-panel .image,
  .container.sign-up-mode .right-panel .content {
    transform: translateX(0%);
  }

  .logo {
    margin-top: 90px;
  }

  .v-card-title {
    font-size: 28px;
  }
  </style>
