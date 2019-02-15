import postApi from './../../api/post'

const state = {
  all: []
}

const getters = {}

const actions = {
  getPosts ({ dispatch, commit }, route) {
    postApi.getPosts(route).then(posts => {
      commit('setPosts', posts)
    }).catch((error) => {
      console.log(error)
    })
  }
}

const mutations = {
  setPosts (state, posts) {
    state.all = posts
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
