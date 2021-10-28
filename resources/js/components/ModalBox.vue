<template>
  <b-modal :active.sync="isModalActive" has-modal-card  @hide="hide">
    <div class="modal-card">
      <section class="modal-card-body">
        <slot></slot>
      </section>

    </div>
  </b-modal>
</template>

<script>
export default {
  name: 'ModalBox',
  props: {
    isActive: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      isModalActive: false
    }
  },
  watch: {
    isActive (newValue) {
      this.isModalActive = newValue
    },
    isModalActive (newValue) {
      if (!newValue) {
        this.hide()
      }
    }
  },
  methods: {
    hide () {
      this.$emit('hideModal')
    }
  }
}
</script>
