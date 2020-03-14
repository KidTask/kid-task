const APIURL = 'http://localhost:3000';
const axios = require('axios');
export const getTasks = () => axios.get(`${APIURL}/tasks`);
export const addTask = (data) => axios.post(`${APIURL}/tasks`, data);
export const editTask = (data) => axios.put(`${APIURL}/tasks/${data.id}`, data);
export const deleteTask = (id) => axios.delete(`${APIURL}/tasks/${id}`);