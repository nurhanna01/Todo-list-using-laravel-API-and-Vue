import Vue from "vue";
import App from "./App.vue";

import router from "./router/index";

//import axios
import axios from "axios";

import "bootstrap/dist/css/bootstrap.css";
import "jquery/dist/jquery.min";
import "popper.js/dist/popper.min";
import "bootstrap/dist/js/bootstrap.min";

/* add fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core";

/* add some free styles */
import {
  faUser,
  faHome,
  faUserGear,
  faPowerOff,
  faPlus,
} from "@fortawesome/free-solid-svg-icons";

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

Vue.component("font-awesome-icon", FontAwesomeIcon);

library.add(faUser, faHome, faUserGear, faPowerOff, faPlus);

//set credential axios with true
axios.defaults.withCredentials = true;

Vue.config.productionTip = false;

new Vue({
  // register router
  router,
  render: (h) => h(App),
}).$mount("#app");
