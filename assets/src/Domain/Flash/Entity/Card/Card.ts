import {ICard, IRecord} from "./types";

export default class Card implements ICard{
    backSide: Array<IRecord>;
    frontSide: Array<IRecord>;
    id: number;
    name: string;
    repeat: IRepeat;

    constructor(backSide: Array<IRecord>, frontSide: Array<IRecord>, name: string)
    {
        this.backSide = backSide;
        this.frontSide = frontSide;
        this.name = name;
    }


    get getDefaultCard(): Card {
        return new Card(
            [{id: -1, content: ''}],
            [{id: -1, content: ''}],
            '',
        );
    }

    set setRepeat(repeat: IRepeat) {
        this.repeat = repeat;
    }

    set setId(id: number) {

    }
}