import {IDeck, IDeckSettings} from "../types";

export default class Deck implements IDeck{
    description: string | null;
    id: number;
    name: string;
    settings: IDeckSettings;

    constructor() {
    }
}