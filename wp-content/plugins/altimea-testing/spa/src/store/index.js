import Vue from 'vue'
import Vuex from 'vuex'
import posts from './modules/posts'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    message: {
      type: null,
      text: '',
      display: true
    }
  },
  modules: {
    posts
  },
  mutations: {
    setMessage (state, { type, text, display }) {
      state.message.type = type
      state.message.text = text
      state.message.display = display

      setTimeout(() => {
        state.message.type = null
        state.message.text = ''
        state.message.display = false
      }, 3000)
    }
  },
  actions: {
    setMessage (context, { type, text, display }) {
      context.commit('setMessage', { type, text, display })
    }
  }
})
