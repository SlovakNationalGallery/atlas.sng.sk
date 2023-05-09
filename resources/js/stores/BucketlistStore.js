import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import axios from 'axios'

export const useBucketlistStore = defineStore('BucketlistStore', {
    state: () => ({
        bucketlists: useStorage('bucketlists', {}),
    }),
    actions: {
        get(id) {
            if (id in this.bucketlists) {
                return this.bucketlists[id]
            }
        },
        async load(id) {
            const response = await axios.get(`/api/bucketlists/${id}`)
            return (this.bucketlists[id] = response.data.data)
        },
        clearCache() {
            this.bucketlists = []
        },
    },
})
