import { createApp } from 'vue';
import App from './App.vue';
import './assets/styles/global.css';

import axios from './plugins/axios';

// アプリケーションインスタンスを作成
const app = createApp(App);

// グローバルプロパティとしてaxiosを登録
app.config.globalProperties.$axios = axios;

// アプリケーションをマウント
app.mount('#app');
