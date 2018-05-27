import Nav from './dashboard/navigation/Nav.vue'
import Login from './dashboard/login/Login.vue'
import Register from './dashboard/register/Admin.vue'
import Dashboard from './dashboard/Body.vue'
import Dashboard_home from './dashboard/home/Home.vue'
import Pluginshome from './dashboard/plugins/Pluginshome.vue'
import Pluginsmain from './dashboard/plugins/pluginpages/Pluginsmain.vue'
import Adminusers from './dashboard/plugins/pluginpages/Adminusers.vue'

export const routes = [{
    path: '/admin/login',
    component: Login,
  },
  {
    path: '/admin/register',
    component: Register,
  },
  {
    path: '/dashboard',
    component: Dashboard,
    children: [{
        path: 'home',
        component: Dashboard_home
      },
      {
        path: 'plugins',
        component: Pluginshome,
        children: [{
            path: 'home',
            component: Pluginsmain
          },
          {
            path: 'adminusers',
            component: Adminusers
          },
          {
            path: '/',
            redirect: 'home'
          }
        ]
      },
      {
        path: '/dashboard/*',
        redirect: '/dashboard/home'
      }

    ]
  },
  {
    path: '*',
    redirect: '/admin/login'
  },

]