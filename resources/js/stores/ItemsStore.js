import { defineStore } from 'pinia';

export const useItemsStore = defineStore('ItemsStore', {
    state: () => ({
        items: [],
    }),
    getters: {
        itemsCount() {
            return this.items.length;
        },
        exists: (state) => {
            return (itemId) => state.items.includes(itemId)
        },
    },
    actions: {
        add(itemId) {
            if (!this.items.includes(itemId)) {
                this.items.push(itemId);
            }
        },
        remove(itemId) {
            this.items = this.items.filter((item) => item !== itemId);
        },
    },
});