<template>
  <div class="container">
    <h6 class="text-center mb-4">Select a Post Type:</h6>

    <!-- CPT Filters -->
    <app-filter-switches
      :app-filters="wpCustomPostType"
      filter-type="radio"
      @onFilterToggle="cptSelected = $event"
    />

    <!-- Search Box -->
    <div class="input-group my-4">
      <input
        v.model.lazy="searchTerm"
        type="text"
        class="form-control p-2"
        placeholder="Search"
        aria-label="Search">
      <div class="input-group-append">
        <button
          class="btn btn-outline-dark"
          type="button"
          @click="fetchData">Submit</button>
      </div>
    </div>

    <!-- Taxonomy Filters -->
    <app-filter-switches
      :app-filters="wpCategories"
      @onFilterToggle="taxFilters = $event"
    />

    <app-message />

    <!-- AppGetPosts Component -->
    <app-get-posts
      :search-term="searchTerm"
      :app-filters="taxFilters"
      :route="cptSelected"
      :fetch-now="fetchNow"
    />
  </div>
</template>

<script>
import AppFilterSwitches from './AppFilterSwitches'
import AppGetPosts from './../views/AppGetPosts'
import AppMessage from './Message/AppMessage'

export default {
  components: {
    AppFilterSwitches,
    AppMessage,
    AppGetPosts
  },
  data () {
    return {
      cptSelected: 'posts',
      searchTerm: '',
      fetchNow: 0,
      taxFilters: [],
      wpCategories: window.wpData.post_categories.map(term => term.toLowerCase()),
      wpCustomPostType: [ 'posts', 'sample-cpt-events', 'sample-cpt-videos' ]
    }
  },
  methods: {
    fetchData () {
      this.fetchNow++
    }
  }
}
</script>

<style scoped>

</style>
