import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#f7733d',
                secondary: '#424242',
            }
        }
    },
    icons: {
        iconfont: 'mdi',

    }
});
