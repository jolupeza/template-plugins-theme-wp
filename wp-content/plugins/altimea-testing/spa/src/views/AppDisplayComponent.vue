<template>
  <div>
    <div v-for="post in postData" :key="post.id">
      {{ post.title.rendered }}
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      postData: [],
      wpData
    }
  },
  mounted () {
    fetch(`${this.wpData.rest_url}/wp/v2/posts`)
      .then((response) => response.json())
      .then((data) => { this.postData = data })
  }
}
</script>
