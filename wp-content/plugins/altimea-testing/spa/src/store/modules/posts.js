import postApi from './../../api/post'

const state = {
  all: []
}

const getters = {}

const actions = {
  async getPosts ({ dispatch, commit }, route) {
    const posts = await postApi.getPosts(route)
    return new Promise((resolve, reject) => {
      if (posts instanceof Error) {
        commit('setPosts', [])
        reject(posts)
        return
      }

      commit('setPosts', posts)
      resolve()
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
