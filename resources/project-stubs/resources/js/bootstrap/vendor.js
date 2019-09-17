import axios from 'axios'
import lodash from 'lodash'
import moment from 'moment'
import Vue from 'vue'

window._ = lodash
window.axios = axios
window.moment = moment
window.Vue = Vue

/*
 * Axios
 */

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
