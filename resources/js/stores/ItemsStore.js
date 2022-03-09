import { defineStore } from 'pinia'

export const useItemsStore = defineStore('ItemsStore', {
  state: () => ({
    items: []
  }),
  getters: {
    postsCount() {
      console.log(this.items)
      return this.items.length
    },
  },
  actions: {
    // @todo addItem()
  },
})