import { defineStore } from 'pinia'
import axios from 'axios'

export const useSharedCollectionStore = defineStore('SharedCollectionStore', {
    state: () => ({
        itemsIds: [],
    }),
    actions: {
        async fetch(collectionId) {
            this.itemsIds = (await axios.get(`/api/collections/${collectionId}`)).data
        },
    },
})
