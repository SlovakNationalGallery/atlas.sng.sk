import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage } from '@vueuse/core'

export const usePlaceStore = defineStore('PlaceStore', {
    state: () => ({
        places: useStorage('places', {}),
    }),
    actions: {
        get(id) {
            if (id in this.places) {
                return this.places[id]
            }
        },
        async load(id) {
            const response = await axios.get(`/api/places/${id}`)
            return (this.places[id] = response.data.data)
        },
        clearCache() {
            this.places = {}
        },
    },
})
