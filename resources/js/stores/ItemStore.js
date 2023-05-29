import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import axios from 'axios'
import { useInteractionStore } from './InteractionStore'

export const useItemStore = defineStore('ItemStore', {
    state: () => ({
        items: useStorage('items', {}),
        collectionLink: useStorage('collectionLink', null),
    }),
    actions: {
        get(id) {
            if (id in this.items) {
                return this.items[id]
            }
        },
        async load(id) {
            const response = await axios.get(`/api/items/${id}`)
            return (this.items[id] = response.data.data)
        },
        clearCollectionLink() {
            this.collectionLink = null
        },
        clearCache() {
            this.items = {}
        },
        async getCollectionLink() {
            const interactionStore = useInteractionStore()

            if (this.collectionLink) {
                return this.collectionLink
            } else {
                const response = await axios
                    .post('/api/collections', {
                        items: [...interactionStore.viewedItemIds],
                    })
                    .catch((err) => {
                        console.log(err)
                    })
                const collectionLink = response.data.url
                this.collectionLink = collectionLink
                return collectionLink
            }
        },
        async fetch(collectionId) {
            this.clearCollectionLink()
            this.items = {}
            // todo
            // this.viewedIds = (await axios.get(`/api/collections/${collectionId}`)).data
        },
    },
})
