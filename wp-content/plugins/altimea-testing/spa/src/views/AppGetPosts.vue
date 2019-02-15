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
import axios from 'axios'
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
    },
    async getPosts (route = 'posts', namespace = 'wp/v2') {
      try {
        const postsPerPage = 100
        const restURL = this.wpData.rest_url
        const fields = 'id,title,link,vue_meta'

        const response = await axios(
          `${restURL}/${namespace}/${route}?per_page=${postsPerPage}&page=1&_fields=${fields}`
        )

        this.wpPosts = response.data
        this.isDataAvailable = true

        /*
        * calculate total number of required API requests using the header fields from the response.
        *
        * headers['x-wp-total']: Total WordPress Posts
        * headers['x-wp-totalpages'] Total number of pages based on the per_page param.
        */
        const wpTotalPages = Math.ceil(
          response.headers['x-wp-total'] / postsPerPage
        )

        const promises = []
        for (let page = 2; page <= wpTotalPages && page <= 10; page++) {
          promises.push(
            axios(`${restURL}/${namespace}/${route}?per_page=${postsPerPage}&page=${page}&_fields=${fields}`)
          )
        }

        const wpData = await Promise.all(promises)
        wpData.map(post => this.wpPosts.push(...post.data))
      } catch (error) {
        this.apiResponse = ` The request could not be processed! <br> <strong>${error.response.data.message}</strong> `
        this.isDataAvailable = false
        this.$store.dispatch('setMessage', { type: 'danger', text: error.response.data.message, display: true })
      }
    }
  }
}
</script>

<style scoped>

</style>
