<template>
  <div class="container">
    <div class="input-group my-4">
      <input
        type="text"
        v-model.lazy="searchTerm"
        class="form-control p-2"
        placeholder="search titles or excerpt for ..."
        aria-label="Search">
      <div class="input-group-append">
        <span class="input-group-text bg-light">Search</span>
      </div>
    </div>

    <app-message />

    <app-filter-switches
      :app-filters="wpCategories"
      @onFilterToggle="categoryFilter = $event" />
    <app-get-posts
      :search-term="searchTerm"
      :app-filters="categoryFilter"></app-get-posts>
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
      searchTerm: '',
      categoryFilter: [],
      wpCategories: window.wpData.post_categories.map(term => term.toLowerCase())
    }
  }
}
</script>

<style scoped>
  .switch {
    position: relative;
    display: inline-block;
    height: 24px;
  }
  .switch .category-toggle {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 50px;
    background-color: #eee;
    -webkit-transition: 0.4s;
    transition: 0.4s;
  }
  .switch .label {
    display: inline-block;
    margin: 0 20px 0 30px;
    font-weight: 400;
  }
  .switch .category-toggle:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.1s;
    transition: 500ms;
  }
  .switch input:checked + .category-toggle {
    background-color: #42b883;
  }
  .switch input:checked + .category-toggle:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
</style>
