// https://vue-feather-icons.netlify.com/

import * as icons from 'vue-feather-icons'

for (let key in icons) {
    Vue.component(key, icons[key])
}
