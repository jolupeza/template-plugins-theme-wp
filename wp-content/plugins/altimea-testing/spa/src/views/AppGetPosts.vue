<template>
  <div v-if="isDataAvailable" class="container">
    <small v-if="filteredResults.length === wpPosts.length">
      {{ wpPosts.length }}
    </small>
    <small v-else>
      Found {{ filteredResults.length }} of {{ wpPosts.length }}
    </small>

    <div class="card-group">
      <app-display-post
        v-for="postType in filteredResults"
        :key="postType.id"
        :search-term="searchTerm"
        :post-type="postType"
        role="article"></app-display-post>
    </div>
  </div>
  <div v-else>
    <p class="text-center" v-html="apiResponse"></p>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import AppDisplayPost from './AppDisplayPost'

export default {
  components: {
    AppDisplayPost
  },
  props: {
    searchTerm: {
      type: String,
      default: ''
    },
    appFilters: {
      type: Array,
      default: null
    },
    route: {
      type: String,
      default: 'posts'
    },
    fetchNow: {
      type: Number,
      default: 1
    }
  },
  data () {
    return {
      apiResponse: '',
      wpData: window.wpData,
      isDataAvailable: false
    }
  },
  computed: {
    ...mapState('posts', {
      wpPosts: state => state.all
    }),
    filteredResults () {
      let filteredPosts = []

      if (this.wpPosts) {
        const pattern = new RegExp(this.searchTerm, 'i')
        filteredPosts = this.wpPosts.filter(post => {
          return (
            post.title.rendered.match(pattern) ||
            post.vue_meta.custom_excerpt.match(pattern)
          )
        })

        if (this.appFilters && this.appFilters.length) {
          return filteredPosts.filter(post => post.vue_meta.terms.some(
            terms => this.appFilters.includes(terms.toLowerCase()))
          )
        }
      }

      return filteredPosts
    }
  },
  watch: {
    fetchNow: 'fetchData'
  },
  mounted () {
    this.fetchData()
  },
  methods: {
    fetchData () {
      if (this.fetchNow > 0) {
        this.apiResponse = ' Loading ⏳'

        this.$store.dispatch('posts/getPosts', this.route).then(() => {
          setTimeout(() => {
            this.isDataAvailable = true
          }, 2000)
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
