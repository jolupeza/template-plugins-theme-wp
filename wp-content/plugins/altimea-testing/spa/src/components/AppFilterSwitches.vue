<template>
  <div class="input-filters text-md-center mx-auto mb-2">
    <div
      v-for="(filter, index) in appFilters"
      :key="`${filterType}_${filter}_${index}`"
      class="toggle-container d-inline-block mb-2">
      <label
        :for="`${filterType}_${filter}_${index}`"
        class="toggle-switch mx-2">
        <input
          :id="`${filterType}_${filter}_${index}`"
          :name="filter"
          :value="filter"
          :type="filterType"
          v-model="inputFilter" />
        <span class="filter-toggle"></span>
        <span class="label">{{ filter }}</span>
      </label>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    appFilters: {
      type: Array,
      default: null
    },
    filterType: {
      type: String,
      default: 'checkbox'
    }
  },
  data () {
    return {
      inputFilter: []
    }
  },
  watch: {
    inputFilter (filter) {
      this.$emit('onFilterToggle', filter)
    }
  }
}
</script>

<style scoped>
  .toggle-container {
    line-height: 1.3;
  }
  .toggle-switch {
    position: relative;
    display: inline-block;
    height: 24px;
  }
  .toggle-switch .filter-toggle {
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
  .toggle-switch .label {
    display: inline-block;
    margin: 0 20px 0 45px;
    font-weight: 400;
  }
  .toggle-switch .filter-toggle:before {
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
  .toggle-switch input:checked + .filter-toggle {
    background-color: #42b883;
  }
  .toggle-switch input:checked + .filter-toggle:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
</style>
