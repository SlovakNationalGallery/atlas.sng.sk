import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import axios from 'axios'

export const useItemStore = defineStore('ItemStore', {
    state: () => ({
        items: useStorage('items', {}),
        collectionLink: useStorage('collectionLink', null),
        viewedIds: useStorage('item.viewedIds', []),
    }),
    getters: {
        viewedCount() {
            return this.viewedIds.length
        },
    },
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
        addViewed(id) {
            if (!this.viewedIds.includes(id)) {
                this.viewedIds.unshift(id)
                this.clearCollectionLink()
            }
        },
        clearCache() {
            this.items = {}
        },
        async getCollectionLink() {
            if (this.collectionLink) {
                return this.collectionLink
            } else {
                const response = await axios
                    .post('/api/collections', {
                        items: this.viewedIds,
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
            this.viewedIds = (await axios.get(`/api/collections/${collectionId}`)).data
        },
    },
})
