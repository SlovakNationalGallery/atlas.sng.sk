<template>
    <div class="w-100 border-top-black">
        <h1 class="p-5 text-xl">Záložky SNG</h1>
    </div>
    <div>
        <div class="max-w-screen-lg mx-auto p-4">
          <div class="grid grid-cols-3 gap-0 mt-12 border-collapse border border-black content-center">
            <CircleButton v-for="position in code.length" :is-checked="code[position - 1] == '1' ? true : false" @click="modifyCode(position)"></CircleButton>
            <div class="w-full border border-black">
                <RectangleButton>
                    <svg class="mx-auto" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 28C22.6274 28 28 22.6274 28 16C28 9.37258 22.6274 4 16 4C9.37258 4 4 9.37258 4 16C4 22.6274 9.37258 28 16 28Z" stroke-width="2.08" stroke-miterlimit="10"/>
                    <path d="M4.68359 12H27.3167" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4.68359 20H27.3166" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 27.678C18.7614 27.678 21 22.4496 21 16.0001C21 9.55063 18.7614 4.32227 16 4.32227C13.2386 4.32227 11 9.55063 11 16.0001C11 22.4496 13.2386 27.678 16 27.678Z" stroke-width="2.08" stroke-miterlimit="10"/>
                    </svg>
                </RectangleButton>
            </div>
            <div class="w-full border border-black">
                <RectangleButton class="font-bold flex bg-red-500 text-white" @click="resetCode" v-if="isWrong">
                    <div class="m-auto">Try again :)</div>
                </RectangleButton>
                <RectangleButton class="font-bold flex" :class="{'bg-red-500 text-white': isWrong}" @click="verifyCode" v-else>
                    <div class="m-auto">Check</div>
                </RectangleButton>
            </div>
            <div class="w-full border border-black">
                <RectangleButton>
                    <svg class="mx-auto" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 28C22.6274 28 28 22.6274 28 16C28 9.37258 22.6274 4 16 4C9.37258 4 4 9.37258 4 16C4 22.6274 9.37258 28 16 28Z" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 24C16.8284 24 17.5 23.3284 17.5 22.5C17.5 21.6716 16.8284 21 16 21C15.1716 21 14.5 21.6716 14.5 22.5C14.5 23.3284 15.1716 24 16 24Z" fill="black"/>
                    <path d="M16 18V17C16.6922 17 17.3689 16.7947 17.9445 16.4101C18.5201 16.0256 18.9687 15.4789 19.2336 14.8394C19.4985 14.1999 19.5678 13.4961 19.4327 12.8172C19.2977 12.1383 18.9644 11.5146 18.4749 11.0251C17.9854 10.5356 17.3618 10.2023 16.6828 10.0673C16.0039 9.9322 15.3002 10.0015 14.6606 10.2664C14.0211 10.5313 13.4744 10.9799 13.0899 11.5555C12.7053 12.1311 12.5 12.8078 12.5 13.5" stroke-width="2.08" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </RectangleButton>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import CircleButton from './components/CircleButton.vue'
    import RectangleButton from './components/RectangleButton.vue'

    export default {
        components: { CircleButton, RectangleButton },
        data(){
            return {
                code: "000000000",
                isWrong: false,
            }
        },
        methods: {
            verifyCode(event) {
                const digit = parseInt(this.code, 2)
                console.log('Code is ' + this.code + ' (' + digit + ')');
                axios.get('/api/verify/'+digit)
                    .then((response) => {
                        alert('Artwork is ' + response.data.data.item_id)
                    })
                    .catch( resonse => {
                        this.isWrong = true
                    })
            },
            modifyCode(pos) {
                const bit = (this.code[pos - 1] == '1') ? '0' : '1';
                this.code = this.code.substring(0,pos - 1) + bit + this.code.substring(pos);
            },
            resetCode() {
                this.code = "000000000"
                this.isWrong = false
            }
        }
    }
</script>