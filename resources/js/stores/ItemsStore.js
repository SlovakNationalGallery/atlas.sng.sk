import { defineStore } from 'pinia';

export const useItemsStore = defineStore('ItemsStore', {
    state: () => ({
        items: [],
    }),
    getters: {
        itemsCount() {
            return this.items.length;
        },
    },
    actions: {
        add(item) {
            if (!this.items.includes(item)) {
                this.items.push(item);
            }
        },
        remove(item) {
            this.items = this.items.filter((i) => i !== item);
        },
    },
});