<template>
    <Header class="mb-0.5">{{ $t('Bookmarks') }} <span class="text-gray-soft">beta</span></Header>
    <div class="bg-black text-white h-32 flex">
        <div class="p-4 pr-0 flex flex-col grow">
            <div class="text-lg mb-2">{{ $t('Enter a new artwork code') }}</div>
            <div class="flex-1 text-base">{{ $t('Collect your favorite artworks and find more info about them') }}</div>
        </div>
        <div class="w-8 h-32">
                <svg class="w-full h-full" fill="none" viewBox="0 0 20 111" preserveAspectRatio="none"><path d="M0.500001 55.5L19.25 0.0743716L19.25 110.926L0.500001 55.5Z" fill="white"/></svg>
        </div>
    </div>
    <div>
        <div class="max-w-screen-lg mx-auto">
          <div class="grid grid-cols-3 gap-0 border border-black content-center">
            <CircleButton v-for="position in code.length" :is-checked="code[position - 1] == '1' ? true : false" @click="modifyCode(position)"></CircleButton>
            <div class="w-full border border-black h-20">
                <RectangleButton @click="switchLanguage()">
                    SK/EN
                </RectangleButton>
            </div>
            <div class="w-full border border-black h-20">
                <RectangleButton class="font-bold bg-red text-white" v-if="isWrong" @click="verifyCode">
                    {{ $t('Try again') }}
                </RectangleButton>
                <RectangleButton class="font-bold" :class="isActive ? 'bg-black text-white active:bg-white active:text-black' : 'text-gray-soft'" @click="verifyCode" v-else>
                    {{ $t('Verify') }}
                </RectangleButton>
            </div>
            <div class="w-full border border-black h-20">
                <RectangleButton @click="toggleModal">
                    {{ $t('Help') }}
                </RectangleButton>
                <CardModal @close="toggleModal" :visible="modalActive"></CardModal>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    import Header from '../components/Header.vue'
    import CircleButton from '../components/CircleButton.vue'
    import RectangleButton from '../components/RectangleButton.vue'
    import CardModal from '../components/CardModal.vue'
    import { getActiveLanguage, loadLanguageAsync } from 'laravel-vue-i18n'

    export default {
        components: { Header, CircleButton, RectangleButton , CardModal },
        data(){
            return {
                code: "000000000",
                isWrong: false,
                locale: 'sk',
                modalActive: false
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
                if (this.isWrong) {
                    this.isWrong = false
                }
                const bit = (this.code[pos - 1] == '1') ? '0' : '1';
                this.code = this.code.substring(0,pos - 1) + bit + this.code.substring(pos);
            },
            switchLanguage() {
                this.locale = (this.locale == 'sk') ? 'en' : 'sk'
                loadLanguageAsync(this.locale)
            },
            toggleModal() {
                this.modalActive = !this.modalActive;
            }
        }
    }
</script>