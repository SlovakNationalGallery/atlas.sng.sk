import { getActiveLanguage } from "laravel-vue-i18n"
export const getItemDating = (item) => getActiveLanguage() === 'sk' ? item.dating : item.dating_raw