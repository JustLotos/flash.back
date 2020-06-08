import Vue from 'vue';
import VueI18n from 'vue-i18n';
import enLocale from './Locales/en';
import elementEnLocale from 'element-ui/lib/locale/lang/en';
import {getLanguage} from "../Cookies";

Vue.use(VueI18n);

const messages = {
    en: {
        ...enLocale,
        ...elementEnLocale
    }
};

export const getLocale = () => {
    const cookieLanguage = getLanguage();
    if (cookieLanguage) {
        return cookieLanguage;
    }

    const language = navigator.language.toLowerCase()
    const locales = Object.keys(messages)
    for (const locale of locales) {
        if (language.indexOf(locale) > -1) {
            return locale;
        }
    }

    return 'en';
};

const i18n = new VueI18n({
    locale: getLocale(),
    messages
});

export default i18n;