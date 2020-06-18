/** Card Module */
export interface ICard {
    id: number;
    name: string;
    frontSide: Array<IRecord>;
    backSide: Array<IRecord>;
    repeat?: IRepeat;
}
export interface IRecord {
    id: number;
    content: string;
}

export interface IRepeat {
    state: string;
    count: number;
    date: number;
    interval: number;
}

