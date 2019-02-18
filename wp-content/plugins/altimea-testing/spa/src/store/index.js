import Vue from 'vue'
import Vuex from 'vuex'
import posts from './modules/posts'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    message: {
      type: null,
      text: '',
      display: false,
      fixed: false
    }
  },
  modules: {
    posts
  },
  mutations: {
    setMessage (state, { type, text, display, fixed }) {
      state.message.type = type
      state.message.text = text
      state.message.display = display
      state.message.fixed = fixed

      if (!fixed) {
        setTimeout(() => {
          this.commit('clearMessage')
        }, 3000)
      }
    },
    clearMessage (state) {
      state.message.type = null
      state.message.text = ''
      state.message.display = false
      state.message.fixed = false
    }
  },
  actions: {
    setMessage (context, { type, text, display, fixed }) {
      context.commit('setMessage', { type, text, display, fixed })
    },
    clearMessage (context) {
      context.commit('clearMessage')
    }
  }
})
