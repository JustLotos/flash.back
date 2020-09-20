export class Locale {
    private _language: string;

    constructor() {
        this._language = 'ru';
    }

    get getLocale(): string {
        const cookieLanguage = this._language;
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

        return process.env.LOCALE;
    }

    get getMessages() {
        return {
            // en: {
            //     ...enLocale,
            //     ...elementEnLocale
            // }
        }
    }

    get language(): string {
        return this._language;
    }

    set language(value: string) {
        this._language = value;
        return this;
    }
}