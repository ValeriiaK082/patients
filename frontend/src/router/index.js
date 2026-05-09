import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Results from '../views/Results.vue'

const routes = [
  { path: '/', component: Login },
  {
    path: '/results',
    component: Results,
    beforeEnter: () => {
      if (!localStorage.getItem('token')) return '/'
    }
  },
]

export default createRouter({ history: createWebHistory(), routes })