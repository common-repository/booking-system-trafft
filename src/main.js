import './assets/css/main.scss'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import VueScreen from 'vue-screen'
import TrafftDesignSystemPlugin from 'trafft-design-system'
import 'trafft-design-system/styles.css'

const font = new FontFace(
  "Inter Var",
  `url(${trafft_plugin.url}assets/fonts/inter/Inter-Variadble.woff2) format("woff2 supports variations"),
  url(${trafft_plugin.url}assets/fonts/inter/Inter-Variable.woff2) format("woff2-variations")`,
  {
      weight: "100 900",
  },
);

font.load().then(function(loaded_face) {
  document.fonts.add(loaded_face);
}).catch(function(error) {
  console.log(error)
});

const app = createApp(App)

app.config.globalProperties.$trafft_img_url = trafft_plugin.url + '/assets/img'

app.use(router)
app.use(VueScreen, {
    grid: {
        mobile: 0,
        tablet: 782,
        desktop: 1024,
        breakpoint: 'mobile',
        tabletOnly: grid => !grid.desktop && grid.tablet,
        mobileOnly: grid => !grid.tablet,
    },
})
app.use(TrafftDesignSystemPlugin)

app.mount('#trafft-wordpress-plugin')
