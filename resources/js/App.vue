<template>
    <div class="border-black border-t-2">
        <h1 class="p-5 text-2xl">{{ $t('SNG Bookmarks') }}</h1>
    </div>
    <div class="bg-black text-white h-full">
        <div class="p-5">
            <div class="text-xl mb-4">{{ $t('Collect artworks on your visit') }}</div>
            <div>{{ $t('View them later from home. Enter code') }}</div>
        </div>
    </div>
    <div>
        <div class="max-w-screen-lg mx-auto">
          <div class="grid grid-cols-3 gap-0 border-collapse border border-black content-center">
            <CircleButton v-for="position in code.length" :is-checked="code[position - 1] == '1' ? true : false" @click="modifyCode(position)"></CircleButton>
            <div class="w-full border border-black">
                <RectangleButton @click="switchLanguage()">
                    SK/EN
                </RectangleButton>
            </div>
            <div class="w-full border border-black">
                <RectangleButton class="font-bold bg-red-500 text-white" @click="resetCode" v-if="isWrong">
                    {{ $t('Try again') }}
                </RectangleButton>
                <RectangleButton class="font-bold" :class="{'text-gray-400': !isActive}" @click="verifyCode" v-else>
                    {{ $t('Verify') }}
                </RectangleButton>
            </div>
            <div class="w-full border border-black">
                <RectangleButton>
                    {{ $t('Help') }}
                </RectangleButton>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import CircleButton from './components/CircleButton.vue'
    import RectangleButton from './components/RectangleButton.vue'
    import { getActiveLanguage, loadLanguageAsync } from 'laravel-vue-i18n';

    export default {
        components: { CircleButton, RectangleButton },
        data(){
            return {
                code: "000000000",
                isWrong: false,
                locale: 'sk'
            }
        },
        computed: {
            isActive() {
                return this.code != "000000000"
            }
        },
        created() {
            this.locale = getActiveLanguage()
        },
        methods: {
            verifyCode(event) {
                if (!this.isActive) return
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
            },
            switchLanguage() {
                this.locale = (this.locale == 'sk') ? 'en' : 'sk'
                loadLanguageAsync(this.locale)
            }
        }
    }
</script>