import Nav from './dashboard/navigation/Nav.vue'
import Login from './dashboard/login/Login.vue'
import Register from './dashboard/register/Admin.vue'
import Dashboard from './dashboard/Body.vue'

export const routes = [{
    path: '/admin',
    component: Dashboard,
    children: [{
        path: 'login',
        component: Login
      },
      {
        path: 'register',
        component: Register
      },
      {
        path: '*',
        redirect: '/admin'
      },
    ]
  }, {
    path: '/login',
    component: Login
  },
  {
    path: '/test',
    component: Nav
  }
]