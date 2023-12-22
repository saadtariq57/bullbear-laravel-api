export default {
  props: {
    showModal: {
      type: Boolean,
      default: false,
    },
    data: undefined
  },
  methods: {
    closeModal(type) {
      this.$emit('action-performed', { type: type, id: this.data.id});
    },
  },
};