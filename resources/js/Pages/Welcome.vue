<template>
    <v-app>
    <Navbar />


    <v-container fluid>
      <v-row
  class="d-flex align-center justify-center"
  style="background-image: url('/Images/male-worker-answering-telework-phone-call-center-using-audio-headset-microphone-young-man-working-customer-care-disability-friendly-office-handheld-shot-close-up.jpg'); background-size: cover; background-position: center; height: 800px; margin-top: 20px;background-color: rgba(0, 0, 0, 0.5);"
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
  </v-col>
</v-row>


      <!-- Popular Links Section -->
      <v-row class="d-flex justify-center" style="background-color:darkblue; padding: 40px 0;">
        <v-col cols="12" md="10">
          <h3 class="text-center" style="color:white">What to share</h3>
          <br>
          <hr>
          <br>
          <v-row>
            <v-col cols="12" md="3">
              <h4  style="color:orange">Ideas</h4>
              <ul class="footer-links">
                <li><a href="#">Tech Innovations</a></li>
    <li><a href="#">Research Proposals</a></li>
    <li><a href="#">Department Improvements</a></li>
    <li><a href="#">Other Suggestions</a></li>
              </ul>
            </v-col>
            <v-col cols="12" md="3">
              <h4 style="color:orange">Feedback</h4>
              <ul class="footer-links">
                <li><a href="#">Complaints</a></li>
                <li><a href="#">Suggestions</a></li>
                <li><a href="#">Compliments</a></li>
                <li><a href="#">Other Feedback</a></li>
              </ul>
            </v-col>
            <v-col cols="12" md="3">
              <h4 style="color:orange">Issues</h4>
              <ul class="footer-links">
                <li><a href="#">Research Assistance</a></li>
    <li><a href="#">Technical Issues</a></li>
    <li><a href="#">Innovation Projects</a></li>
    <li><a href="#">Collaboration Inquiries</a></li>
    <li><a href="#">Other Departmental Issues</a></li>
              </ul>
            </v-col>
            <v-col cols="12" md="3">
              <h4 style="color:orange">Suggestions</h4>
              <ul class="footer-links">
                <li><a href="#">Overall Satisfaction</a></li>
                <li><a href="#">Improvement Areas</a></li>
                <li><a href="#">Suggestions</a></li>
                <li><a href="#">Other Comments</a></li>
              </ul>
            </v-col>
          </v-row>
        </v-col>
      </v-row>

    </v-container>


    <v-footer style="background-color: darkblue" padless>
      <v-container fluid>
        <v-row no-gutters>
          <!-- Footer Top -->
          <v-col cols="12">
            <div class="footer-top elevation-10" style="background-color: orange; color: white; padding: 10px 0;">
              <div class="text-center">
                <h2 style="font-weight: normal;color:black;font-weight:900;font-size: clamp(14px, 4vw,22px);">All feedback submitted will be treated with utmost confidentiality</h2>
              </div>
            </div>
          </v-col>

          <!-- Footer Content -->
          <v-col cols="12">
            <v-container>
              <v-row>
                <v-col cols="12" md="2">
                  <h3 class="white--text" style="color:orange">Feedback</h3>
                  <ul class="footer-links">
                    <li><a :href="route('feedback')" class="white--text">Submit Feedback</a></li>
                    <li><a href="#" class="white--text">Track Feedback</a></li>
                    <li><a href="#" class="white--text">Feedback Guidelines</a></li>
                  </ul>
                </v-col>
                <v-col cols="12" md="2">
                  <h3 class="white--text" style="color:orange">Support</h3>
                  <ul class="footer-links">
                    <li><a href="#" class="white--text">Customer Support</a></li>
                    <li><a href="#" class="white--text">FAQ</a></li>
                    <li><a href="#" class="white--text">Contact Us</a></li>
                    <li><a href="#" class="white--text">Help Center</a></li>
                  </ul>
                </v-col>
                <v-col cols="12" md="2">
                  <h3 class="white--text" style="color:orange">About Us</h3>
                  <ul class="footer-links">
                    <li><a href="#" class="white--text">Our Mission</a></li>
                    <li><a href="#" class="white--text">Our Team</a></li>
                    <li><a href="#" class="white--text">Careers</a></li>
                    <li><a href="#" class="white--text">News & Updates</a></li>
                  </ul>
                </v-col>
                <v-col cols="12" md="2">
                  <h3 class="white--text" style="color:orange">Policies</h3>
                  <ul class="footer-links">
                    <li><a href="#" class="white--text">Privacy Policy</a></li>
                    <li><a href="#" class="white--text">Terms of Service</a></li>
                    <li><a href="#" class="white--text">Data Protection</a></li>
                  </ul>
                </v-col>
                <v-col cols="12" md="2">
                  <h3 class="white--text" style="color:orange">Resources</h3>
                  <ul class="footer-links">
                    <li><a href="#" class="white--text">Documentation</a></li>
                    <li><a href="#" class="white--text">Tutorials</a></li>
                    <li><a href="#" class="white--text">Community</a></li>
                    <li><a href="#" class="white--text">Blog</a></li>
                  </ul>
                </v-col>
                <v-col cols="12" md="2">
                  <h3 class="white--text" style="color:orange">Contact</h3>
                  <ul class="footer-links">
                    <li><a href="#" class="white--text">Email Us</a></li>
                    <li><a href="#" class="white--text">Visit Us</a></li>
                    <li><a href="#" class="white--text">Support Hours</a></li>
                    <li><a href="#" class="white--text">Social Media</a></li>
                  </ul>
                </v-col>
              </v-row>
            </v-container>
          </v-col>

          <!-- Footer Bottom -->
          <v-col cols="12" class="footer-bottom" style="background-color: black; padding: 20px 0;">
            <div class="text-center white--text">
              <v-icon color="white" size="24" class="mx-2">mdi-facebook</v-icon>
              <v-icon color="white" size="24" class="mx-2">mdi-twitter</v-icon>
              <v-icon color="white" size="24" class="mx-2">mdi-linkedin</v-icon>
              <v-icon color="white" size="24" class="mx-2">mdi-instagram</v-icon>
              <v-icon color="white" size="24" class="mx-2">mdi-tiktok</v-icon>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-footer>

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
