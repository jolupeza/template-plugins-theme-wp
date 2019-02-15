<template>
  <div class="card">
    <img v-if="postType.vue_meta.featuredmedia_url"
        :src="postType.vue_meta.featuredmedia_url"
        :alt="postType.vue_meta.featuredmedia_alt || 'post thumbnail'"
        class="card-img-top">
    <div class="card-body">
      <h5 class="card-title text-center">
        <a :href="postType.link">
          <span v-html="highlightedPostTitle || postType.title.rendered"></span>
        </a>
      </h5>
      <p class="card-text">
        <span v-html="highlightedPostExcerpt || postType.vue_meta.custom_excerpt"></span>
      </p>
    </div>
    <div class="card-footer">
      <small class="text-muted">
        <span
          v-if="postType.vue_meta.terms.length"
          v-html="postType.vue_meta.term_links.join(', ')"></span>
      </small>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    postType: {
      type: Object,
      required: true,
      default: null
    },
    searchTerm: {
      type: String,
      required: true,
      default: null
    }
  },
  computed: {
    highlightedPostTitle () {
      if (this.searchTerm) {
        return this.highlightData(this.postType.title.rendered)
      }

      return ''
    },
    highlightedPostExcerpt () {
      if (this.searchTerm) {
        return this.highlightData(this.postType.vue_meta.custom_excerpt)
      }

      return ''
    }
  },
  methods: {
    highlightData (data) {
      if (this.searchTerm) {
        const pattern = new RegExp(this.searchTerm, 'i')
        const highlightedData = data.replace(
          pattern,
          `<span class="hl-search">${this.searchTerm}</span>`
        )

        return highlightedData
      }
    }
  }
}
</script>
<style>
  .card {
    min-width: 33%;
  }
  .card-img-top {
    height: 15vw;
    object-fit: cover;
  }
  .card .hl-search {
    background-color: yellow;
  }
  @media only screen and (max-width: 768px) {
    .card {
      min-width: 50%;
    }
  }
  @media only screen and (max-width: 480px) {
    .card {
      min-width: 100%;
    }
  }
</style>
