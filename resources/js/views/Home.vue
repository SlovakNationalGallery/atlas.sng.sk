<template>
    <div class="border-black border-t-2 flex items-center">
        <div class="bg-black p-4">
            <svg class="h-10 w-10"  viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8.54668V17.0934H7.45332H14.9066V23.4533V29.8133H8.54677H2.1869L2.17911 24.5544L2.17132 19.2955L1.08566 19.2874L0 19.2793V25.6396V32H16H32V16V0H16H0V8.54668ZM14.9066 8.54668V14.9066H8.54668H2.18672V8.54668V2.18672H8.54668H14.9066V8.54668ZM29.8057 7.76901C29.81 10.8308 29.803 13.3359 29.7902 13.3359C29.7775 13.3359 27.2585 10.8273 24.1925 7.76125L18.6179 2.18659L24.2079 2.19436L29.7979 2.20212L29.8057 7.76901ZM22.6833 9.33205L28.2579 14.9066H22.6602H17.0626V9.33205C17.0626 6.26603 17.073 3.75746 17.0857 3.75746C17.0984 3.75746 19.6174 6.26603 22.6833 9.33205ZM29.8133 19.7267V22.36H24.5467H19.2801V23.4532V24.5465L24.539 24.5543L29.7979 24.5621L29.8058 27.1877L29.8136 29.8133H23.4381H17.0626V23.4739C17.0626 19.9872 17.0718 17.1252 17.0831 17.1139C17.0944 17.1026 19.9633 17.0934 23.4585 17.0934H29.8133V19.7267Z" fill="white"/>
            </svg>
        </div>
        <h1 class="p-4 text-2xl">{{ $t('SNG Bookmarks') }}</h1>
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
                <RectangleButton class="font-bold bg-red text-white" @click="resetCode" v-if="isWrong">
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
    import CircleButton from '../components/CircleButton.vue'
    import RectangleButton from '../components/RectangleButton.vue'
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
                // console.log('Code is ' + this.code + ' (' + digit + ')');
                axios.get('/api/verify/'+digit)
                    .then((response) => {
                        // console.log('Artwork is ' + response.data.data.item_id)
                        this.$router.push('/detail/' + response.data.data.item_id)
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