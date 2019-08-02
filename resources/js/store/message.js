const state = {
  content: '',
  type: ''
}

const mutations = {
  setContent (state, { content, type, timeout }) {
    state.content = content
    state.type = 'frash-'+type

    if (typeof timeout === 'undefined') {
      timeout = 3000
    }

    setTimeout(() => (state.content = '' ,state.type = ''), timeout)
  },
  setType ( state, type ) {
    state.type = type
  }
}

export default {
  namespaced: true,
  state,
  mutations
}