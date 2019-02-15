<template>
    <transition name="custom-classes-transition" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
      <aside v-if="message.display" class="Message">
        <div class="alert" :class="[message.display ? 'alert-' + message.type : '']">{{ message.text }}</div>
      </aside>
    </transition>
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState({
      message: state => state.message
    })
  }
}
</script>

<style scoped>

</style>
