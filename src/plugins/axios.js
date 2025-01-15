import axios from 'axios';

// Axiosのインスタンスを作成
const instance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // LaravelのAPIのベースURL
  headers: {
    'Content-Type': 'application/json',
  },
});

export default instance;
