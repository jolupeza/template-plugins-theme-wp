import Vue from 'vue'
import Router from 'vue-router'
import AppQuickSearch from './components/AppQuickSearch'
import AppCustomSearch from './components/AppCustomSearch'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/quick',
      name: 'QuickSearch',
      component: AppQuickSearch
    },
    {
      path: '/advanced',
      name: 'CustomSearch',
      component: AppCustomSearch
    }
  ]
})

/*
{
      path: '*',
      redirect: { name: 'QuickSearch' }
    }
 */
