// api.js

import axios from 'axios';

const baseURL = 'http://localhost:8084/api'; // Defina sua URL base da API aqui

const instance = axios.create({
  baseURL,
  headers: {
    'Content-Type': 'application/json'
  }
});

instance.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token'); // Supondo que o token esteja armazenado no localStorage
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

export default instance;
