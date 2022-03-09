import { defineStore } from 'pinia'

export const useItemsStore = defineStore('ItemsStore', {
  state: () => ({
    items: []
  }),
  getters: {
    itemsCount() {
      return this.items.length
    },
  },
  actions: {
    // @todo addItem()
  },
})