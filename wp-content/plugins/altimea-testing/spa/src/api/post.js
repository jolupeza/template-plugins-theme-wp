import axios from 'axios'

export default {
  wpPosts: [],
  error: [],
  wpData: window.wpData,
  restURL: window.wpData.rest_url,
  postsPerPage: 100,
  namespace: 'wp/v2',
  fields: 'id,title,link,vue_meta',
  async getPosts (route = 'posts') {
    try {
      const response = await axios(
        `${this.restURL}/${this.namespace}/${route}?per_page=${this.postsPerPage}&page=1&_fields=${this.fields}`
      )

      this.wpPosts = response.data

      const wpTotalPages = Math.ceil(
        response.headers['x-wp-total'] / this.postsPerPage
      )

      const promises = []
      for (let page = 2; page <= wpTotalPages && page <= 10; page++) {
        promises.push(
          axios(`${this.restURL}/${this.namespace}/${this.route}?per_page=${this.postsPerPage}&page=${page}&_fields=${this.fields}`)
        )
      }

      const wpData = await Promise.all(promises)
      wpData.map(post => this.wpPosts.push(...post.data))

      return this.wpPosts
    } catch (error) {
      this.error = error
      return this.error
    }
  }
}
