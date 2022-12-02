import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import axios from 'axios'

export const useItemStore = defineStore('ItemStore', {
    state: () => ({
        favouriteItemIds: useStorage('favouriteItemIds', []),
        items: useStorage('items', {}),
        collectionLink: useStorage('collectionLink', null),
    }),
    getters: {
        favouritesCount() {
            return this.favouriteItemIds.length
        },
    },
    actions: {
        get(id) {
            if (id in this.items) {
                return this.items[id]
            }
        },
        isFavourite(id) {
            return this.favouriteItemIds.includes(id)
        },
        async load(id) {
            const response = await axios.get(`/api/items/${id}`)
            return (this.items[id] = response.data.data)
        },
        clearCollectionLink() {
            this.collectionLink = null
        },
        addFavourite(id) {
            if (!this.favouriteItemIds.includes(id)) {
                this.favouriteItemIds.push(id)
                this.clearCollectionLink()
            }
        },
        removeFavourite(id) {
            this.favouriteItemIds = this.favouriteItemIds.filter((favouriteItemId) => favouriteItemId !== id)
            this.clearCollectionLink()
        },
        removeFavourites() {
            this.favouriteItemIds = []
            this.clearCollectionLink()
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
                        items: this.itemsIds,
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
            this.itemsIds = (await axios.get(`/api/collections/${collectionId}`)).data
        },
    },
})
