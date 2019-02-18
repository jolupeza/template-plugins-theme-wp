import postApi from './../../api/post'

const state = {
  all: []
}

const getters = {}

const actions = {
  async getPosts ({ dispatch, commit }, route) {
    const posts = await postApi.getPosts(route)
    if (posts instanceof Error) {
      dispatch(
        'setMessage',
        { type: 'danger', text: posts.response.data.message, display: true },
        { root: true }
      )

      commit('setPosts', [])
      return
    }

    commit('setPosts', posts)
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
